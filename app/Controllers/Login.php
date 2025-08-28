<?php
namespace App\Controllers;
use App\Models\UsersModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Login extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new UsersModel();
        $this->user = new Users();
        $this->request = \Config\Services::request();
        helper('form');
    }

    public function index()
    {
        $data = array(
           'logoUrl' => "",
           'title' => 'CRM Aurim Login',
       );
       return view('/login', $data);
    }

    public function verify()
    {
        $data = $this->request->getPost();

        $rules = [
            'username' => [
            'rules'  => 'trim|required',
            'errors' => [
                'required' => 'Inserire Username',
                ],
            ],
            'password' => [
            'rules'  => 'trim|required',
            'errors' => [
                'required' => 'Inserire la Password',
                ],
            ]

        ]
        
            // 'password' => 'required|max_length[255]|min_length[10]',
            // 'passconf' => 'required|max_length[255]|matches[password]',
            // 'email'    => 'required|max_length[254]|valid_email',
        ;

        if (! $this->validateData($data, $rules)) 
        {
            $data = array(
           'logoUrl' => "",
           'title' => 'Login',
            );

            return view('/login', $data);
        }

        $user_login = $this->model->login($data['username'],$data['password']);

        if(!empty($user_login) && sizeof($user_login) > 0)
        {
            $user_login = $user_login[0];
            $login = [
            'id' => $user_login['id'],
            'username' => $user_login['username'],    
            'nome' => $user_login['nome'],
            'cognome' => $user_login['cognome'],
            'data_scadenza' => $user_login['data_scadenza'],
            'tipo' => $user_login['tipo']
            ];

            $this->session->set('user_login',$login);

            if($data['password'] == "cambiami")
                return redirect()->to('/ChangePwd');

            switch($user_login['tipo'])
            {
                case 'admin':
                case 'sysadmin':
                    return redirect()->to('/Users');
                case 'schedatore';
                case 'venditore':
                    return redirect()->to('/CampagneContatti');
            }
        }
        else
        {
            $this->session->set('login_error','Username o password errati');
            $this->session->markAsFlashdata('login_error');
            return redirect()->to('/');
        }


    }

    public function logout()
    {
        $this->session->remove('user_login');
        $this->session->destroy();
        return redirect()->to('/');
    }
}