<?php

class Firm_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function primary_firm(){
        $data = array();
        $this->db->where('fk_username', $this->session->userdata('username'));
        $query = $this->db->get('Firms');
        if($query->num_rows() === 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>