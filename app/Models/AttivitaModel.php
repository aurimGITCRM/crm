<?php

namespace App\Models;

use CodeIgniter\Model;

class AttivitaModel extends Model
{
    protected $db;
    protected $table         = 'attivita';
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
        $query = $this->db->query('SELECT id,nome FROM attivita WHERE nome LIKE "%' . $str . '%"');
        $data['att'] = [];
        foreach ($query->getResult('array') as $row) 
        {
            $data['att'][] = array('id'=>$row['id'],'nome'=>$row['nome']);
        }
        return $data;
    }

    //funzione che prende gli utenti
    public function getAttivita($search = null)
    {
        $data = array();
        $data['attivita'] = [];
        $data['title']='Attività';
        $query = $this->db->query('SELECT * FROM attivita WHERE 1=1' . (!empty($search) ? " AND id = " . $search : ""));

        foreach ($query->getResult('array') as $row) 
        {
            $data['attivita'][] = array('id'=>$row['id'],'nome'=>$row['nome']);
        }

        return $data;
    }

    //funzione che se passato id prende l'utente con id corrispondente
    public function get_att($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento attività';
        $data['attivita']=array('id'=>'','nome'=>'');

        if(isset($id) && !empty($id))
        {
            $data['title'] = 'Modifica attività';
            $query = $this->db->query('SELECT * FROM attivita WHERE id = ' . $id);
            $data['attivita'] = $query->getResult('array')[0];
        }

        return $data;
    }

    //funzione che modifica l'utente se passato id update altrimenti insert
    public function modify_att($data)
    {
        $builder = $this->db->table('attivita');
        $id = $data['id_update'];

        $data = array(
            'nome' => $data['name'],
            'idUtente_fk' => 15
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
    public function delAtt($id = NULL)
    {
        $builder = $this->db->table('attivita')->where("id",$id);
        $builder->delete();
    }
}