<?php

class Ledger_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function stock_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("item_name", "ASC");
        $query = $this->db->get('Stocks');
        if($query->num_rows() > 0){
            $data['code'] = true;
            $data['result'] = $query->result();
        }else{
            $data['code'] = false;
            $data['result'] = array();
        }
        return $data;
    }
}
?>