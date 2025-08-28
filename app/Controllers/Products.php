<?php

namespace App\Controllers;
use App\Models\ProductsModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Products extends BaseController
{
    protected $model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new ProductsModel();
        $this->request = \Config\Services::request();
        helper('form');
    }

    public function get_macro_products()
    {
        $data = [];
        $data['title'] = "Macro prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['template'] = view('/prodotti/macroprodotti',$data);
        return view('layout', $data);
    }

    public function insert_update_macro_products($id = null)
    {
        $data['macroprodotto'] = [];
        if(!empty($id)) $data['macroprodotto'] = $this->model->getMacroProducts($id);
        $data['title'] = empty($id) ? "Nuovo macro prodotto" : "Modifica macro prodotto";
        $data['template'] = view('/prodotti/new_macro_prodotto',$data); 
        return view('layout', $data);
    }

    public function modify_macro_prodotto()
    {
        $data = $this->request->getPost();

        $rules = [
            'name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire il Nome',
                ],
            ]
        ];

        if (! $this->validateData($data, $rules)) 
        {
            $data['macroprodotto'] = [];
            if(!empty($id)) $data['macroprodotto'] = $this->model->getMacroProducts($id);
            $data['title'] = empty($id) ? "Nuovo macro prodotto" : "Modifica macro prodotto";
            $data['template'] = view('/prodotti/new_macro_prodotto',$data); 
            return view('layout', $data);
        }

        if(!empty($data['id_update']))
        {
            $this->model->UpdateMacroProducts(array('nome' => $data['name']),['macroId' => $data['id_update']]);
        }    
        else
            $this->model->InsertMacroProducts(array('nome' => $data['name']));

        $data = [];
        $data['title'] = "Macro prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['template'] = view('/prodotti/macroprodotti',$data);
        return view('layout', $data);
    }  

    public function delete_macro_products($id)
    {
        $this->model->DeleteMacroProducts($id);
        $data = [];
        $data['title'] = "Macro prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['template'] = view('/prodotti/macroprodotti',$data);
        return view('layout', $data);
    }

    public function get_products()
    {
        $data = [];
        $data['title'] = "Prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['prodotti'] = $this->model->getProducts();
        $data['template'] = view('/prodotti/prodotti',$data);
        return view('layout', $data);
    }

     public function insert_update_products($id = null)
    {
        $data['prodotto'] = [];
        if(!empty($id)) $data['prodotto'] = $this->model->getProducts($id);
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['title'] = empty($id) ? "Nuovo prodotto" : "Modifica prodotto";
        $data['template'] = view('/prodotti/new_prodotto',$data); 
        return view('layout', $data);
    }

     public function modify_prodotto()
    {
        $data = $this->request->getPost();

        $rules = [
            'macroId_Fk' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Selezionare il Macro prodotto',
                ],
            ],
            'name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Inserire il Nome',
                ],
            ]
        ];

        if (! $this->validateData($data, $rules))
        {
            $data['prodotto'] = [];
            if(!empty($id)) $data['prodotto'] = $this->model->getProducts($id);
            $data['macroprodsel'] = !empty($data['macroId_Fk']) ? $data['macroId_Fk'] : "";
            $data['macroprodotti'] = $this->model->getMacroProducts();
            $data['title'] = empty($id) ? "Nuovo prodotto" : "Modifica prodotto";
            $data['template'] = view('/prodotti/new_prodotto',$data); 
            return view('layout', $data);
        } 
                

        if(!empty($data['id_update']))
        {
            $this->model->UpdateProducts(array('macroId_Fk' => $data['macroId_Fk'],'nome' => $data['name']),['prodId' => $data['id_update']]);
        }    
        else
            $this->model->InsertProducts(array('macroId_Fk' => $data['macroId_Fk'],'nome' => $data['name']));

        $data = [];
        $data['title'] = "Prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['prodotti'] = $this->model->getProducts();
        $data['template'] = view('/prodotti/prodotti',$data);
        return view('layout', $data);
    }  

    public function delete_products($id)
    {
        $this->model->DeleteProducts($id);
        $data = [];
        $data['title'] = "Prodotti";
        $data['macroprodotti'] = $this->model->getMacroProducts();
        $data['prodotti'] = $this->model->getProducts();
        $data['template'] = view('/prodotti/prodotti',$data);
        return view('layout', $data);
    }
}