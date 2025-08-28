<?php

namespace App\Models;

use CodeIgniter\Model;

class EsitiModel extends Model
{
    protected $db;
    protected $table         = 'esiti';
    protected $allowedFields = [
        'id','nome', 'cognome', 'date',
    ];
    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    //funzione che prende le campagne
    public function getEsiti()
    {
        $data = array();
        $data['title']='Esiti';
        $query = $this->db->query('SELECT E.*,CONCAT(U.nome," ",U.cognome) AS utente FROM esiti E INNER JOIN utenti U WHERE U.id = E.idUtente_Fk');
        $data['esiti'] = [];

        foreach ($query->getResult('array') as $row) 
        {
            $data['esiti'][] = array(
                'idEsito'=>$row['idEsito'],
                'nomeEsito'=>$row['nomeEsito'],
                'utente' => $row['utente'],
                'data' => $row['data'],
            );
        }

        return $data;
    }

    //funzione che se passato id prende l'esito con id corrispondente
    public function get_esito($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento esito';
        $data['esito']=array('idEsito'=>'','nomeEsito'=>'','idUtente_Fk' => '','data'=>'');

        if(isset($id) && !empty($id))
        {
            $data['title'] = 'Modifica campagna';
            $query = $this->db->query('SELECT * FROM esiti E INNER JOIN utenti U WHERE U.id = E.idUtente_Fk AND E.idEsito = ' . $id);
            $data['esito'] = $query->getResult('array')[0];
        }

        return $data;
    }

    //funzione che modifica la campagna se passato id update altrimenti insert
    public function modify_esito($data)
    {
        $builder = $this->db->table('esiti');
        $id = $data['id_update'];

        $data_upd = array(
            'nomeEsito' => $data['name'],
            'idUtente_Fk'  => 15,
            'data' => date('Y-m-d H:i:s'),
        );
        
        $builder->set($data_upd);
        
        //aggiornamento o inserimento 
        if(!empty($id))
        {
            $builder->where('idEsito', $id);
            $builder->update();
        }
        else
            $builder->insert();
    }

    //funzione che cancella l'utente con id passato 
    public function delEsito($id = NULL)
    {
        $builder = $this->db->table('esiti')->where("idEsito",$id);
        $builder->delete();
    }
}