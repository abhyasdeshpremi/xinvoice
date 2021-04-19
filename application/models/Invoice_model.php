<?php

class Invoice_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function client_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function unique_company_code_verify($unique_code){
        $this->db->where('company_code', strtoupper($unique_code));
        $query = $this->db->get('Companies');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_company($data){
        $data = array(
            'company_code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['companyName'],
            'description'=>$data['description'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Companies',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function company_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Companies');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>