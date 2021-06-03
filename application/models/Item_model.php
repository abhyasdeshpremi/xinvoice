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

    public function unique_item_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('item_code', strtoupper($unique_code));
        $query = $this->db->get('Items');
        if($query->num_rows() === 1){
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

    public function update_item($data){
        $itemdata = array(
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
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('item_code', strtoupper($data['itemCode']));
        $this->db->update('Items',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function item_list(){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
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

    public function update_item_detail($item_id){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('item_code', $item_id);
        $query = $this->db->get('Items');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function delete_item($item){
        $result = array();
        $this->db->where('item_code', $item['item_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Items');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('item_code', $item['item_code']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Items', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $item['item_code'];
        }else{
            $result['code']  = false;
            $result['itemid']  = $item['item_code'];
        }
        return $result;
    }
}
?>