<?php

class Client_model extends CI_Model {
    protected $table = 'Clients';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($globalsearchtext = '') {
        $this->db->select('pk_client_id');
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('name', $globalsearchtext, "both");
            $this->db->or_like('mobile_no', $globalsearchtext, "both");
            $this->db->or_like('client_type', $globalsearchtext, "both");
            $this->db->or_like('address', $globalsearchtext, "both");
            $this->db->or_like('city', $globalsearchtext, "both");
            $this->db->or_like('district', $globalsearchtext, "both");
            $this->db->or_like('area', $globalsearchtext, "both");
            $this->db->or_like('state', $globalsearchtext, "both");
            $this->db->or_like('pin_code', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
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

    public function unique_client_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('code', strtoupper($unique_code));
        $query = $this->db->get('Clients');
        if($query->num_rows() === 1){
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

    public function update_client($data){
        $itemdata = array(
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
            'pin_code'=>$data['clientZip']
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('code', strtoupper($data['uniqueCode']));
        $this->db->update('Clients',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function client_list($limit, $start, $globalsearchtext = ''){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('name', $globalsearchtext, "both");
            $this->db->or_like('mobile_no', $globalsearchtext, "both");
            $this->db->or_like('client_type', $globalsearchtext, "both");
            $this->db->or_like('address', $globalsearchtext, "both");
            $this->db->or_like('city', $globalsearchtext, "both");
            $this->db->or_like('district', $globalsearchtext, "both");
            $this->db->or_like('area', $globalsearchtext, "both");
            $this->db->or_like('state', $globalsearchtext, "both");
            $this->db->or_like('pin_code', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_client_detail($client_id){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('code', $client_id);
        $query = $this->db->get('Clients');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function client_by_id($unique_code){
        $data = array();
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('code', $unique_code);
        $query = $this->db->get('Clients');
        if($query->num_rows() == 1){
            foreach ($query->result() as $row)  
            {  
                $data['code'] = $row->code;
                $data['name'] = $row->name;
                $data['gst_no'] = $row->gst_no;
                $data['pan_no'] = $row->pan_no;
                $data['mobile_no'] = $row->mobile_no;
                $data['address'] = $row->address;
                $data['city'] = $row->city;
                $data['district'] = $row->district;
                $data['state'] = $row->state;
                $data['area'] = $row->area;
                $data['pin_code'] = $row->pin_code;
                $data['client_type'] = $row->client_type;
            }
        }
        return $data;
    }

    public function delete_client($client){
        $result = array();
        $this->db->where('code', $client['client_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Clients');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('code', $client['client_code']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Clients', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['clientid']  = $client['client_code'];
        }else{
            $result['code']  = false;
            $result['clientid']  = $client['client_code'];
        }
        return $result;
    }

    public function clients_list(){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
}

?>