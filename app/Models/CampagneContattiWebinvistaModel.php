<?php

namespace App\Models;

use CodeIgniter\Model;

class CampagneContattiWebinvistaModel extends Model
{
    protected $db;
    protected $table         = 'attivita';
    protected $campagneModel;

    protected function initialize()
    {
        $this->db = db_connect();
        $this->campagneModel = new CampagneModel();
    }

    // CAMPAGNE CONTATTI WEBINVISTA 
    public function getCampagneContattiWebinvista($campId,$idesito = null,$idutente = null,$contid = null)
    {
        $sql = "SELECT CC.*,C.*,nomeEsito,P.nome AS prodotto FROM campagne_contatti_webinvista CC
        INNER JOIN contatti_webinvista C ON CC.contId_Fk = C.contId
        LEFT JOIN esiti E ON E.idEsito = CC.idEsito_Fk
        LEFT JOIN prodotti P ON CC.prodId_Fk = P.prodid
        WHERE 1 = 1 AND CC.campId_Fk = " . $campId;

        if(!empty($idesito))
            $sql .= " AND CC.idEsito_Fk = " . $idesito;

        if(!empty($idutente))
            $sql .= " AND CC.campcontBloccatoIdUtente_Fk = " . $idutente;

        if(!empty($contid))
            $sql .= " AND CC.contId_Fk = " . $contid;

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function getCampagneContattiWebinvistaUtente($campid,$idutente)
    {
        $sql = "SELECT * FROM campagne_contatti_webinvista WHERE campId_FK = " . $campid;
        $sql .= " AND campcontBloccatoIdUtente_Fk = " . $idutente;
        $sql .= " AND campcontBloccatodata IS NOT NULL";
        $sql .= " AND COALESCE(Idesito_Fk,'') = ''";
        $sql .= " AND campcontEsitodata IS NULL";
        $sql .= " AND campcontEsitatoIdUtente_Fk IS NULL";
        $sql .= " ORDER BY campcontBloccatodata DESC";
        $sql .= " LIMIT 0,1"; 

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function getCampagneContattiWebinvistaLibero($campid)
    {
        $sql = "SELECT * FROM campagne_contatti_webinvista CC INNER JOIN contatti_webinvista C ON CC.contId_Fk = C.contId WHERE campId_FK = " . $campid;
        $sql .= " AND campcontBloccatoIdUtente_Fk IS NULL";
        $sql .= " AND campcontBloccatodata IS NULL";
        $sql .= " AND Idesito_Fk IS NULL";
        $sql .= " AND campcontEsitodata IS NULL";
        $sql .= " AND campcontEsitatoIdUtente_Fk IS NULL";
        
        $dataatt = [];
        $dataatt = $this->campagneModel->getAttivitaCampagne($dataatt,$campid);
        if(sizeof($dataatt) > 0 && sizeof($dataatt['attivita_campagne']) > 0)
            $sql .= " AND C.attId_Fk IN (SELECT attId_FK FROM campagne_attivita WHERE campId_Fk = " . $campid . ")";

        $sql .= " ORDER BY campcontUIOrdinam";
        $sql .= " LIMIT 0,1"; 

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function getEsitiCampagna($campId)
    {
        $sql = "SELECT E.idEsito,E.nomeEsito FROM esiti E INNER JOIN campagne_esiti CE ON E.idEsito = CE.idEsito_Fk WHERE campid_Fk = " . $campId;
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    //Funzione che aggiorna il contatto nella tabella "campagne_contatti_webinvista"
    public function setCampagneContattiWebinvista($data,$data_upd)
    {
        $builder = $this->db->table('campagne_contatti_webinvista');
        $where = ['campId_Fk' => $data['campId'],'contId_Fk' => $data['cont_id_update']];

        $builder->set($data_upd);
        $builder->where($where);
        $builder->update();
    }

    public function getContattiAlertRinnovoPlugin()
    {
        $sql = "SELECT * FROM `contatti_webinvista` WHERE ultimo_agg_plugin IS NOT NULL";
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function getContattiAlertScadenzaRinnovo()
    {
        $sql = "SELECT * FROM contatti_webinvista WHERE data_registrazione_dominio IS NOT NULL AND rinnovo_dominio = 1";
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }
}