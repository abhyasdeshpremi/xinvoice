<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firm extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Firm_model', '', TRUE);
    }
    

	public function index()
	{
        $queryResult = $this->Firm_model->primary_firm();
		$data = array();
        $data['data'] = $queryResult['result'];
        $this->template->set('title', 'Firm');
        $this->template->load('default_layout', 'contents' , 'firm/firm', $data);
	}

    public function createfirm(){
        $data = array();
        $this->template->set('title', 'Create Firm');
        $this->template->load('default_layout', 'contents' , 'firm/createfirm', $data);
    }

    public function firmdetails(){
        $data = array();
        $this->template->set('title', 'Firm Detail');
        $this->template->load('default_layout', 'contents' , 'firm/firmdetail', $data);
    }
}
