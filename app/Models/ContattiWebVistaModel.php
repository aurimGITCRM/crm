<?php

namespace App\Models;

use CodeIgniter\Model;

class ContattiWebVistaModel extends Model
{
    protected $db;
    protected $table = 'contatti_webinvista';
    protected $allowedFields = [
        'id','nome', 'cognome', 'date',
    ];
    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    public function getContatti($id = null,$attId = null)
    {
        $data = array();
        $data['contatti'] = [];
        $data['title']='Contatti Webinvista';
        $sql = "SELECT C.*,A.nome AS nome_attivita,T.tipologia AS nome_tipologia,CONCAT(U.nome,' ',U.cognome) AS utente FROM contatti_webinvista C";
        $sql .= " INNER JOIN tipologia T ON T.id = C.tipologiaId_Fk";
        $sql .= " INNER JOIN attivita A ON A.id = C.attId_Fk";
        $sql .= " INNER JOIN utenti U ON U.id = C.idUtente_Fk";
        
        $sql .= " WHERE 1=1";
        
        if(!empty($id))
            $sql .= " AND C.contId = " . $id;

        if(!empty($attId))
            $sql .= " AND A.id = " . $id;

        return $sql;

        $query = $this->db->query($sql);

        foreach ($query->getResult('array') as $row) 
        {
            $data['contatti'][] = array(
                'contId'=>$row['contId'],
                'tipologiaId_Fk' => $row['tipologiaId_Fk'],
                'nome_tipologia' => $row['nome_tipologia'], 
                'attId_Fk' => $row['attId_Fk'],
                'nome_attivita'=>$row['nome_attivita'],
                'utente'=>$row['utente'],
                'ragione_sociale' => $row['ragione_sociale'],
                'indirizzo' => $row['indirizzo'],
                'comune'=>$row['comune'],
                'cap'=>$row['cap'],
                'provincia'=>$row['provId_Fk'],
                'telefono'=>$row['telefono'],
                'cellulare'=>$row['cellulare'],
                'email'=>$row['email'],
                'referente'=>$row['referente'],
                'piva'=>$row['piva'],
                'cf'=>$row['cf'],
                'dominio'=>$row['dominio'],
                'user_dominio'=>$row['user_dominio'],
                'pwd_dominio'=>$row['pwd_dominio'],
                'email_1'=>$row['email_1'],
                'pwd_email_1'=>$row['pwd_email_1'],
                'email_2'=>$row['email_2'],
                'pwd_email_2'=>$row['pwd_email_2'],
                'email_3'=>$row['email_3'],
                'pwd_email_3'=>$row['pwd_email_3'],
                'user_wp'=>$row['user_wp'],
                'pwd_wp'=>$row['pwd_wp'],
                'ruolo_wp'=>$row['ruolo_wp'],
                'ultimo_agg_plugin'=>$row['ultimo_agg_plugin'],
                'data_registrazione_dominio'=>$row['data_registrazione_dominio'],
                'data_scadenza_dominio'=>$row['data_scadenza_dominio'],
                'rinnovo_dominio'=> $row['rinnovo_dominio'],
                'data'=>$row['data'],
            );
        }

        return $data;
    }

    //funzione che se passato id prende il contatto con id corrispondente
    public function get_contatto($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento contatto';
        $data['contatto'] = array(
            'contId'=>"",
            'nome_attivita'=>"",
            'utente'=>"",
            'ragione_sociale' => "",
            'indirizzo' => "",
            'comune'=>"",
            'cap'=>"",
            'provincia'=>"",
            'telefono'=>"",
            'cellulare'=>"",
            'email'=>"",
            'referente'=>"",
            'piva'=>"",
            'cf'=>"",
            'dominio'=>"",
            'user_dominio'=>"",
            'pwd_dominio'=>"",
            'email_1'=>"",
            'pwd_email_1'=>"",
            'email_2'=>"",
            'pwd_email_2'=>"",
            'email_3'=>"",
            'pwd_email_3'=>"",
            'user_wp'=>"",
            'pwd_wp'=>"",
            'ruolo_wp'=>"",
            'ultimo_agg_plugin'=>"",
            'data_registrazione_dominio'=>"",
            'data_scadenza_dominio'=>"",
            'rinnovo_dominio'=> "",
            'data'=>"",
        ); 

        if(isset($id) && !empty($id))
        {
            echo $this->getContatti($id);die;
            $data['contatto'] = $this->getContatti($id)['contatti'][0];
            $data['title']='Modifica contatto';
        }

        return $data;
    }

    //funzione che modifica se passato id update altrimenti insert
    public function modify_contatto($data,$data_ins = null)
    {
        $builder = $this->db->table('contatti_webinvista');
        $id = $data['id_update'] ?? "";
        
        if(empty($data)) 
            $id = null;
        else
        {
            $data = array(
            'tipologiaId_Fk' => $data['tipologiaId_Fk'],
            'attId_Fk' => $data['attId_Fk'],
            'ragione_sociale' => $data['ragione_sociale'],
            'indirizzo' => $data['indirizzo'],
            'comune'=> $data['comune'],
            'cap'=>$data['cap'],
            'provId_Fk'=>$data['provincia'],
            'telefono'=>$data['telefono'],
            'cellulare'=>$data['cellulare'],
            'email'=>$data['email'],
            'referente'=>$data['referente'],
            'piva'=>$data['piva'],
            'cf'=>$data['cf'],
            'dominio'=>$data['dominio'],
            'user_dominio'=>$data['user_dominio'],
            'pwd_dominio'=>$data['pwd_dominio'],
            'email_1'=>$data['email_1'],
            'pwd_email_1'=>$data['pwd_email_1'],
            'email_2'=>$data['email_2'],
            'pwd_email_2'=>$data['pwd_email_2'],
            'email_3'=>$data['email_3'],
            'pwd_email_3'=>$data['pwd_email_3'],
            'user_wp'=>$data['user_wp'],
            'pwd_wp'=>$data['pwd_wp'],
            'ruolo_wp'=>$data['ruolo_wp'],
            'ultimo_agg_plugin'=>$data['ultimo_agg_plugin'],
            'data_registrazione_dominio'=>$data['data_registrazione_dominio'],
            'data_scadenza_dominio'=>$data['data_scadenza_dominio'],
            'rinnovo_dominio'=> intval($data['rinnovo_dominio'] ?? "0"),
            'idUtente_Fk' => 15
            //'data'=>$data['data']
        );
        }

        


        $builder->set($data);
        
        //aggiornamento o inserimento 
        if(!empty($id))
        {
            $builder->where('contId', $id);
            $builder->update();
        }
        else
        {   
            if(!empty($data_ins))
                $builder->set($data_ins);

            $builder->insert();
        }
            
    }

    //funzione che cancella l'utente con id passato 
    public function delCont($id = NULL)
    {
        $builder = $this->db->table('contatti_webinvista')->where("contId",$id);
        $builder->delete();
    }
}