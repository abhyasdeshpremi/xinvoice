<?php

class Item_model extends CI_Model {

    protected $table = 'Items';

    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($globalsearchtext = '') {
        $this->db->select('pk_item_id');
        $this->db->from($this->table);
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('name', $globalsearchtext, "both");
            $this->db->or_like('company_code', $globalsearchtext, "both");
            $this->db->group_end();
        }
        return $this->db->count_all_results();
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
            'HSN_Code'=>$data['HSN_Code'],
            'Style_No'=>$data['Style_No'],
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
            'HSN_Code'=>$data['HSN_Code'],
            'Style_No'=>$data['Style_No'],
            'company_code'=>$data['itemCompanyCode'],
            'fk_firm_code'=> $this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('item_code', strtoupper($data['itemCode']));
        $this->db->update('Items',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function item_list($limit, $start, $globalsearchtext = ''){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('name', $globalsearchtext, "both");
            $this->db->or_like('company_code', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->order_by("name", "ASC");
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


    /*****
     * Product group list Model
     */

    public function get_group_count() {
        $this->db->select('gfi_id');
        $this->db->from("Group_for_item");
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function item_group_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("name", "ASC");
        $query = $this->db->get('Group_for_item');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function unique_item_group_code_verify($unique_code){
        $this->db->where('pk_gfi_unique_code', strtoupper($unique_code));
        $query = $this->db->get('Group_for_item');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_item_group_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('pk_gfi_unique_code', strtoupper($unique_code));
        $query = $this->db->get('Group_for_item');
        if($query->num_rows() === 1){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_group_item($data){
        $data = array(
            'pk_gfi_unique_code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['productgroupName'],
            'description'=>$data['description'],
            'fk_firm_code'=> $this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Group_for_item',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete_product_group($data){
        $result = array();
        $this->db->where('pk_gfi_unique_code', $data['productgroupCode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Group_for_item');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES'
            );
            $this->db->where('pk_gfi_unique_code', $data['productgroupCode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Group_for_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['productgroupCode']  = $data['productgroupCode'];
        }else{
            $result['code']  = false;
            $result['productgroupCode']  = $data['productgroupCode'];
        }
        return $result;
    }

    public function update_group_of_product_detail($group_of_product_id){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('pk_gfi_unique_code', $group_of_product_id);
        $query = $this->db->get('Group_for_item');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_group_of_product($data){
        $itemdata = array(
            'name'=>$data['productgroupName'],
            'description'=>$data['description']
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('pk_gfi_unique_code', strtoupper($data['uniqueCode']));
        $this->db->update('Group_for_item',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function product_group_list($productgroupcode){
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_gfi_unique_code', $productgroupcode);
        $query = $this->db->get('Group_of_items');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }


    public function saveProducttoproductgroup($data){
        $result = array();
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_item_code', $data['itemcode']);
        $this->db->where('fk_gfi_unique_code', $data['productgroupcode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Group_of_items');
        if($query->num_rows() == 1){
            foreach ($query->result() as $row)  
            {  
                $result['itemcode'] = $row->fk_item_code;
                $result['itemname'] = $row->fk_item_name;
                $result['oldQuatity'] = $row->quantity;
            }

            $dataList = array(
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$data['quatity'],
                'case_unit'=>$data['itemunitcase'],
                'mrp'=>$data['itemmrp'],
                'mrp_value'=>$data['itemdmrpvalue'],
                'discount'=>$data['itemdiscount'],
                'bill_value'=>$data['itembillValue'],
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('fk_item_code', $data['itemcode']);
            $this->db->where('fk_gfi_unique_code', $data['productgroupcode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Group_of_items', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $data['itemID'];
        }else{
            $dataList = array(
                'fk_gfi_unique_code'=>$data['productgroupcode'],
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$data['quatity'],
                'case_unit'=>$data['itemunitcase'],
                'mrp'=>$data['itemmrp'],
                'mrp_value'=>$data['itemdmrpvalue'],
                'discount'=>$data['itemdiscount'],
                'bill_value'=>$data['itembillValue'],
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert('Group_of_items', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $this->db->insert_id();
        }
        return $result;
    }

    public function delete_group_product($group_Item){
        $result = array();
        $this->db->where("goi_id", $group_Item["productgroupCode"]);
        $this->db->where("fk_firm_code", $this->session->userdata("firmcode"));
        $query = $this->db->get("Group_of_items");
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'yes',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where("fk_firm_code", $this->session->userdata("firmcode"));
            $this->db->where("goi_id", $group_Item["productgroupCode"]);
            $this->db->update("Group_of_items", $dataList);
            $result["code"]  = ($this->db->affected_rows() == 1) ? true : false;
            $result["goi_id"]  = $group_Item["productgroupCode"];
        }else{
            $result["code"]  = false;
            $result["goi_id"]  = $group_Item["productgroupCode"];
        }
        $result["query"] = $this->db->last_query();
        return $result;
    }

    public function get_group_of_products_list($gfi_unique_code){
        $this->db->select("*");
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_gfi_unique_code', $gfi_unique_code);
        $query = $this->db->get('Group_of_items');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        $data['last_query'] = $this->db->last_query();
        return $data;
    }
}
?>