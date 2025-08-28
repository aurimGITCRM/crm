<?php

namespace App\Models;

use CodeIgniter\Model;

class AppuntamentiModel extends Model
{
    protected $db;
    protected $table = 'appuntamenti';

    //protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = false;

    protected function initialize()
    {
        $this->db = db_connect();
    }

    public function getApp($campid = null,$contid = null,$idutente = null,$data_inizio = null,$data_fine = null)
    {
        $sql = "SELECT a.*,CONCAT(u.nome,' ',u.cognome) AS nome_cognome_vdt FROM appuntamenti a INNER JOIN utenti u ON a.idUtente_Fk_ext = u.id WHERE 1=1";
        if(!empty($campid)) $sql .= " AND campId_FK = " . $campid;
        if(!empty($contid)) $sql .= " AND contId_FK = " . $contid;
        if(!empty($idutente)) $sql .= " AND a.idUtente_Fk = " . $idutente;
        if(!empty($data_inizio) && !empty($data_fine)) $sql .= " AND data_ora_app >= '" . $data_inizio . "' AND data_ora_app <= '" . $data_fine . "'";

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function InsertApp($data)
    {
        $builder = $this->db->table('appuntamenti');
        $builder->set($data);
        $builder->insert();
    }

    public function UpdateApp($dataupd,$where)
    {
        $builder = $this->db->table('appuntamenti');
        $builder->set($dataupd);
        $builder->where($where);
        $builder->update();
    }

    public function DeleteApp($id = NULL)
    {
        $builder = $this->db->table('appuntamenti')->where("idApp",$id);
        $builder->delete();
    }

    //Prendo gli appuntamenti che hanno la data il giorno dopo o mezz'ora dopo di oggi o data e ora odierna
    public function getContattiAppuntamentiMailPromemoria()
    {
        $sql = "SELECT *,
        CASE WHEN (CURRENT_DATE = DATE(data_ora_app - INTERVAL 1 DAY) AND sent_date_before = 0) THEN 'DAY_BEFORE' ELSE 'MINUTES_BEFORE' END AS type
        FROM `appuntamenti` A INNER JOIN contatti_webinvista C ON A.contId_Fk = C.contId
        WHERE ((CURRENT_DATE = DATE(data_ora_app - INTERVAL 1 DAY) AND sent_date_before = 0)
        OR
        CONCAT(DATE(CURRENT_TIMESTAMP),' ',RIGHT(CONCAT('00',HOUR(CURRENT_TIMESTAMP)),2),':',RIGHT(CONCAT('00',MINUTE(CURRENT_TIMESTAMP)),2)) = data_ora_app- INTERVAL 30 MINUTE
        )";

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }
}