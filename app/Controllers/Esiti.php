<?php

namespace App\Controllers;
use App\Models\EsitiModel;
use App\Models\CampagneModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Esiti extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new EsitiModel();
        $this->campagnemodel = new CampagneModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    // ...
    public function index()
    {
        $data = [];
        $data['title'] = "Esiti";
        $data_template = [];
        $data_template = $this->model->getEsiti();
        $data['template_esiti'] = view('/esiti/template_esiti',$data_template);
        $data['template'] = view('/esiti/esiti',$data);
        return view('layout', $data);
    }

    public function get_esito($id = NULL)
    {
        $data = $this->model->get_esito($id);
        $data['title'] = empty($id) ? "Nuovo esito" : "Modifica esito";
        $data['template'] = view('/esiti/new_esito',$data); 
        return view('layout', $data);
    }

    public function modify_esito()
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
            $data_esito = $this->model->get_esito($data['id_update']);
            $data_esito['title'] = empty($data['id_update']) ? "Nuovo esito" : "Modifica esito";
            $data_esito['template'] = view('/esiti/new_esito',$data_esito); 
            return view('layout', $data_esito);
        }


        $this->model->modify_esito($data);
        $data = [];
        $data['title'] = "Esiti";
        $data_template = [];
        $data_template = $this->model->getEsiti();
        $data['template_esiti'] = view('/esiti/template_esiti',$data_template);
        $data['template'] = view('/esiti/esiti',$data);
        return view('layout', $data);
    }  

    public function delEsito($id = NULL)
    {
        $this->campagnemodel->delCampagneEsiti(null,$id);
        $this->model->delEsito($id);
        $data = [];
        $data['title'] = "Esiti";
        $data_template = [];
        $data_template = $this->model->getEsiti();
        $data['template_esiti'] = view('/esiti/template_esiti',$data_template);
        $data['template'] = view('/esiti/esiti',$data);
        return view('layout', $data);
    }
}