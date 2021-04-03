<?php

class Login_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function login($email, $password){
        $data = array();
        $this->db->where('status', 'active');
        $this->db->where('email', trim($email));
        $this->db->where('password', md5(trim($password)));
        $query = $this->db->get('Users');
        if($query->num_rows() === 1){
            $data['login'] = TRUE;
            $data['result'] = $query->result();
        }else{
            $data['login'] = FALSE;
            $data['result'] = array();
        }
        return $data;
    }
}

?>