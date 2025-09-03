<?php

namespace App\Models;

use CodeIgniter\Model;

class CampagneModel extends Model
{
    protected $db;
    protected $table         = 'campagne';
    protected $table_campagne_contatti_webinvista = 'campagne_contatti_webinvista';
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
    public function getCampagne()
    {
        $data = array();
        $data['title']='Campagne';
        $query = $this->db->query('SELECT C.*,CONCAT(U.nome," ",U.cognome) AS utente FROM campagne C INNER JOIN utenti U WHERE U.id = C.idUtente_Fk');
        $data['campagne'] = [];

        foreach ($query->getResult('array') as $row) 
        {
            $data['campagne'][] = array(
                'campId'=>$row['campId'],
                'campNome'=>$row['campNome'],
                'campTipo'=>$row['campTipo'],
                'utente' => $row['utente'],
                'data' => $row['data'],
            );
        }

        return $data;
    }

    //funzione che se passato id prende la campagna con id corrispondente
    public function get_campagna($id = NULL)
    {
        $data = array();
        $data['title']='Inserimento campagna';
        $data['campagna']=array('campId'=>'','campNome'=>'','campTipo'=>'','idUtente_Fk' => '','data'=>'',);

        if(isset($id) && !empty($id))
        {
            $data['title'] = 'Modifica campagna';
            $query = $this->db->query('SELECT * FROM campagne C INNER JOIN utenti U WHERE U.id = C.idUtente_Fk AND C.campId = ' . $id);
            $data['campagna'] = $query->getResult('array')[0];
        }

        return $data;
    }

    //funzione che modifica la campagna se passato id update altrimenti insert
    public function modify_campagna($data)
    {
        $builder = $this->db->table('campagne');
        $id = $data['id_update'];

        $data_upd = array(
            'campNome' => $data['name'],
            'campTipo' => $data['tipo'],
            'idUtente_Fk'  => $_SESSION['user_login']['id'],
            'data' => date('Y-m-d H:i:s'),
        );
        
        $builder->set($data_upd);
        
        //aggiornamento o inserimento 
        if(!empty($id))
        {
            $builder->where('campId', $id);
            $builder->update();
        }
        else
            $builder->insert();
    }

    //funzione che cancella l'utente con id passato 
    public function delCamp($id = NULL)
    {
        $builder = $this->db->table('campagne')->where("campId",$id);
        $builder->delete();
    }

    //campagne_utenti 
    public function get_campagne_utenti($data,$campId = null,$utente = null)
    {
        $data['campagne_utenti'] = [];
        $data['utentinonassociati'] = [];
        $sql = "SELECT CU.*,C.campNome,CONCAT(U.nome,' ',U.cognome) AS utente,C.campTipo FROM campagne_utenti CU INNER JOIN campagne C INNER JOIN utenti U WHERE CU.campId_Fk = C.campId AND CU.idUtente_Fk = U.id";

        if(!empty($campId))
        {
            $sql .= " AND CU.campId_fk = " . $campId;

            //prendo gli utenti non associati del tipo corrispondente al tipo di campagna
            $sqlcamp = "SELECT campTipo FROM campagne WHERE campId = " . $campId;
            $querycamp = $this->db->query($sqlcamp);
            $data['utentinonassociati'] =  $this->getUtentiNonAssociatiCampagna($campId,$querycamp->getResult('array')[0]['campTipo']);
        }
            
        if(!empty($utente))
            $sql .= " AND CU.idUtente_Fk = " . $utente;

        $query = $this->db->query($sql);

        foreach ($query->getResult('array') as $row) 
        {
            $data['campagne_utenti'][] = array(
                'campId'=>$row['campid_Fk'],
                'campNome'=>$row['campNome'],
                'idUtente_Fk'=>$row['idUtente_Fk'],
                'utente'=>$row['utente'],
            );
        }

        return $data;
    }

    public function insert_campagne_utenti($data)
    {
        $builder = $this->db->table('campagne_utenti');
        $builder->set($data);
        $builder->insert();
    }

    //funzione che cancella l'utente della campagna con id passati 
    public function delCampagneUtenti($campid = NULL,$idutente = null)
    {
        $where = [];
        if(!empty($campid)) $where['campid_Fk'] = $campid;
        if(!empty($idutente)) $where['idUtente_Fk'] = $idutente;

        $builder = $this->db->table('campagne_utenti')->where($where);
        $builder->delete();
    }

