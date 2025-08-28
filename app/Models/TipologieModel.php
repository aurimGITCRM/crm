<?php

namespace App\Models;

use CodeIgniter\Model;

class TipologieModel extends Model
{
    protected $db;
    protected $table         = 'tipologia';
    protected $allowedFields = [
        'id','nome', 'cognome', 'date',
    ];
    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    public function search($str)
    {
        $query = $this->db->query('SELECT id,tipologia FROM tipologia WHERE tipologia LIKE "%' . $str . '%"');
        $data['type'] = [];
        foreach ($query->getResult('array') as $row) 
        {
            $data['type'][] = array('id'=>$row['id'],'tipologia'=>$row['tipologia']);
        }
        return $data;
    }

    //funzione che prende gli utenti
    public function getTipologia($search = null)
    {
        $data = array();
        $data['tipologia'] = [];
        $data['title']='Tipologia';
        $query = $this->db->query('SELECT * FROM tipologia WHERE 1=1' . (!empty($search) ? " AND id = " . $search : ""));

        foreach ($query->getResult('array') as $row) 
        {
            $data['tipologia'][] = array('id'=>$row['id'],'tipologia'=>$row['tipologia']);
        }

        return $data;
    }

    //funzione che se passato id prende l'utente con id corrispondente
    public function get_tipologia($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento tipologia';
        $data['tipologia']=array('id'=>'','tipologia'=>'');

        if(isset($id) && !empty($id))
        {
            $data['title'] = 'Modifica tipologia';
            $query = $this->db->query('SELECT * FROM tipologia WHERE id = ' . $id);
            $data['tipologia'] = $query->getResult('array')[0];
        }

        return $data;
    }

    //funzione che modifica l'utente se passato id update altrimenti insert
    public function modify_tipologia($data)
    {
        $builder = $this->db->table('tipologia');
        $id = $data['id_update'];

        $data = array(
            'nome' => $data['tipologia'],
        );
        
        $builder->set($data);
        
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
    public function delTipologia($id = NULL)
    {
        $builder = $this->db->table('tipologia')->where("id",$id);
        $builder->delete();
    }
}