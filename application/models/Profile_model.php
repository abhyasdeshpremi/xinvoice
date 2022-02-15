<?php

class Profile_model extends CI_Model {
    protected $table = 'Users';
    function __construct()  
    {  
        parent::__construct();
    }  


    public function profile($username){
        $this->db->select('Users.username, Users.email, Users.first_name, Users.last_name, Users.mobile_number, Users.role, Firms.name, Firms.firm_email, Firms.address, Firms.area, Firms.city, Firms.district, Firms.state, Firms.pin_code, Firms.mobile_number, Firms.bill_include_tax');
        if ($this->session->userdata('role') != "superadmin"){
            $this->db->where('Users.fk_firm_code', $this->session->userdata('firmcode'));
        }
        $this->db->where('Users.username', $username);
        $this->db->from('Users');
        $this->db->join('Firms', 'Users.fk_firm_code = Firms.firm_code');
        $query = $this->db->get();
       
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}
?>