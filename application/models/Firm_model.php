<?php

class Firm_model extends CI_Model {
    protected $table = 'Firms';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count() {
        $this->db->select('pk_firm_id');
        $this->db->where('delete_flag', 'NO');
        $this->db->from($this->table);
        return $this->db->count_all_results();
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

    public function unique_firm_code_check($unique_code){
        $this->db->where('firm_code', strtoupper($unique_code));
        $query = $this->db->get('Firms');
        if($query->num_rows() === 1){
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
            'bill_include_tax'=>$data['billIncludeTax'],
            'bonus_percent'=>$data['firmbonus'],
            'business_type'=>$data['business_type'],
            'fk_username'=> $this->session->userdata('username'),
            
        );
        $this->db->insert('Firms',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update_firm($data){
        $itemdata = array(
            'name'=>$data['firmName'],
            'firm_email'=>$data['firmEmail'],
            'description'=>$data['description'],
            'address'=>$data['firmAddress'],
            'area'=>$data['firmArea'],
            'city'=>$data['firmCity'],
            'district'=>$data['firmdistrict'],
            'state'=>$data['firmState'],
            'bill_include_tax'=>$data['billIncludeTax'],
            'feature_group_for_item'=>$data['feature_group_for_item'],
            'feature_capture_saved_amount'=>$data['feature_capture_saved_amount'],
            'bonus_percent'=>$data['firmbonus'],
            'business_type'=>$data['business_type'],
            'pin_code'=>$data['firmZip'],
            'mobile_number'=>$data['firmMobile'],
            'status'=>$data['firmstatus'],
            'updated_at'=>date('Y-m-d H:i:s')
            
        ); 
        $this->db->where('firm_code', strtoupper($data['uniqueCode']));
        $this->db->update('Firms',$itemdata);
        $this->session->set_userdata('bonus_percent', $data['firmbonus']);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function firm_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'NO');
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Firms');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function firm_list_only(){
        $this->db->where('delete_flag', 'NO');
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Firms');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_firm_detail($firmCode){
        $this->db->where('firm_code', $firmCode);
        $query = $this->db->get('Firms');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function delete_firm($data){
        $result = array();
        $this->db->where('firm_code', $data['firmCode']);
        $query = $this->db->get('Firms');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('firm_code', $data['firmCode']);
            $this->db->update('Firms', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['firmCode']  = $data['firmCode'];
        }else{
            $result['code']  = false;
            $result['firmCode']  = $data['firmCode'];
        }
        return $result;
    }

    public function business_type_list(){
        $this->db->where('business_status', 'active');
        $this->db->order_by("business_name", "ASC");
        $query = $this->db->get('Business_type');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>