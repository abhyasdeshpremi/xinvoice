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

    public function firm_detail($firm_code){
        $data = array();
        $this->db->where('status', 'active');
        $this->db->where('firm_code', trim($firm_code));
        $query = $this->db->get('Firms');
        if($query->num_rows() === 1){
            $data['flag'] = TRUE;
            $data['result'] = $query->result();
        }else{
            $data['flag'] = FALSE;
            $data['result'] = array();
        }
        return $data;
    }

    public function firmUniqueCode($firm_Code){
        $data = array();
        $this->db->where('firm_code', trim($firm_Code));
        $query = $this->db->get('Firms');
        if($query->num_rows() === 1){
            $data['flag'] = TRUE;
        }else{
            $data['flag'] = FALSE;
        }
        return $data;
    }

    public function checkuseremail($email){
        $data = array();
        $this->db->where('email', trim($email));
        $query = $this->db->get('Users');
        if($query->num_rows() === 1){
            $data['flag'] = TRUE;
        }else{
            $data['flag'] = FALSE;
        }
        return $data;
    }

    public function checkusername($username){
        $data = array();
        $this->db->where('username', trim($username));
        $query = $this->db->get('Users');
        if($query->num_rows() === 1){
            $data['flag'] = TRUE;
        }else{
            $data['flag'] = FALSE;
        }
        return $data;
    }

    public function registeruser($data){
        $datalist = array();

        $dataFirm = array(
            'firm_code'=>strtoupper($data['firmuniquecode']),
            'name'=>$data['firmName'],
            'firm_email'=>$data['firmEmail'],
            'address'=>$data['firmAddress'],
            'area'=>$data['firmArea'],
            'city'=>$data['firmCity'],
            'district'=>$data['firmdistrict'],
            'state'=>$data['firmState'],
            'pin_code'=>$data['firmZip'],
            'mobile_number'=>$data['firmMobile'],
            'fk_username'=> 'REGISTERUSER'
        );
        $this->db->insert('Firms',$dataFirm);
        $datalist['firminsertFlag'] = ($this->db->affected_rows() != 1) ? false : true;
        $datalist['firmlastquery'] = $this->db->last_query();

        $dataUser = array(
            'username'=>strtoupper($data['username']),
            'email'=>$data['firmEmail'],
            'password'=>md5(trim($data['password'])),
            'first_name'=>$data['firstname'],
            'last_name'=>$data['lastname'],
            'mobile_number'=>$data['firmMobile'],
            'status'=>'active',
            'role'=>'admin',
            'fk_firm_code'=> strtoupper($data['firmuniquecode']),
            'fk_username'=> 'REGISTERUSER'
        );
        $this->db->insert('Users',$dataUser);
        $datalist['userinsertFlag'] = ($this->db->affected_rows() != 1) ? false : true;
        $datalist['userlastquery'] = $this->db->last_query();

        

        return $datalist;
    }
    
}

?>