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

    public function unique_firm_code_verify($unique_code){
        $this->db->where('firm_code', strtoupper($unique_code));
        $query = $this->db->get('Firms');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_firm($data){
        $data = array(
            'firm_code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['firmName'],
            'firm_email'=>$data['firmEmail'],
            'description'=>$data['description'],
            'address'=>$data['firmAddress'],
            'area'=>$data['firmArea'],
            'city'=>$data['firmCity'],
            'district'=>$data['firmdistrict'],
            'state'=>$data['firmState'],
            'pin_code'=>$data['firmZip'],
            'mobile_number'=>$data['firmMobile'],
            'fk_username'=> $this->session->userdata('username'),
            
        );
        $this->db->insert('Firms',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function firm_list(){
        $query = $this->db->get('Firms');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>