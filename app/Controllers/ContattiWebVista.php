<?php

namespace App\Controllers;
use App\Models\ContattiWebVistaModel;
use App\Models\AttivitaModel;
use App\Models\ProvinceModel;
use App\Models\CampagneContattiWebinvistaModel;
use App\Models\TipologieModel;
use App\Libraries\EmailManager;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class ContattiWebVista extends BaseController
{
    protected $model;
    protected $attivitamodel;
    protected $tipologiamodel;
    protected $provincemodel;
    protected $campagnecontattiwebvistamodel;
    protected $request;


    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new ContattiWebVistaModel();
        $this->attivitamodel = new AttivitaModel();
        $this->provincemodel = new ProvinceModel();
        $this->campagnecontattiwebvistamodel = new CampagneContattiWebinvistaModel();
        $this->tipologiamodel = new TipologieModel();

        $this->request = \Config\Services::request();
        helper('form');
    }

    // ...
    public function get_contatti()
    {
        $data = [];
        $data['title'] = "Contatti";
        $data_template = [];
        $data_template = $this->model->getContatti();
        $data['template_contatto'] = view('/contattiwebvista/template_contatto',$data_template);
        $data['template'] = view('/contattiwebvista/contatti',$data);
        return view('layout', $data);
    }

    public function search($id)
    {
        $data_template = $this->model->getContatti($id);
        return view('/contattiwebvista/template_contatto',$data_template);
    }

    public function get_contatto($id = NULL)
    {
        $data = $this->model->get_contatto($id);
        $data['title'] = empty($id) ? "Nuovo contatto" : "Modifica contatto";
        $data['template'] = view('/contattiwebvista/new_contatto',$data); 
        return view('layout', $data);
    }

    public function modify_contatto_ajax()
    {
        $data = $this->request->getPost();
        $this->model->modify_contatto($data);
        return json_encode(['csrfHash' => csrf_hash()]);
    }

    public function modify_contatto()
    {
        $data = $this->request->getPost();

        $rules = [
            'tipologiaId_Fk' => [
            'rules'  => 'required',
            'errors' => [
                'required' => "Scegliere la tipologia",
                ],
            ],
            'attId_Fk' => [
            'rules'  => 'required',
            'errors' => [
                'required' => "Scegliere l'attività",
                ],
            ],
            'referente' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire il referente',
                ],
            ],
            'ragione_sociale' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire la Ragione Sociale',
                ],
            ],
            'indirizzo' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire un indirizzo',
                ],
            ],
            'comune' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire un comune',
                ],
            ],
            'provincia' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Scegliere la provincia',
                ],
            ],
            'cap' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire un cap',
                ],
            ],
            'telefono' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire un numero di telefono',
                ],
            ],
            'cellulare' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire un numero di cellulare',
                ],
            ],
            'email' => [
            'rules'  => 'required',
            'errors' => [
                 'required' => 'Inserire un Email',
                'valid_email' => 'Inserire un Email valida',
                ],
            ]
        ]
        
            // 'password' => 'required|max_length[255]|min_length[10]',
            // 'passconf' => 'required|max_length[255]|matches[password]',
            // 'email'    => 'required|max_length[254]|valid_email',
        ;

        if (! $this->validateData($data, $rules)) 
        {
            $data_user = $this->model->get_contatto($data['id_update']);
            $data_user['title'] = empty($data['id_update']) ? "Nuovo contatto" : "Modifica contatto";
            
            if(!empty($data['tipologiaId_Fk']))
            {
                $data_user['tipologiaid_chooseid_choose'] = $data['tipologiaId_Fk'];
                $data_user['tipologiaid_choosenome_choose'] = $this->tipologiamodel->getTipologia($data['tipologiaId_Fk'])['tipologia'][0]['tipologia'];
            }

            if(!empty($data['attId_Fk']))
            {
                $data_user['attid_choose'] = $data['attId_Fk'];
                $data_user['attnome_choose'] = $this->attivitamodel->getAttivita($data['attId_Fk'])['attivita'][0]['nome'];
            }


            if(!empty($data['provincia'])) $data_user['prov_choose'] = $data['provincia'];

            $data_user['template'] = view('/contattiwebvista/new_contatto',$data_user); 
            return view('layout', $data_user);
        }

        $this->model->modify_contatto($data);
        $data = [];
        $data['title'] = "Contatti";
        $data_template = [];
        $data_template = $this->model->getContatti();
        $data['template_contatto'] = view('/contattiwebvista/template_contatto',$data_template);
        $data['template'] = view('/contattiwebvista/contatti',$data);
        return view('layout', $data);
    }  

    public function delContatto($id = NULL)
    {
        $this->model->delCont($id);
        $data = [];
        $data['title'] = "Contatti";
        $data_template = [];
        $data_template = $this->model->getContatti();
        $data['template_user'] = view('/contattiwebvista/template_contatto',$data_template);
        $data['template'] = view('/contattiwebvista/contatti',$data);
        return view('layout', $data);
    }

    public function updateCampagneContattiWebVistaAjax()
    {
        $data = $this->request->getPost();

        $data_upd = array(
            'Idesito_Fk' => $data['id_esito_update_campagna'],
            'campcontEsitatoIdUtente_Fk' => $_SESSION['user_login']['id'],
            'campcontEsitodata' => date('Y-m-d H:i:s'),
            'data_primo_contatto' => date('Y-m-d H:i:s'),
            'idUtente_Fk_modifica'  => $_SESSION['user_login']['id'],
            'data_modifica' => date('Y-m-d H:i:s'),
        );

        if(!empty($data['data_ricontatto']) && !empty($data['ora_ricontatto']))
            $data_upd['data_ricontatto'] =  $data['data_ricontatto'] . " " . $data['ora_ricontatto'];

        if(!empty($data['invio_presentazione']) && $data['inviata_presentazione'] == "2")
        {
            $data_cont = $this->model->get_contatto($data['cont_id_update']);
            $emailmanager = new EmailManager();
            $template_mail = view('/email/email_presentazione_contattiwebvista',$data_cont);
            $emailmanager->sendMail($template_mail,"AURIM - Presentazione",$data_cont['contatto']['email_1']);
            $data_upd['invio_presentazione'] = 1;
        }
            

        if(!empty($data['link_google']))
            $data_upd['linkGoogleCalendar'] = $data['link_google'];

        if(!empty($data['prodId_Fk']))
            $data_upd['prodId_Fk'] = $data['prodId_Fk'];

        if(!empty($data['servizio_digitale']))
            $data_upd['servizio_digitale'] = $data['servizio_digitale'];
        
        if(!empty($data['note']))
            $data_upd['note'] = $data['note'];
        
        $this->campagnecontattiwebvistamodel->setCampagneContattiWebinvista($data,$data_upd);
        return json_encode(['csrfHash' => csrf_hash()]);
    }

    public function updateCampagneContattiWebVistaOrdineAjax()
    {
        $data = $this->request->getPost();
        $data['campId'] = $data['campId_ord'];
        $data['cont_id_update'] = $data['cont_id_update_ord'];

        $data_upd = array(
            'fatturato' => intval($data['fatturato'] ?? "0"),
            'data_fattura' => $data['data_fattura'],
            'pagato' => intval($data['pagato'] ?? "0"),
            'data_pagamento' => $data['data_pagamento'],
            'prezzo'  => str_replace(",",".",$data['prezzo']),
            'sconto' => str_replace(",",".",$data['sconto']),
            'idordine' => str_replace(",",".",$data['idordine']),
        );

        $this->campagnecontattiwebvistamodel->setCampagneContattiWebinvista($data,$data_upd);
        return json_encode(['csrfHash' => csrf_hash()]);
    }
    
    public function invioPresCampagneContattiWebVistaAjax()
    {
        $data = $this->request->getPost();
        $data_cont = $this->model->get_contatto($data['cont_id_update']);

        $emailmanager = new EmailManager();
        $template_mail = view('/email/email_presentazione_contattiwebvista',$data_cont);
        echo $emailmanager->sendMail($template_mail);
    }
}