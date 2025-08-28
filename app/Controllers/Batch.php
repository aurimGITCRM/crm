<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\CampagneContattiWebinvistaModel;
use App\Models\AppuntamentiModel;
use App\Libraries\EmailManager;
use App\Libraries\MailChimpManager;

class Batch extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->campagnecontattiwebvistamodel = new CampagneContattiWebinvistaModel();
        $this->appointmentsmodel = new AppuntamentiModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    public function sendMailListMailChimp()
    {
        $listId = "1";
        $mailchimp = new MailChimpManager();
        $emails = $mailchimp->getEmailsList($listId);

        if(sizeof($emails) > 0)
        {
            $emailmanager = new EmailManager();

            foreach($emails as $email)
            {
                $template_mail = view('/email/promemoria_appuntamento',$data_cont);
                $emailmanager->sendMail($template_mail,"AURIM - MAIL LISTA MAILCHIMP",$email);
            }
        }
    }

    // Invio mail promemoria appuntamento se quello del giorno prima aggiorno il flag per non reinviarlo più nello stesso giorno
    // CRON da schedulare ogni minuto per mezz'ora prima
    public function sendMailPromemoriaAppuntamento()
    {
        $appointments = $this->appointmentsmodel->getContattiAppuntamentiMailPromemoria();

        if(!empty($appointments) && sizeof($appointments) > 0)
        {
            $emailmanager = new EmailManager();

            foreach($appointments as $app)
            {
                $data_cont['contatto'] = $app;    
                $template_mail = view('/email/promemoria_appuntamento',$data_cont);
                $emailmanager->sendMail($template_mail,"AURIM - Promemoria appuntamento",$data_cont['contatto']['email_1']);

                if($app['type'] == 'DAY_BEFORE')
                    $this->appointmentsmodel->UpdateApp(['sent_date_before' => 1],['idApp' => $app['idApp']]);
            }
        }
    }

    // Invio mail rinnovo plugin ogni 90 giorni
    // CRON da schedulare ogni giorno
    public function sendMailAlertRinnovoPlugin()
    {
        $contacts = $this->campagnecontattiwebvistamodel->getContattiAlertRinnovoPlugin();
        
        if(!empty($contacts) && sizeof($contacts) > 0)
        {
            $emailmanager = new EmailManager();

            foreach($contacts as $cont)
            {
                if(!empty($cont['ultimo_agg_plugin']))
                {
                    if($this->alertRinnovoPlugin($cont['ultimo_agg_plugin']))
                    {
                        //INVIO MAIL DI ALERT 
                        $data_cont['contatto'] = $cont;                      
                        $template_mail = view('/email/alert_rinnovo_plugin',$data_cont);
                        $emailmanager->sendMail($template_mail,"AURIM - Scadenza rinnovo plugin",$data_cont['contatto']['email_1']);
                    }
                }
            }
        }
    }

    // Invio mail rinnovo dominio
    // CRON da schedulare ogni giorno
    public function sendMailAlertRinnovoDominio()
    {
        $contacts = $this->campagnecontattiwebvistamodel->getContattiAlertScadenzaRinnovo();
        
        if(!empty($contacts) && sizeof($contacts) > 0)
        {
            $emailmanager = new EmailManager();

            foreach($contacts as $cont)
            {
                if(!empty($cont['data_registrazione_dominio']))
                {
                    $type = $this->alertScadenzaRinnovo($cont['data_registrazione_dominio']); 
                    if($type != "")
                    {
                        //INVIO MAIL DI ALERT 
                        switch($type)
                        {
                            case "30":
                                $data_cont['contatto'] = $cont;
                                
                                $template_mail = view('/email/alert_rinnovo_dominio_trenta_giorni',$data_cont);
                                $emailmanager->sendMail($template_mail,"AURIM - Scadenza rinnovo dominio " . $data_cont['contatto']['dominio'],$data_cont['contatto']['email_1']);
                                break;
                            case "60":
                                $data_cont['contatto'] = $cont;
                                $template_mail = view('/email/alert_rinnovo_dominio_sessanta_giorni',$data_cont);
                                $emailmanager->sendMail($template_mail,"AURIM - Scadenza rinnovo dominio " . $data_cont['contatto']['dominio'],$data_cont['contatto']['email_1']);
                                break;

                        }
                    }
                }
            }
        }
    }

    public function alertRinnovoPlugin($data)
    {
        $flag = false;

        //aggiungo 90 giorni * n alla data di ultimo agg plugin
        for($n = 1;$n < 1000;$n++)
        {
            $newDate = date('Y-m-d', strtotime($data . ' +' . ($n*90) . ' days'));
            if($newDate == date('Y-m-d')) $flag = true;

            //se data maggiore di oggi esco
            if($newDate > date('Y-m-d'))
                break;
        }

        return $flag;
    }

    public function alertScadenzaRinnovo($dataregistrazione)
    {
        $type = "";

        //aggiungo 90 giorni * n alla data di ultimo agg plugin
        for($n = 1;$n < 1000;$n++)
        {
            $newDateSessantaGiorniPrima = date('Y-m-d', strtotime($dataregistrazione . ' +' . ($n*305) . ' days - 60 days'));
            $newDateTrentaGiorniPrima = date('Y-m-d', strtotime($dataregistrazione . ' +' . ($n*305) . ' days - 30 days'));

            if($newDateSessantaGiorniPrima == date('Y-m-d'))
            {
                $type = "60";
                break;
            }
             
            if($newDateTrentaGiorniPrima == date('Y-m-d'))
            {
                $type = "30";
                break;
            }

            //se data maggiore di oggi esco
            if($newDateSessantaGiorniPrima > date('Y-m-d'))
                break;
        }

        return $type;
    }
}