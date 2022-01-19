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

    public function unique_username_check($username){
        $this->db->where('username', strtoupper($username));
        $query = $this->db->get('Users');
        if($query->num_rows() === 1){
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

    public function update_user($data){
        if ($this->session->userdata('role') == "superadmin"){
            $itemdata = array(
                'first_name'=>$data['firstName'],
                'last_name'=>$data['lastName'],
                'status'=>$data['userStatus'],
                'role'=>$data['userRole'],
                'fk_firm_code'=>$data['firmCode'],
                'updated_at'=>date('Y-m-d H:i:s')
            );
        }else{
            $itemdata = array(
                'first_name'=>$data['firstName'],
                'last_name'=>$data['lastName'],
                'status'=>$data['userStatus'],
                'role'=>$data['userRole'],
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        }
        
        $this->db->where('username', strtoupper($data['username']));
        $this->db->update('Users',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function user_list(){
        $this->db->where('delete_flag', 'NO');
        if ($this->session->userdata('role') != "superadmin"){
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        }
        $this->db->where_not_in('email', $this->session->userdata('email'));
        $query = $this->db->get('Users');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_user_detail($username){
        if ($this->session->userdata('role') != "superadmin"){
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        }
        $this->db->where('username', $username);
        $query = $this->db->get('Users');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function delete_user($username){
        $result = array();
        $this->db->where('username', $username['userName']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Users');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('username', $username['userName']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Users', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['username']  = $username['userName'];
        }else{
            $result['code']  = false;
            $result['username']  = $item['userName'];
        }
        return $result;
    }
    
}
?>