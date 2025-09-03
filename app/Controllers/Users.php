<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\LoginModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Users extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
        $this->model = new UsersModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    // ...
    public function get_users()
    {
        $data = [];
        $data['title'] = "Utenti";
        $data_template = [];
        $data_template = $this->model->getUsers();
        $data['template_user'] = view('/utenti/template_user',$data_template);
        $data['template'] = view('/utenti/users',$data);
        return view('layout', $data);
    }

    public function search($id)
    {
        $data_template = $this->model->getUsers($id);
        return view('/utenti/template_user',$data_template);
    }

    public function get_user($id = NULL)
    {
        $data = $this->model->get_user($id);
        $data['title'] = empty($id) ? "Nuovo utente" : "Modifica utente";
        $data['template'] = view('/utenti/new_user',$data); 
        return view('layout', $data);
    }

    public function modify_user()
    {
        $data = $this->request->getPost();
        
        $rules = [
            'tipo' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Selezionare il Tipo',
                ],
            ],
            'name' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Inserire il Nome',
                ],
            ],
            'surname' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Inserire il Cognome',
                ],
            ],
            'email' => [
            'rules'  => 'required|max_length[254]|valid_email',
            'errors' => [
                 'required' => 'Inserire un Email',
                'valid_email' => 'Inserire un Email valida',
                ],
            ],
            'data_scadenza' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Scegliere la data di scadenza',
                ],
            ]
        ]
        
            // 'password' => 'required|max_length[255]|min_length[10]',
            // 'passconf' => 'required|max_length[255]|matches[password]',
            // 'email'    => 'required|max_length[254]|valid_email',
        ;

        if (! $this->validateData($data, $rules)) 
        {
            $data_user = $this->model->get_user($data['id_update']);
            $data_user['title'] = empty($data['id_update']) ? "Nuovo utente" : "Modifica utente";
            $data_user['template'] = view('/utenti/new_user',$data_user); 
            return view('layout', $data_user);
        }


        $this->model->modify_user($data);
        $data = [];
        $data['title'] = "Utenti";
        $data_template = [];
        $data_template = $this->model->getUsers();
        $data['template_user'] = view('/utenti/template_user',$data_template);
        $data['template'] = view('/utenti/users',$data);
        return view('layout', $data);
    }  

    public function delUser($id = NULL)
    {
        $this->model->delUser($id);
        return redirect()->to('/Users');
    }

    public function resetPwd($id)
    {
        $this->model->reset_pwd($id);
        $data = $this->model->get_user($id);
        $data['title'] = empty($id) ? "Nuovo utente" : "Modifica utente";
        $data['reset_pwd'] = "Password resettata correttamente.Inserire la password 'cambiami' per accedere alla pagina di cambio password";
        $data['template'] = view('/utenti/new_user',$data);
        return view('layout', $data);
    }

    public function changePwd()
    {
        $data['title'] = "Cambio password";

        $data_post = $this->request->getPost();
        
        if(sizeof($data_post) > 0)
        {
             $rules = [
                'old_password' => [
                'rules'  => 'verify_old_pwd[old_password]',
                'errors' => [
                        'verify_old_pwd' => "Il campo Vecchia Password non corrisponde"
                        ],
                ],
                'password' => [
                'rules'  => 'valid_password[password]',
                'errors' => [
                        'valid_password' => ""
                        ],
                ],
                'pwd_confirm' => [
                'rules'  => 'matches[password]',
                'errors' => [
                        'matches' => "Le password non corrispondono"
                        ],
                ]
            ];

            if ($this->validateData($data_post, $rules))
            {
                //memorizzo la nuova password dell'utente
                $this->model->modify_pwd_user($_SESSION['user_login']['id'],$data_post['password']);
                $_SESSION['password_memory'] = "";
                $data['changed'] = "1";
            } 
        }
        else
        {
            $_SESSION['valid_password'] = "";
            $_SESSION['password_memory'] = "";
        }
            

        $data['template'] = view('/utenti/change_pwd',$data);
        return view('layout', $data);
    }

    public function checkPwd($password)
    {
        $model = new UsersModel();
        $check = $model->login($_SESSION['user_login']['username'],$password);
        if($check) $_SESSION['password_memory'] = $password;

        return $check;
    }

    public function valid_password($password)
    {
        
        $password = trim($password);
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';

        if(strlen($password) == 0)
        {
            $_SESSION['valid_password'] = "Inserire la nuova password";
            return false;
        }
		
		if (preg_match_all($regex_lowercase, $password) < 1) {
			$_SESSION['valid_password'] = "La password deve contenere almeno un carattere minuscolo.";
			return false;
		}
		if (preg_match_all($regex_uppercase, $password) < 1) {
			$_SESSION['valid_password'] = "La password deve contenere almeno un carattere maiuscolo.";
			return false;
		}
		if (preg_match_all($regex_number, $password) < 1) {
			$_SESSION['valid_password'] = "La password deve contenere almeno un numero.";
			return false;
		}
		if (strlen($password) < 8) {
			$_SESSION['valid_password'] = "La password deve contenere un minimo 8 caratteri.";
			return false;
		}
		if (strlen($password) > 20)	{
			$_SESSION['valid_password'] = "La password deve contenere un massimo di 20 caratteri.";
			return false;
		}
		
		return true;
    }
}