<?php

namespace App\Controllers;
use App\Models\AttivitaModel;
use App\Models\ContattiWebVistaModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class UploadController extends BaseController
{
    protected $model;
    protected $contact_model;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->model = new AttivitaModel();
        $this->contact_model = new ContattiWebVistaModel();

        $this->request = \Config\Services::request();
        helper('form');
    }

    public function index()
    {
        $data = [];
        $data['title'] = "Carico CSV contatti";
        $data['template'] = view('/upload_contatti/upload',$data); // Load the upload view
        return view('layout', $data);
    }

    public function upload()
    {
        $writepath = APPPATH . "ThirdParty/files_contacts";
        $file = $this->request->getFile('file');
        
        if ($file->isValid() && !$file->hasMoved()) 
        {
            // Move the file to the desired location
            $file->move($writepath); // Adjust the path as needed
            $name_file = $file->getName();

            $inserted = 0;
            $r = 0;
            $handle = fopen($writepath . "/" . $name_file, 'r');
            while(($line=fgets($handle)) !== false)
            {
                if((empty(trim($line))) || (preg_match('/^#/', $line) > 0))
                    continue;

                if($r == 0)
                    $header = explode(";",$line);  
                else
                {
                    $data_ins = [];
                    //salto tipologia e attivita per ora
                    $row = explode(";",$line);  

                    $c = 0;
                    foreach($row as $col)
                    {
                        //salto le colonne tipologiaId_Fk e attId_Fk
                        if($header[$c] != "contId") //&& $header[$c] != "tipologiaId_Fk" && $header[$c] != "attId_Fk") 
                        {
                            if($col != "NULL" && !empty($col))
                                $data_ins[$header[$c]] =  $col;
                        }
                            
                        $c++;
                    }

                    //inserisco il contatto nel DB 
                    if(sizeof($data_ins) > 0)
                    {
                        $this->contact_model->modify_contatto([],$data_ins);
                        $inserted++;
                    }
                }

                $r++;
            }

            fclose($handle);
            unlink($writepath . "/" . $name_file);

            $data = [];
            $data['title'] = "Carico CSV contatti";
            $data['esito'] = "INSERITI " . strval($inserted).  " CONTATTTI NEL DB";
            $data['template'] = view('/upload_contatti/upload',$data); // Load the upload view
            return view('layout', $data);    
        } 
        else 
        {
            return "File upload failed.";
        }
    }
}