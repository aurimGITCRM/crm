<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $db;
    protected $table = 'province';
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
        $query = $this->db->query('SELECT provId,provNome FROM province WHERE provNome LIKE "%' . $str . '%"');
        $data['province'] = [];
        foreach ($query->getResult('array') as $row) 
        {
            $data['province'][] = array('provId'=>$row['provId'],'provNome'=>$row['provNome']);
        }
        return $data;
    }
}