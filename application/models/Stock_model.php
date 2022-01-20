<?php

class Stock_model extends CI_Model {
    protected $table = 'Stocks';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count() {
        $this->db->select('item_code');
        $this->db->from($this->table);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function stock_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("item_name", "ASC");
        $query = $this->db->get('Stocks');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
    
    public function saveStock($data){
        $result = array();
        $this->db->where('item_code', $data['item_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Stocks');
        if($query->num_rows() == 1){
            $preTotalStockItem = 0;
            foreach ($query->result() as $row)  
            {  
                $result['stockid'] = $row->pk_stock_id;
                $preTotalStockItem = $row->item_total_count;

            }
            $updateStock = (int)$preTotalStockItem;
            if($data['stocktype'] == 'buy'){
                $updateStock = (int)$preTotalStockItem + (int)$data['stockunit'];
            }elseif($data['stocktype'] == 'sell'){
                $updateStock = (int)$preTotalStockItem - (int)$data['stockunit'];
            }

            if($data['stocktype'] == 'sell'){
                if((int)$data['stockunit'] > (int)$preTotalStockItem){
                    $result['code'] = false;
                    $result['stockid'] = '';
                    return $result;
                }
            }

            $dataList = array( 
                'item_total_count'=> $updateStock,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_stock_id', $result['stockid']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Stocks', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['stockid']  = $result['stockid'];
        }else{
            $dataList = array(
                'item_code'=>$data['item_code'],
                'item_name'=>$data['item_name'],
                'item_total_count'=> (int)$data['stockunit'],
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert('Stocks', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['stockid']  = $this->db->insert_id();
        }

        $Stocks_EntryList = array(
            'item_code'=>$data['item_code'],
            'item_name'=>$data['item_name'],
            'item_count'=>(int)$data['stockunit'],
            'fk_stock_id'=>$result['stockid'],
            'entry_type'=>$data['stocktype'],
            'comment'=>$data['stockcomment'],
            'fk_username'=>$this->session->userdata('username'),
            'fk_firm_code'=>$this->session->userdata('firmcode')
        );
        $this->db->insert('Stocks_Entry', $Stocks_EntryList);
        $result['stockcode']  = ($this->db->affected_rows() == 1) ? true : false;

        return $result;
    }
}
?>