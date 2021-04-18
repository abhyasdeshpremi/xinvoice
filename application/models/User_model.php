<?php

class User_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function unique_username_verify($username){
        $this->db->where('username', strtoupper($username));
        $query = $this->db->get('Users');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_email_verify($email){
        $this->db->where('email', strtoupper($email));
        $query = $this->db->get('Users');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_mobile_verify($mobile){
        $this->db->where('mobile_number', strtoupper($mobile));
        $query = $this->db->get('Users');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_user($data){
        $data = array(
            'username'=>strtoupper($data['username']),
            'email'=>$data['email'],
            'password'=>md5(trim($data['password'])),
            'first_name'=>$data['firstName'],
            'last_name'=>$data['lastName'],
            'mobile_number'=>$data['mobile'],
            'status'=>$data['userStatus'],
            'role'=>$data['userRole'],
            'fk_firm_code'=> $this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Users',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function user_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where_not_in('email', $this->session->userdata('email'));
        $query = $this->db->get('Users');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
    
}
?>