<?php

namespace App\Controllers;
use App\Models\AttivitaModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Attivita extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new AttivitaModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    // ...
    public function index()
    {
        $data = [];
        $data['title'] = "ATTIVITA'";
        $data_template = [];
        $data_template = $this->model->getAttivita();
        $data['template_attivita'] = view('/attivita/template_attivita',$data_template);
        $data['template'] = view('/attivita/attivita',$data);
        return view('layout', $data);
    }

    public function get_attivita($id = NULL)
    {
        $data = $this->model->get_att($id);
        $data['title'] = empty($id) ? "Nuova attività" : "Modifica attività";
        $data['template'] = view('/attivita/new_attivita',$data); 
        return view('layout', $data);
    }

    public function modify_attivita()
    {
        $data = $this->request->getPost();

        $rules = [
            'name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire il Nome',
                ],
            ]
        ]
        
            // 'password' => 'required|max_length[255]|min_length[10]',
            // 'passconf' => 'required|max_length[255]|matches[password]',
            // 'email'    => 'required|max_length[254]|valid_email',
        ;

        if (! $this->validateData($data, $rules)) 
        {
            $data_camp = $this->model->get_att($data['id_update']);
            $data_camp['title'] = empty($data['id_update']) ? "Nuova attività" : "Modifica attività";
            $data_camp['template'] = view('/attivita/new_attivita',$data_camp); 
            return view('layout', $data_camp);
        }


        $this->model->modify_att($data);
        
        $data = [];
        $data['title'] = "Attività";
        $data_template = [];
        $data_template = $this->model->getAttivita();
        $data['template_attivita'] = view('/attivita/template_attivita',$data_template);
        $data['template'] = view('/attivita/attivita',$data);
        return view('layout', $data);
    }  

    public function delAttivita($id = NULL)
    {
        $this->model->delAtt($id);
        return redirect()->to('/Attivita');
    }
}