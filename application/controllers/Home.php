<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(1, $this->session->userdata('role'))){
            redirect('/login');
        }
		$this->load->model('Home_model', '', TRUE);
    }

	public function index()
	{
		$data = array();
        $todaySale = $this->Home_model->today_sale();
        $sell_30graph = $this->Home_model->sell_30graph();
        $cash_30graph = $this->Home_model->cash_30graph();
        // print_r($todaySale);
        // $data['debit_count_value'] = $todaySale[0]['debit_count_value'];
        // $data['credit_count_value'] = $todaySale[0]['credit_count_value'];
        $data['sale'] = $todaySale;
        $data['sell_30graph'] = $sell_30graph['result'];
        $data['cash_30graph'] = $cash_30graph['result'];
        $this->template->set('title', 'Home');
        $this->template->load('default_layout', 'contents' , 'home', $data);
	}
}
