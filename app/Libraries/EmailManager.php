<?php
namespace App\Libraries;

class EmailManager
{
    public function sendMail($view_html,$subject,$to,$cc = null)
    {
        $email = service('email');

        // Email configuration TEST
        // $config = [
        //     'protocol' => 'smtp',
        //     'SMTPHost' => 'smtp.office365.com',
        //     'SMTPUser' => 'app-noreply@etiqube.com',
        //     'SMTPPass' => 'Daz72614',
        //     'SMTPPort' => '587',
        //     'SMTPCrypto' => 'tls',
        //     'mailType' => 'html',
        //     'charset' => 'utf-8',
        //     'wordWrap' => true,
        // ];

        // Email configuration PROD
        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => 'mail.crmaurim.it',
            'SMTPUser' => 'noreply@crmaurim.it',
            'SMTPPass' => '5BQSJkcYiG#]',
            'SMTPPort' => '465',
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'utf-8',
            'wordWrap' => true,
        ];
        

        $email->initialize($config);

        // Set email parameters
        //$email->setFrom('app-noreply@etiqube.com', 'AURIM');
        $email->setFrom('noreply@crmaurim.it', 'AURIM');
        $email->setTo($to);

        if(!empty($cc))
            $email->cc($cc);

        $email->setSubject($subject);
        $email->setMessage($view_html);

        // Send email
        if ($email->send()) {
            return 'OK';
        } else {
            return 'Email not sent. Error: ' . $email->printDebugger();
        }
    }
}
?>