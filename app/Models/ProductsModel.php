<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $db;
    protected $table = 'products';

    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    public function getMacroProducts($id = null)
    {
        $query = $this->db->query('SELECT * FROM prodotti_macro WHERE 1=1' . (!empty($id) ?  ' AND macroId = ' . $id : ""));
        return $query->getResult('array');
    }

    public function InsertMacroProducts($data)
    {
        $builder = $this->db->table('prodotti_macro');
        $builder->set($data);
        $builder->insert();
    }

    public function UpdateMacroProducts($dataupd,$where)
    {
        $builder = $this->db->table('prodotti_macro');
        $builder->set($dataupd);
        $builder->where($where);
        $builder->update();
    }

    public function DeleteMacroProducts($id = NULL)
    {
        $builder = $this->db->table('prodotti_macro')->where("macroId",$id);
        $builder->delete();
    }

    public function getProducts($id = null,$macro = null)
    {
        $sql = 'SELECT * FROM prodotti WHERE 1=1 ';
        
        if(!empty($id)) $sql .= " AND prodId = " . $id;
        if(!empty($macro)) $sql .= " AND macroId_Fk = " . $macro;
      
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function InsertProducts($data)
    {
        $builder = $this->db->table('prodotti');
        $builder->set($data);
        $builder->insert();
    }

    public function UpdateProducts($dataupd,$where)
    {
        $builder = $this->db->table('prodotti');
        $builder->set($dataupd);
        $builder->where($where);
        $builder->update();
    }

    public function DeleteProducts($id = NULL)
    {
        $builder = $this->db->table('prodotti')->where("prodId",$id);
        $builder->delete();
    }
}