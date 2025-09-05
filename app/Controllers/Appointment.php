<?php

namespace App\Controllers;
use App\Models\AppuntamentiModel;
use App\Models\ContattiWebVistaModel;
use App\Models\CampagneContattiWebinvistaModel;
use App\Libraries\EmailManager;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Appointment extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new AppuntamentiModel();
        $this->contmodel = new ContattiWebVistaModel();
        $this->campagnecontattiwebvistamodel = new CampagneContattiWebinvistaModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    public function testEmail()
    {
        $data_cont = $this->contmodel->get_contatto(1);
        $emailmanager = new EmailManager();
        $template_mail = view('/email/email_presentazione_contattiwebvista',$data_cont);
        $emailmanager->sendMail($template_mail,"AURIM - Presentazione",$data_cont['contatto']['email_1']);
        $data_upd['invio_presentazione'] = 1;
    }

    public function createApp()
    {
        $data = $this->request->getPost();

        $data_ins = ['campId_Fk' => $data['campId'],
        'campId_Fk_vdt' => $data['camp_vendita'],
        'contId_Fk' => $data['cont_id_app'],
        'idUtente_Fk_ext' => $data['venditore'],
        'data_ora_app' => $data['data_app'] . " " . $data['ora_appuntamento'],
        'idUtente_Fk' => $_SESSION['user_login']['id']
        ];

        if(!empty($data['note_app'])) $data_ins['note'] = $data['note_app'];

        if(!empty($data['id_app']))
            $this->model->UpdateApp($data_ins,['idApp' => $data['id_app']]);
        else
            $this->model->InsertApp($data_ins);

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
            $data_cont = $this->contmodel->get_contatto($data['cont_id_app']);
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
}