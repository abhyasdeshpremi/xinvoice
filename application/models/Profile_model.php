<?php

class Profile_model extends CI_Model {
    protected $table = 'Users';
    function __construct()  
    {  
        parent::__construct();
    }  


    public function profile($username){
        $this->db->select('Users.username, Users.email, Users.first_name, Users.last_name, Users.mobile_number, Users.role, Firms.name, Firms.firm_email, Firms.address, Firms.area, Firms.city, Firms.district, Firms.state, Firms.pin_code, Firms.mobile_number, Firms.bill_include_tax, Firms.bonus_percent, Firms.business_type, Business_type.business_name');
        if ($this->session->userdata('role') != "superadmin"){
            $this->db->where('Users.fk_firm_code', $this->session->userdata('firmcode'));
        }
        $this->db->where('Users.username', $username);
        $this->db->from('Users');
        $this->db->join('Firms', 'Users.fk_firm_code = Firms.firm_code');
        $this->db->join('Business_type', 'Business_type.business_code = Firms.business_type');
        $query = $this->db->get();
       
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function changedPassword($data){
        $result = array();
        $this->db->where('username', $this->session->userdata('username'));
        $this->db->where('password', md5(trim($data['oldpassword'])));
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('delete_flag', 'NO');
        $query = $this->db->get('Users');
        if($query->num_rows() == 1){
            $userList = array(
                'password'=> md5(trim($data['newpassword'])),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('username', $this->session->userdata('username'));
            $this->db->where('password', md5(trim($data['oldpassword'])));
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->where('delete_flag', 'NO');
            $this->db->update('Users', $userList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
        }else{
            $result['code']  = false;
        }
        $result['query'] = $this->db->last_query();
        return $result;
    }
}
?>