<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\CampagneModel;
use App\Models\EsitiModel;
use App\Models\AttivitaModel;
use App\Models\ProvinceModel;
use App\Models\TipologieModel;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class ajax extends BaseController
{
    protected $usermodel;
    protected $campmodel;
    protected $esitimodel;
    protected $attivitamodel;
    protected $provincemodel;
	protected $tipologiamodel;
    protected $request;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->usermodel = new UsersModel();
        $this->campmodel = new CampagneModel();
        $this->campmodel = new EsitiModel();
        $this->attivitamodel = new AttivitaModel();
        $this->provincemodel = new ProvinceModel();
		$this->tipologiamodel = new TipologieModel();

        $this->request = \Config\Services::request();
        helper('form');
    }

    public function searchUser(){
	    $search_str = $_GET['searchUser'] ?? "";
	    $users = $this->usermodel->search($search_str);

	    // Filter guests
	    $guestist = array();
	    foreach ($users['users'] as $user) 
        {
	            $guestist[] = array(
	                "id" => $user['id'],
	                "text" => $user['nome'] . " " . $user['cognome'],
	            );
	    }
	    
	    $data['results'] = $guestist;
	    echo json_encode($data);
	    die();
	}
	
	public function searchTipologia(){
	    $search_str = $_GET['searchTipologia'] ?? "";
	    $tipologia = $this->tipologiamodel->search($search_str);

	    // Filter guests
	    $guestist = array();
	    foreach ($tipologia['type'] as $type) 
        {
	            $guestist[] = array(
	                "id" => $type['id'],
	                "text" => $type['tipologia'],
	            );
	    }
	    
	    $data['results'] = $guestist;
	    echo json_encode($data);
	    die();
	}

    public function searchAttivita(){
	    $search_str = $_GET['searchAttivita'] ?? "";
	    $attivita = $this->attivitamodel->search($search_str);

	    // Filter guests
	    $guestist = array();
	    foreach ($attivita['att'] as $att) 
        {
	            $guestist[] = array(
	                "id" => $att['id'],
	                "text" => $att['nome'],
	            );
	    }
	    
	    $data['results'] = $guestist;
	    echo json_encode($data);
	    die();
	}

    public function searchProvince(){
	    $search_str = $_GET['searchProvince'] ?? "";
	    $province = $this->provincemodel->search($search_str);

	    // Filter guests
	    $guestist = array();
	    foreach ($province['province'] as $provincia) 
        {
	            $guestist[] = array(
	                "id" => $provincia['provId'],
	                "text" => $provincia['provNome'],
	            );
	    }
	    
	    $data['results'] = $guestist;
	    echo json_encode($data);
	    die();
	}


    public function index()
    {

    }
}