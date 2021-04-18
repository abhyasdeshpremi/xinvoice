<?php

class Item_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function unique_item_code_verify($unique_code){
        $this->db->where('item_code', strtoupper($unique_code));
        $query = $this->db->get('Items');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_item($data){
        $data = array(
            'item_code'=>strtoupper($data['uniqueItemCode']),
            'name'=>$data['itemName'],
            'sub_description'=>$data['itemsubdescription'],
            'weight_in_ltr'=>$data['weightinlitter'],
            'unit_case'=>$data['itemunitcase'],
            'mrp'=>$data['itemmrp'],
            'cost_price'=>$data['itemcostprice'],
            'op_balance_in_qty'=>$data['itemopbalanceinquantity'],
            'company_code'=>$data['itemCompanyCode'],
            'fk_firm_code'=> $this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Items',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function item_list(){
        $query = $this->db->get('Items');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
    
    public function company_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Companies');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}
?>