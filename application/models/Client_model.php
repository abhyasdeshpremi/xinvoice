<?php

class Client_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_enum_values( $table = 'Clients', $field = 'client_type'){
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    public function unique_client_code_verify($unique_code){
        $this->db->where('code', strtoupper($unique_code));
        $query = $this->db->get('Clients');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_client($data){
        $data = array(
            'code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['clientName'],
            'gst_no'=>$data['clientgst'],
            'pan_no'=>$data['clientPan'],
            'aadhar_no'=>$data['clientaadhar'],
            'mobile_no'=>$data['clientMobile'],
            'fssai_no'=>$data['clientfssai'],
            'client_type'=>$data['clienttype'],
            'address'=>$data['clientAddress'],
            'area'=>$data['clientArea'],
            'city'=>$data['clientCity'],
            'district'=>$data['clientdistrict'],
            'state'=>$data['clientState'],
            'pin_code'=>$data['clientZip'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Clients',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function client_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>