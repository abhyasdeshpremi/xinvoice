<?php

class Stock_model extends CI_Model {
    protected $table = 'Stocks';
    protected $logtable = 'Stocks_Entry';
    protected $invoiceitemtable = 'invoice_item';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($globalsearchtext = '') {
        $this->db->select('item_code');
        $this->db->from($this->table);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('item_name', $globalsearchtext, "both");
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function stock_list($limit, $start, $globalsearchtext = ''){
        $this->db->limit($limit, $start);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('item_name', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->order_by("item_name", "ASC");
        $query = $this->db->get('Stocks');
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)  
            { 
                $tempData = array();
                $tempData["pk_stock_id"] = $row->pk_stock_id;
                $tempData["item_code"] = $row->item_code;
                $tempData["item_name"] = $row->item_name;
                $tempData["item_total_count"] = $row->item_total_count;
                $tempData["fk_firm_code"] = $row->fk_firm_code;
                $tempData["created_at"] = $row->created_at;
                $tempData["updated_at"] = $row->updated_at;
                $tempData["fk_username"] = $row->fk_username;
                 
                /*
                * Get Bill value of item
                */
                $this->db->select('invoice_item.bill_value, invoice_item.quantity');
                $this->db->where('invoice_item.fk_firm_code', $this->session->userdata('firmcode'));
                $this->db->where('invoice_item.fk_item_code', $row->item_code);
                $this->db->where('Invoices.invoice_type', 'purchase');
                $this->db->from('invoice_item');
                $this->db->join('Invoices', 'invoice_item.fk_unique_invioce_code = Invoices.unique_invioce_code');
                $this->db->order_by("invoice_item.created_at", "DESC");
                $this->db->order_by("invoice_item.updated_at", "DESC");
                $this->db->limit(1);
                $queryBillValue = $this->db->get();
                $billValue = 1;
                $itemQuantity = 1;
                if($queryBillValue->num_rows() > 0){
                    foreach ($queryBillValue->result() as $billRow)  
                    {  
                        $billValue = $billRow->bill_value;
                        $itemQuantity = $billRow->quantity;
                    }
                }
                $bill_per_item_value = $billValue / $itemQuantity;
                $tempData["bill_per_item_value"] = number_format($bill_per_item_value, 2);
                $totalBillValue = $bill_per_item_value * $row->item_total_count;
                $tempData["bill_total_bill_value"] = number_format($totalBillValue, 2);
                $data['result'][] = $tempData;
            }

        }else{
            $data['result'] = array();
        }
        return $data;
    }
    
    public function get_log_count($itemcode = NULL) {
        $this->db->select('pk_invoice_item_id');
        $this->db->from($this->invoiceitemtable);
        if ($itemcode != NULL) {
            $this->db->where('fk_item_code', $itemcode);
        }
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function stock_log_list($limit, $start, $itemcode = NULL){
        $this->db->select('Invoices.invoice_type, fk_unique_invioce_code, fk_item_code, fk_item_name, quantity, bill_value, invoice_item.created_at, invoice_item.fk_username');
        $this->db->limit($limit, $start);
        if ($itemcode != NULL) {
            $this->db->where('invoice_item.fk_item_code', $itemcode);
        }
        $this->db->where('invoice_item.delete_flag', 'NO');
        $this->db->where('invoice_item.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("invoice_item.created_at", "DESC");
        $this->db->from($this->invoiceitemtable);
        $this->db->join('Invoices', 'invoice_item.fk_unique_invioce_code = Invoices.unique_invioce_code');
        $query = $this->db->get();
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

            /* if($data['stocktype'] == 'sell'){
                if((int)$data['stockunit'] > (int)$preTotalStockItem){
                    $result['code'] = false;
                    $result['stockid'] = '';
                    return $result;
                }
            }*/

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
            $updateStock = 0;
            if($data['stocktype'] == 'buy'){
                $updateStock = (int)$data['stockunit'];
            }elseif($data['stocktype'] == 'sell'){
                $updateStock =  - (int)$data['stockunit'];
            }
            $dataList = array(
                'item_code'=>$data['item_code'],
                'item_name'=>$data['item_name'],
                'item_total_count'=> $updateStock,
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