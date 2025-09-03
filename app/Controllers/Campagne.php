<?php

namespace App\Controllers;
use App\Models\CampagneModel;
use App\Models\CampagneContattiWebinvistaModel;
use App\Models\UsersModel;
use App\Models\EsitiModel;
use App\Models\ContattiWebVistaModel;
use App\Models\ProductsModel;
use App\Models\AppuntamentiModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Campagne extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new CampagneModel();
        $this->ccwmodel = new CampagneContattiWebinvistaModel();
        $this->usermodel = new UsersModel();
        $this->esitimodel = new EsitiModel();
        $this->contattowebvistamodel = new ContattiWebVistaModel();
        $this->productsmodel = new ProductsModel();
        $this->appointmentmodel = new AppuntamentiModel();

        $this->request = \Config\Services::request();
        helper('form');
    }

    // ...
    public function index()
    {
        $data = [];
        $data['title'] = "Campagne";
        $data_template = [];
        $data_template = $this->model->getCampagne();
        $data['template_campagne'] = view('/campagne/template_campagne',$data_template);
        $data['template'] = view('/campagne/campagne',$data);
        return view('layout', $data);
    }

    public function get_campagna($id = NULL)
    {
        $data = $this->model->get_campagna($id);
        $data['title'] = empty($id) ? "Nuova campagna" : "Modifica campagna";
        $data['utenti_campagne'] = $this->get_campagne_utenti($id);
        $data['esiti_campagne'] = $this->get_campagne_esiti($id);
        $data['attivita_campagne'] = $this->get_campagne_attivita($id);
        $data['macro_campagne'] = $this->get_campagne_macro($id);
        $data['template'] = view('/campagne/new_campaign',$data); 
        return view('layout', $data);
    }

    public function modify_campagna()
    {
        $data = $this->request->getPost();

        $rules = [
            'name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire il Nome',
                ],
            ],
            'tipo' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Selezionare il tipo',
                ],
            ]
        ]
        
            // 'password' => 'required|max_length[255]|min_length[10]',
            // 'passconf' => 'required|max_length[255]|matches[password]',
            // 'email'    => 'required|max_length[254]|valid_email',
        ;

        if (! $this->validateData($data, $rules)) 
        {
            $data_camp = $this->model->get_campagna($data['id_update']);
            $data_camp['title'] = empty($data['id_update']) ? "Nuova campagna" : "Modifica campagna";
            $data_camp['template'] = view('/campagne/new_campaign',$data_camp); 
            return view('layout', $data_camp);
        }

        $this->model->modify_campagna($data);
        $data = [];
        $data['title'] = "Campagne";
        $data_template = [];
        $data_template = $this->model->getCampagne();
        $data['template_campagne'] = view('/campagne/template_campagne',$data_template);
        $data['template'] = view('/campagne/campagne',$data);
        return view('layout', $data);
    }

    // Cancellazione campagna
    public function delCamp($campId)
    {
        //cancello tutte le tabelle associate e la campagna alla fine 
        $this->model->delCampagneUtenti($campId);
        $this->model->delCampagneEsiti($campId);
        $this->delCampagneAttivita($campId);
        $this->delCampagneMacro($campId);
        $this->model->delCamp($campId);

        return redirect()->to('/Campagne');
    }
    
    private function get_campagne_utenti($campId = null,$utenteId = null)
    {
        $data = [];
        $data['title'] = "Utenti della campagna";
        $data = $this->model->get_campagne_utenti($data,$campId,$utenteId);
        return view('/campagne/campagne_utenti',$data);
    }

    //Cancellazione utente in tabella campagne utenti e ritorna la view
    public function delCampagneUtenti($campid,$idUtente)
    {
        $this->model->delCampagneUtenti($campid,$idUtente);
        return $this->get_campagne_utenti($campid);
    }

    //Inserimento utente in tabella campagne utenti e ritorna la view
    public function insertCampagneUtenti($campId,$idUtente)
    {
        $data_ins = [
            'campid_Fk' => $campId,
            'idUtente_Fk' => $idUtente,
            'idUtente_Fk_mod' => $this->session->get('user_login')['id']
        ];
        $this->model->insert_campagne_utenti($data_ins);
        return $this->get_campagne_utenti($campId);
    }

    //************************************************************************ */

    private function get_campagne_esiti($campId = null,$utenteId = null)
    {
        $data = [];
        $data['title'] = "Esiti della campagna";
        $data = $this->model->get_campagne_esiti($data,$campId);
        return view('/campagne/campagne_esiti',$data);
    }

    //Cancellazione utente in tabella campagne esiti e ritorna la view
    public function delCampagneEsiti($campid,$idEsito)
    {
        $this->model->delCampagneEsiti($campid,$idEsito);
        return $this->get_campagne_esiti($campid);
    }

    //Inserimento utente in tabella campagne esiti e ritorna la view
    public function insertCampagneEsiti($campId,$idEsito)
    {
        $data_ins = [
            'campid_Fk' => $campId,
            'idEsito_Fk' => $idEsito,
            'idUtente_Fk_mod' => $this->session->get('user_login')['id']
        ];
        $this->model->insert_campagne_esiti($data_ins);
        return $this->get_campagne_esiti($campId);
    }

    //******************************************************************* */
    public function get_campagne_esiti_destinazioni($campId,$idesito)
    {
        $data = [];
        $data['title'] = "Destinazioni esiti della campagna";
        $data['campid'] = $campId;
        $data['esito'] = $this->esitimodel->get_esito($idesito);
        $data['esiti_destinazioni'] = $this->model->get_campagne_esiti_destinazioni($campId,$idesito);
        $data['campagne'] = $this->model->getCampagne();
        $data = $this->model->get_campagne_esiti($data,$campId);
        $data['template'] = view('/campagne/campagne_esiti_destinazioni',$data);
        return view('layout', $data);
    }

    public function updateinsertCampagneEsitiDestinazioniAjax()
    {
        $data = $this->request->getPost();
        
        //insert
        if($this->request->getPost("type") == "INS")
        {
            //`campId_Fk`, `Idesito_Fk`, `campId_Fk_dest`, `idUtente_Fk_dest`, `Idesito_Fk_dest`, `spostimmediato`, `giorni`, `bloccocampagnaorigine`, `idUtente_Fk_modifica`, `data_modifica`
            $data_ins = ['campId_Fk' => $this->request->getPost("campid"),
            'Idesito_Fk' => $this->request->getPost("esitoid"),
            'campId_Fk_dest' => $this->request->getPost("campiddest__ins"),
            'spostimmediato' => intval(str_replace("2","0",$this->request->getPost("spost_ins"))),
            'giorni' => $this->request->getPost("giornidest_ins"),
            'bloccocampagnaorigine' => intval(str_replace("2","0",$this->request->getPost("bloccocamporig_dest"))),
            'idUtente_Fk_modifica' => $this->session->get('user_login')['id'],
            ];

            if(!empty($this->request->getPost("idutente_ins"))) $data_ins['idUtente_Fk_dest'] = $this->request->getPost("idutente_ins");
            if(!empty($this->request->getPost("idesito_ins"))) $data_ins['Idesito_Fk_dest'] = $this->request->getPost("idesito_ins");
            $this->model->insert_campagne_esiti_destinazioni($data_ins);
        }
        else
        {
            if(!empty($this->request->getPost("campid")) && !empty($this->request->getPost("esitoid")) && !empty($this->request->getPost("idmod")))
            {
                $idmod = $this->request->getPost("idmod");
                $campiddestorig = $this->request->getPost("campdest_" . $idmod);

                $where = ['campId_Fk' => $this->request->getPost("campid"),
                'Idesito_Fk' => $this->request->getPost("esitoid"),
                'campId_Fk_dest' => $campiddestorig
                ];

                $data_upd = ['campId_Fk_dest' => $this->request->getPost("campiddest_" . $idmod),
                'spostimmediato' => intval(str_replace("2","0",$this->request->getPost("spostdest_" . $idmod))),
                'giorni' => $this->request->getPost("giornidest_" . $idmod),
                'bloccocampagnaorigine' => intval(str_replace("2","0",$this->request->getPost("bloccodest_" . $idmod))),
                'idUtente_Fk_modifica' => $this->session->get('user_login')['id'],
                'data_modifica' => date('Y-m-d H:i:s')
                ];

                if(!empty($this->request->getPost("utenteiddest_" . $idmod)))
                    $data_upd['idUtente_Fk_dest'] = $this->request->getPost("utenteiddest_" . $idmod);
                else
                    $data_upd['idUtente_Fk_dest'] = null;

                if(!empty($this->request->getPost("esitoiddest_" . $idmod)))
                    $data_upd['Idesito_Fk_dest'] = $this->request->getPost("esitoiddest_" . $idmod);
                else
                    $data_upd['Idesito_Fk_dest'] = null;

                $this->model->update_campagne_esiti_destinazioni($data_upd,$where);
            }
            // {"campid":"2","esitoid":"2",
                
            // ,"type":"UPD","idmod":"3","table_campagne_esiti_destinazioni_length":"10","campiddest_1":"4","utenteiddest_1":"",
            // "esitoiddest_1":"",
            // "spostdest_1":"0","giornidest_1":"","bloccodest_1":"0","campiddest_2":"4","utenteiddest_2":"","esitoiddest_2":"","spostdest_2":"0",
            // "giornidest_2":"1","bloccodest_2":"1","campiddest_3":"4","utenteiddest_3":"16","esitoiddest_3":"1","spostdest_3":"1","giornidest_3":"2","bloccodest_3":"1","campiddest__ins":"","idutente_ins":"","idesito_ins":"","spost_ins":"","giornidest_ins":"","bloccocamporig_dest":""}
        }

        // {"campid":"2","esitoid":"2","type":"INS","idmod":"","table_campagne_esiti_destinazioni_length":"10",
        //     "campiddest_1":"4","utenteiddest_1":"","esitoiddest_1":"","spostdest_1":"0","giornidest_1":"","bloccodest_1":"0","campiddest_2":"4",
        //     "utenteiddest_2":"","esitoiddest_2":"","spostdest_2":"0","giornidest_2":"1","bloccodest_2":"1",
            
        //     "campiddest__ins":"5","idutente_ins":"","idesito_ins":"","spost_ins":"1","giornidest_ins":"2","bloccocamporig_dest":"1"}
    }

    public function deleteCampagneEsitiDestinazioni($campid,$idesito,$campId_Fk_dest)
    {
        $this->model->delCampagneEsitiDestinazioni($campid,$idesito,$campId_Fk_dest);
    }

    //Funzione che restituisce gli utenti e esiti della campagna
    public function getUtentiEsitiCampagnaAjax($campIddest)
    {
        $data = [];
        $data = $this->model->get_campagne_esiti($data,$campIddest);
        $data = $this->model->get_campagne_utenti($data,$campIddest,null);
        echo json_encode($data);
    }

    //venditori delle campagne di vendita dello stesso macroprodotto
    public function getVenditoriCampagneVenditaMacroProdottoSchedaturaAjax($campid,$macroprod)
    {
        echo json_encode($this->usermodel->getVenditoriCampagneVenditaMacroProdottoSchedatura($campid,$macroprod));
    }

    // **************************************************************
    private function get_campagne_attivita($campId = null)
    {
        $data = [];
        $data['title'] = "Attività della campagna";
        $data['campagne_attivita'] = $this->model->getAttivitaCampagne($data,$campId);
        $data['campagne_attivita']['campId'] = $campId;
        return view('/campagne/campagne_attivita',$data);
    }
    
    //Cancellazione utente in tabella campagne attivita e ritorna la view
    public function delCampagneAttivita($campid,$attid = null)
    {
        $where = ['campId_Fk' => $campid];
        if(!empty($attid)) $where['attId_Fk'] = $attid;
        $this->model->deleteAttivitaCampagne($where);
        return $this->get_campagne_attivita($campid);
    }

    //Inserimento utente in tabella campagne attivita e ritorna la view
    public function insertCampagneAttivita($campId,$attid)
    {
        $data_ins = [
            'campid_Fk' => $campId,
            'attId_Fk' => $attid,
            'idUtente_Fk' => $this->session->get('user_login')['id']
        ];
        $this->model->insertAttivitaCampagne($data_ins);
        return $this->get_campagne_attivita($campId);
    }

    //Campagne contatti Webinvista
    public function getContattoWebinvista($campid,$contid)
    {
        $data = [];
        $data['title'] = "Contatto della campagna";
        $data['cc'] = [];
        $data['template_contatto'] = "";
        $data['template_ordine_campagna'] = "";

        $cc = $this->ccwmodel->getCampagneContattiWebinvista($campid,null,null,$contid);
        if(sizeof($cc) > 0)
        {
            //prendo i dati del contatto 
            $data['cc']['campagne_contatti'] = $cc[0];
            $data['cc']['contatto'] = $this->contattowebvistamodel->get_contatto($cc[0]['contId_Fk']);
            $data['cc']['contatto']['hide'] = "1";

            if(!empty($data['cc']['campagne_contatti']['campcontBloccatoIdUtente_Fk']))
            {
                $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['campcontBloccatoIdUtente_Fk'])['user'];
                $data['cc']['campagne_contatti']['utente_bloccato'] = $ub['nome'] . " " . $ub['cognome'];
            }

            if(!empty($data['cc']['campagne_contatti']['Idesito_Fk']))
            {
                $ub = $this->esitimodel->get_esito($data['cc']['campagne_contatti']['Idesito_Fk'])['esito'];
                $data['cc']['campagne_contatti']['esito_nome'] = $ub['nomeEsito'];
            }

            if(!empty($data['cc']['campagne_contatti']['campcontEsitatoIdUtente_Fk']))
            {
                $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['campcontEsitatoIdUtente_Fk'])['user'];
                $data['cc']['campagne_contatti']['utente_esito'] = $ub['nome'] . " " . $ub['cognome'];
            }

            if(!empty($data['cc']['campagne_contatti']['idUtente_Fk_modifica']))
            {
                $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['idUtente_Fk_modifica'])['user'];
                $data['cc']['campagne_contatti']['utente_modifica'] = $ub['nome'] . " " . $ub['cognome'];
            }

            $data['template_contatto'] = view('/contattiwebvista/new_contatto',$data['cc']['contatto']);
            $dataesiti = [];
            $dataesiti['campId'] = $campid;
            $dataesiti['cc'] = $data['cc']['campagne_contatti'];
            $dataesiti['esiti_campagna'] = $this->ccwmodel->getEsitiCampagna($campid);
            
            $dataesiti['products_camp'] = [];
            $dataesiti['camp_vendita']  = [];
            $dataesiti['macro_prod'] = [];
            
            if(sizeof($this->model->getMacroProdottiCampagne($campid)) > 0)
            {
                $macroprod = $this->model->getMacroProdottiCampagne($campid)[0]['macroId_Fk'] ?? "";

                if(!empty($macroprod))
                {
                    $dataesiti['macro_prod'] = $macroprod;
                    //prodotti del macro prodotto della campagna
                    $dataesiti['products_camp'] = $this->productsmodel->getProducts(null,$macroprod);
                    //campagne di vendita dello stesso macroprodotto
                    $dataesiti['camp_vendita'] = $this->model->getCampVenditaMacroProdotto($macroprod);
                }
            }

            $dataesiti['appointment'] = $this->appointmentmodel->getApp($campid,$cc[0]['contId_Fk'],$_SESSION['user_login']['id']);
                
            $data['template_esiti_campagna'] = view('/contattiwebvista/template_esiti_campagna',$dataesiti);

            if($_SESSION['user_login']['tipo'] == 'venditore')
            {
                $dataordini = [];
                $dataordini['campId'] = $campid;
                $dataordini['cc'] = $data['cc']['campagne_contatti'];
                $data['template_ordine_campagna'] = view('/contattiwebvista/template_ordine_campagna',$dataordini);
            }     
        }
        else
        {
            $data['template_contatto'] = "";
            $dataesiti = [];
            $dataesiti['campId'] = $campid;
            $dataesiti['esiti_campagna'] = [];
            $data['template_esiti_campagna'] = "";
            $dataesiti['appointment'] = [];
            $data['template_ordine_campagna'] = "";
            $data['errore_no_cont'] = "Non ci sono contatti liberi in campagna";    
        }
    
        $data['template'] = view('/campagne_contatti_webvista/contatto_campagna_webvista',$data);
        return view('layout', $data);
    }

    public function getContattoWebinvistaLibero($campid)
    {
        $data = [];
        $data['title'] = "Contatto della campagna";
        $array_ok = ['schedatore','venditore'];

        $data['cc'] = [];
        $data['template_contatto'] = "";
        $data['template_ordine_campagna'] = "";

        if(in_array($this->session->get('user_login')['tipo'],$array_ok))
        {
            //cerco per campagna e utente già preso 
            $cc = $this->ccwmodel->getCampagneContattiWebinvistaUtente($campid,$this->session->get('user_login')['id']);

            //se non lo trovo solo per campagna libero
            $new = 0;
            if(sizeof($cc) == 0)
            {
                $new = 1;
                $cc = $this->ccwmodel->getCampagneContattiWebinvistaLibero($campid);
            }
                
            
            if(sizeof($cc) > 0)
            {
                //setto bloccato all'utente corrente 
                if($new == 1)
                {
                    $data_upd = ['campcontBloccatoIdUtente_Fk' => $_SESSION['user_login']['id'],
                    'campcontBloccatodata' => date('Y-m-d H:i:s'),
                    ];
                    $this->ccwmodel->setCampagneContattiWebinvista(['campId' => $campid,'cont_id_update' => $cc[0]['contId_Fk']],$data_upd);
                }
                
                //prendo i dati del contatto 
                $data['cc']['campagne_contatti'] = $cc[0];
                $data['cc']['contatto'] = $this->contattowebvistamodel->get_contatto($cc[0]['contId_Fk']);
                $data['cc']['contatto']['hide'] = "1";

                if(!empty($data['cc']['campagne_contatti']['campcontBloccatoIdUtente_Fk']))
                {
                    $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['campcontBloccatoIdUtente_Fk'])['user'];
                    $data['cc']['campagne_contatti']['utente_bloccato'] = $ub['nome'] . " " . $ub['cognome'];
                }

                if(!empty($data['cc']['campagne_contatti']['Idesito_Fk']))
                {
                    $ub = $this->esitimodel->get_esito($data['cc']['campagne_contatti']['Idesito_Fk'])['esito'];
                    $data['cc']['campagne_contatti']['esito_nome'] = $ub['nomeEsito'];
                }

                if(!empty($data['cc']['campagne_contatti']['campcontEsitatoIdUtente_Fk']))
                {
                    $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['campcontEsitatoIdUtente_Fk'])['user'];
                    $data['cc']['campagne_contatti']['utente_esito'] = $ub['nome'] . " " . $ub['cognome'];
                }

                if(!empty($data['cc']['campagne_contatti']['idUtente_Fk_modifica']))
                {
                    $ub = $this->usermodel->get_user($data['cc']['campagne_contatti']['idUtente_Fk_modifica'])['user'];
                    $data['cc']['campagne_contatti']['utente_modifica'] = $ub['nome'] . " " . $ub['cognome'];
                }

                $data['template_contatto'] = view('/contattiwebvista/new_contatto',$data['cc']['contatto']);
                $dataesiti = [];
                $dataesiti['campId'] = $campid;
                $dataesiti['cc'] = $data['cc']['campagne_contatti'];
                $dataesiti['esiti_campagna'] = $this->ccwmodel->getEsitiCampagna($campid);

                $dataesiti['products_camp'] = [];
                $dataesiti['camp_vendita']  = [];
                $dataesiti['macro_prod'] = [];
                
                if(sizeof($this->model->getMacroProdottiCampagne($campid)) > 0)
                {
                    $macroprod = $this->model->getMacroProdottiCampagne($campid)[0]['macroId_Fk'] ?? "";

                    if(!empty($macroprod))
                    {
                        $dataesiti['macro_prod'] = $macroprod;
                        //prodotti del macro prodotto della campagna
                        $dataesiti['products_camp'] = $this->productsmodel->getProducts(null,$macroprod);
                        //campagne di vendita dello stesso macroprodotto
                        $dataesiti['camp_vendita'] = $this->model->getCampVenditaMacroProdotto($macroprod);
                    }
                }

                $dataesiti['appointment'] = [];
                     
                $data['template_esiti_campagna'] = view('/contattiwebvista/template_esiti_campagna',$dataesiti);

                if($_SESSION['user_login']['tipo'] == 'venditore')
                {
                    $dataordini = [];
                    $dataordini['campId'] = $campid;
                    $dataordini['cc'] = $data['cc']['campagne_contatti'];
                    $data['template_ordine_campagna'] = view('/contattiwebvista/template_ordine_campagna',$dataordini);
                }
            }
            else
            {
                $data['template_contatto'] = "";
                $dataesiti = [];
                $dataesiti['campId'] = $campid;
                $dataesiti['esiti_campagna'] = "";
                $data['template_esiti_campagna'] = "";
                $dataesiti['appointment'] = [];
                $data['template_ordine_campagna'] = "";
                $data['errore_no_cont'] = "Non ci sono contatti liberi in campagna";    
            }

        }
        else 
            $data['errore'] = "Utente non abilitato";

        $data['template'] = view('/campagne_contatti_webvista/contatto_campagna_webvista',$data);
        return view('layout', $data);
    }

    // Campagne degli utenti 
    public function getCampagneUtenti()
    {
        $data = [];
        $data['title'] = "Campagne";
        $data['campagne'] = $this->model->get_campagne_utenti($data,null,$_SESSION['user_login']['id']);
        $data['template'] = view('/utenti/campagne_utente',$data);
        return view('layout', $data);
    }

    public function getContattiUtenteWebvista($campId)
    {
        $data = [];
        $data['title'] = "Contatti della campagna";
        
        $data['contatti'] = $this->ccwmodel->getCampagneContattiWebinvista($campId,null,$_SESSION['user_login']['id']);
        $data['template'] = view('/utenti/contatti_campagne_utente',$data);
        return view('layout', $data);
    }

    // campagne macro
    private function get_campagne_macro($campId = null)
    {
        $data = [];
        $data['title'] = "Macro prodotti della campagna";
        $data['macro_attivita'] = $this->model->getMacroProdottiCampagne($campId);
        $data['macroproducts'] = $this->productsmodel->getMacroProducts();
        $data['campId'] = $campId;
        return view('/campagne/campagne_macro',$data);
    }
    
    public function delCampagneMacro($campid,$macroid = null)
    {
        $where = ['campId_Fk' => $campid];
        if(!empty($macroid)) $where['macroId_Fk'] = $macroid;
        $this->model->deleteMacroProdottiCampagne($where);
        return $this->get_campagne_macro($campid);
    }

    public function insertCampagneMacro($campId,$macroid)
    {
        $data_ins = [
            'campid_Fk' => $campId,
            'macroId_Fk' => $macroid,
            'idUtente_Fk' => $this->session->get('user_login')['id']
        ];
        $this->model->insertMacroProdottiCampagne($data_ins);
        return $this->get_campagne_macro($campId);
    }
}