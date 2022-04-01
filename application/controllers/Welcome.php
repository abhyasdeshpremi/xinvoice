<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function mail_test(){
		echo "Mail start";
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://mail.irotore.com',
			'smtp_timeout' => 30,
			'smtp_port' => 465,
			'smtp_user' => 'report@irotore.com',
			'smtp_pass' => 'Report$#@!9876',
			'charset' => 'iso-8859-1',
			'charset' => 'utf-8',
			'mailtype' => 'html',
			'newline' => '\r\n'
		);

		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->to('abhyaskumardeshpremi@gmail.com');
		$this->email->from('abhyas.deshpremi@techment.com');

		$string = "<a href='https://irotore.com/createinvoicepdf/L29QNEoxS1NFM0Z3bjFoYUJFUjZJakQxcDZvQmlOZUJXVTZ6Z081TFNKa2FCblhraElsaHpnMk5XV01hWllVSjdNbUtoQjNjdDhIZzh6ZU1WOEphdmc9PQ==/portrait/0'>Report</a>";

		$this->email->subject('Email Test');
		$this->email->message('I am abhyas are you interest on this mail'.$string);
		//https://irotore.com/createinvoicepdf/L29QNEoxS1NFM0Z3bjFoYUJFUjZJakQxcDZvQmlOZUJXVTZ6Z081TFNKa2FCblhraElsaHpnMk5XV01hWllVSjdNbUtoQjNjdDhIZzh6ZU1WOEphdmc9PQ==/portrait/1
		// $this->email->attach('https://irotore.com/createinvoicepdf/L29QNEoxS1NFM0Z3bjFoYUJFUjZJakQxcDZvQmlOZUJXVTZ6Z081TFNKa2FCblhraElsaHpnMk5XV01hWllVSjdNbUtoQjNjdDhIZzh6ZU1WOEphdmc9PQ==/portrait/0');
		echo "<br>";
		if($this->email->send()){
			print_r("Email sent!");
		}else{
			print_r($this->email->print_debugger());
			print_r("unable to sent a mail.");
		}
		echo "<br>";
		echo "Mail end";
	}
}
