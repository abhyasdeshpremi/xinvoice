<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoicePDF extends CI_Controller {

    function index()
    {
        $this->load->library('pdf');
        $html = $this->load->view('GeneratePdfView', [], true);
        $this->pdf->createPDF($html, 'mypdf', false, 'A4', 'landscape');
    }
}
?>