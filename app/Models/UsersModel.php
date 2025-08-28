<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $db;
    protected $table         = 'utenti';
    protected $allowedFields = [
        'id','nome', 'cognome', 'date',
    ];
    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    public function login($username, $password) 
    {
        $sql = "SELECT * FROM utenti WHERE username = " . $this->db->escape($username);
        $sql .= " AND password = '" . hash('sha512', $this->db->escape($password)) . "'";
        $sql .= " AND attivo = 1 LIMIT 0,1";
        
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function search($str)
    {
        $query = $this->db->query('SELECT id,nome,cognome FROM utenti WHERE CONCAT(nome,cognome) LIKE "%' . $str . '%"');
        $data['users'] = [];
        foreach ($query->getResult('array') as $row) 
        {
            $data['users'][] = array('id'=>$row['id'],'nome'=>$row['nome'],'cognome'=>$row['cognome']);
        }
        return $data;
    }

    //funzione che prende gli utenti
    public function getUsers($search = null)
    {
        $data = array();
        $data['title']='Utenti';
        $query = $this->db->query('SELECT * FROM utenti WHERE 1=1' . (!empty($search) ? " AND id = " . $search : ""));

        foreach ($query->getResult('array') as $row) 
        {
            $data['users'][] = array('id'=>$row['id'],'nome'=>$row['nome'],'cognome'=>$row['cognome'],'sesso' => $row['sesso'],'email' => $row['email'],'data_modifica'=>$row['data_modifica']);
        }

        return $data;
    }

    //funzione che se passato id prende l'utente con id corrispondente
    public function get_user($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento utente';
        $data['user']=array('tipo'=>'','id'=>'','nome'=>'','cognome'=>'','sesso' => '','email'=>'',);

        if(isset($id) && !empty($id))
        {
            $data['title'] = 'Modifica utente';
            $query = $this->db->query('SELECT * FROM utenti WHERE id = ' . $id);
            $data['user'] = $query->getResult('array')[0];
        }

        return $data;
    }

    public function modify_pwd_user($id,$password)
    {
        $builder = $this->db->table('utenti');
        $data_upd['password'] = hash('sha512',$this->db->escape($password));
        $builder->set($data_upd);
        $builder->where('id', $id);
        $builder->update();
    }

    //funzione che modifica l'utente se passato id update altrimenti insert
    public function modify_user($data)
    {
        $builder = $this->db->table('utenti');
        $id = $data['id_update'];

        $data_ins = array(
            'tipo' => $data['tipo'],
            'username' => $data['username'],
            'nome' => $data['name'],
            'cognome'  => $data['surname'],
            'sesso' => $data['sesso'],
            'email' => $data['email'],
            'data_scadenza' => $data['data_scadenza']
        );

        if(empty($id))
            $data_ins['password'] = hash('sha512',$this->db->escape($data['password']));
        
        $builder->set($data_ins);
        
        //aggiornamento o inserimento 
        if(!empty($id))
        {
            $builder->where('id', $id);
            $builder->update();
        }
        else
            $builder->insert();
    }

    //funzione che cancella l'utente con id passato 
    public function delUser($id = NULL)
    {
        $builder = $this->db->table('utenti')->where("id",$id);
        $builder->delete();
    }

    //funzione che restituisce l'elenco dei file PDF 
    public function getListaFilePdf()
    {
        $data = array();
        $data['listafilepdf'] = array('1'=>'prova1.pdf','2'=>'prova2.pdf','3'=>'ricerca.pdf','4'=>'rossana.pdf');
        return $data;
    }

    public function getUtentiPartitionBy($table,$search = array())
    {
        $campi = "";
        $data = array();
        $data['title']='Utenti';

        if(sizeof($search) > 0)
        {
            foreach($search AS $sc)
                $campi .= "TRIM(" . $sc . ")" . ",";
            
            if(strlen($campi) > 0) $campi = substr($campi,0,strlen($campi)-1);
        }

        $sql = "SELECT rn,A.* FROM 
                (
                    SELECT U.*,
                    @r := CASE 
                        WHEN CONCAT(" . $campi . ") = @prevcol THEN @r + 1 
                        WHEN (@prevcol := CONCAT(" . $campi . ")) = null THEN null
                        ELSE 1 END AS rn
                    FROM " . $table . " AS U,
                    (SELECT @rownum := 0,@prevcol := null) r
                    ORDER BY CONCAT(" . $campi . ")
                ) A";

        $query = $this->db->query($sql);
        foreach ($query->getResult('array') as $row) 
            $data['users'][] = array('rn' => $row['rn'],'id'=>$row['id'],'nome'=>$row['nome'],'cognome'=>$row['cognome'],'email' => $row['email'],'provincia'=> $row['provincia'],'date'=>$row['date']);

        return $data;
    }

    public function reset_pwd($id)
    {
        $builder = $this->db->table('utenti');
        $data_ins['password'] = hash('sha512',$this->db->escape("cambiami"));
        $builder->set($data_ins);
        $builder->where('id', $id);
        $builder->update();
    }

    //venditori delle campagne di vendita dello stesso macroprodotto
    public function getVenditoriCampagneVenditaMacroProdottoSchedatura($campid,$macroid)
    {
        $sql = "SELECT U.id,CONCAT(nome,' ',cognome) AS nome_cognome FROM `utenti` U
        INNER JOIN campagne_utenti CU ON CU.idUtente_Fk = U.id
        INNER JOIN campagne C ON CU.campid_Fk = C.campId
        INNER JOIN campagne_macroprodotti CM ON CM.campid_Fk = C.campId
        WHERE U.tipo = 'venditore'
        AND CM.macroId_Fk = " . $macroid . " AND CM.campid_Fk = " . $campid;

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }
}