    //prendo gli utenti non associati alla campagna del tipo di campagna passato
    private function getUtentiNonAssociatiCampagna($campId,$tipo)
    {
        $tiposql = "";
        switch($tipo)
        {
            case 'schedatura':
                $tiposql = 'schedatore';
                break;
            case 'vendita':
                $tiposql = 'venditore';
                break;
            case 'lavorazione':
                $tiposql = 'lavoratore';
                break;
        }

        $sql = "SELECT id,CONCAT(nome,' ',cognome) AS utente FROM `utenti` WHERE 1=1";
        if(!empty($tiposql)) $sql .= " AND tipo = '" . $tiposql . "'";
        $sql .= " AND id NOT IN (SELECT idUtente_Fk FROM campagne_utenti WHERE campId_FK = " . $campId . ")";

        $query = $this->db->query($sql);

        $utenti = [];
        $utenti['dati'] =  $query->getResult('array');

        $sqlcamp = "SELECT campId,campNome FROM campagne WHERE campId = " . $campId;
        $querycamp = $this->db->query($sqlcamp);
        $utenti['campId'] = $querycamp->getResult('array')[0]['campId'];
        $utenti['campNome'] = $querycamp->getResult('array')[0]['campNome'];
        return $utenti;
    }
    //***************************************************************************** */
    //campagne esiti destinazioni
    public function get_campagne_esiti_destinazioni($campId,$idesito)
    {
        $sql = "SELECT CED.*,CA.campId AS campidorig,CA.campNome AS campnomeorig,E.idEsito AS esitoidorig,E.nomeEsito AS esitonomeorig  
        ,CAD.campId AS campiddest,CAD.campNome AS campnomedest
        ,ED.idEsito AS esitoiddest,ED.nomeEsito AS esitonomedest
        ,U.id AS idutentedest,CONCAT(U.nome,' ',U.cognome) AS nomeutentedest
        ,CONCAT(UM.nome,' ',UM.cognome) AS nomeutentemod
        FROM `campagne_esiti_destinazioni` CED
        INNER JOIN campagne CA ON CED.campId_Fk = CA.campId
        INNER JOIN campagne CAD ON CED.campId_Fk_dest = CAD.campId
        INNER JOIN esiti E ON CED.Idesito_Fk = E.idEsito
        INNER JOIN utenti UM ON CED.idUtente_Fk_modifica = UM.id
        LEFT JOIN esiti ED ON CED.Idesito_Fk_dest = ED.idEsito
        LEFT JOIN utenti U ON CED.idUtente_Fk_dest = U.id
        WHERE CED.campId_Fk = " . $campId  . " AND CED.Idesito_Fk = " . $idesito;

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function insert_campagne_esiti_destinazioni($data)
    {
        $builder = $this->db->table('campagne_esiti_destinazioni');
        $builder->set($data);
        $builder->insert();
    }

    public function update_campagne_esiti_destinazioni($dataupd,$where)
    {
        $builder = $this->db->table('campagne_esiti_destinazioni');
        $builder->set($dataupd);
        $builder->where($where);
        $builder->update();
    }

    public function delCampagneEsitiDestinazioni($campid,$idesito,$campId_Fk_dest)
    {
        $builder = $this->db->table('campagne_esiti_destinazioni')->where(["campid_Fk" => $campid,"Idesito_Fk" => $idesito,"campId_Fk_dest" => $campId_Fk_dest]);
        $builder->delete();
    }
    //***************************************************************************** 
    //campagne_esiti
    public function get_campagne_esiti($data,$campId = null,$esito = null)
    {
        $data['esiti_campagne'] = [];
        $data['esitinonassociati'] = [];
        $sql = "SELECT CE.*,C.campNome,E.nomeEsito FROM campagne_esiti CE INNER JOIN campagne C INNER JOIN esiti E WHERE CE.campId_Fk = C.campId AND CE.idEsito_Fk = E.idEsito";

        if(!empty($campId))
        {
            $sql .= " AND CE.campId_fk = " . $campId;

            //prendo gli esiti non associati
            $data['esitinonassociati'] =  $this->getEsitiNonAssociatiCampagna($campId);
        }
            
        if(!empty($esito))
            $sql .= " AND CE.idEsito_Fk = " . $esito;

        $query = $this->db->query($sql);

        foreach ($query->getResult('array') as $row) 
        {
            $data['esiti_campagne'][] = array(
                'campid_Fk'=>$row['campid_Fk'],
                'campNome'=>$row['campNome'],
                'nomeEsito'=>$row['nomeEsito'],
                'idEsito_Fk'=>$row['idEsito_Fk'],
            );
        }

        return $data;
    }

    public function insert_campagne_esiti($data)
    {
        $builder = $this->db->table('campagne_esiti');
        $builder->set($data);
        $builder->insert();
    }

    //funzione che cancella l'esito della campagna con id passati 
    public function delCampagneEsiti($campid = NULL,$idesito = null)
    {
        $where = [];
        if(!empty($campid)) $where['campid_Fk'] = $campid;
        if(!empty($idesito)) $where['idEsito_Fk'] = $idesito;

        $builder = $this->db->table('campagne_esiti')->where($where);
        $builder->delete();
    }

    //prendo gli esiti non associati alla campagna
    private function getEsitiNonAssociatiCampagna($campId)
    {
        $sql = "SELECT idEsito,nomeEsito FROM `esiti` WHERE 1=1";
        $sql .= " AND idEsito NOT IN (SELECT idEsito_Fk FROM campagne_esiti WHERE campId_FK = " . $campId . ")";

        $query = $this->db->query($sql);
        $esiti = [];
        $esiti['dati'] =  $query->getResult('array');

        $sqlcamp = "SELECT campId,campNome FROM campagne WHERE campId = " . $campId;
        $querycamp = $this->db->query($sqlcamp);
        $esiti['campId'] = $querycamp->getResult('array')[0]['campId'];
        $esiti['campNome'] = $querycamp->getResult('array')[0]['campNome'];
        return $esiti;
    }

    //**************** CAMPAGNE ATTIVITA ***************** */
    public function getAttivitaCampagne($data,$campId = null)
    {
        $data['attivita_campagne'] = [];
        $data['attivitanonassociate'] = [];

        if(!empty($campId))
        {
            $sql = "SELECT CA.*,A.nome FROM `campagne_attivita` CA INNER JOIN attivita A ON CA.attId_Fk = A.id WHERE campid_Fk = " . $campId;
            $query = $this->db->query($sql);
            $data['attivita_campagne'] = $query->getResult('array');

            //prendo gli esiti non associati
            $sqlnoass = "SELECT * FROM attivita WHERE id NOT IN (SELECT attId_Fk FROM campagne_attivita WHERE campId_FK = " . $campId . ")";
            $querynoass = $this->db->query($sqlnoass);
            $data['attivitanonassociate'] = $querynoass->getResult('array');
        }
        
        return $data;
    }

    public function insertAttivitaCampagne($data)
    {
        $builder = $this->db->table('campagne_attivita');
        $builder->set($data);
        $builder->insert();
    }

    public function deleteAttivitaCampagne($data)
    {
        $builder = $this->db->table('campagne_attivita')->where($data);
        $builder->delete();
    }
    // ***************************************************

    //**************** CAMPAGNE MACROPRODOTTI ***************** */
    public function getMacroProdottiCampagne($campId)
    {
        if(empty($campId)) return [];

        $sql = "SELECT CM.*,M.nome FROM `campagne_macroprodotti` CM INNER JOIN prodotti_macro M ON CM.macroId_Fk = M.macroId WHERE campid_Fk = " . $campId;
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function insertMacroProdottiCampagne($data)
    {
        $builder = $this->db->table('campagne_macroprodotti');
        $builder->set($data);
        $builder->insert();
    }

    public function deleteMacroProdottiCampagne($data)
    {
        $builder = $this->db->table('campagne_macroprodotti')->where($data);
        $builder->delete();
    }

    public function getCampVenditaMacroProdotto($macroid)
    {
        $sql = "SELECT C.* FROM campagne C 
        INNER JOIN campagne_macroprodotti CM ON CM.campid_Fk = C.campId
        WHERE C.campTipo = 'vendita' 
        AND CM.macroId_Fk = " . $macroid;

        $query = $this->db->query($sql);
        return $query->getResult('array');
    }
    // ***************************************************
}