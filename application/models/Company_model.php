<?php

class Company_model extends CI_Model {
    protected $table = 'Companies';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count() {
        $this->db->select('pk_company_id');
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function unique_company_code_verify($unique_code){
        $this->db->where('company_code', strtoupper($unique_code));
        $query = $this->db->get('Companies');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_company_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('company_code', strtoupper($unique_code));
        $query = $this->db->get('Companies');
        if($query->num_rows() === 1){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_company($data){
        $data = array(
            'company_code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['companyName'],
            'description'=>$data['description'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Companies',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function company_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Companies');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_company_detail($companycode){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('company_code', $companycode);
        $query = $this->db->get('Companies');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_company($data){
        $itemdata = array(
            'name'=>$data['companyName'],
            'description'=>$data['description'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('company_code', strtoupper($data['uniqueCode']));
        $this->db->update('Companies',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete_company($company){
        $result = array();
        $this->db->where('company_code', $company['companyCode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Companies');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('company_code', $company['companyCode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Companies', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['companyCode']  = $company['companyCode'];
        }else{
            $result['code']  = false;
            $result['companyCode']  = $company['companyCode'];
        }
        return $result;
    }
}

?>