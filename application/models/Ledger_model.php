<?php

class Ledger_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
    }  

    public function stock_list($arg){
        $startDate = $arg['start_date']." 00:00:00";
        // $startDateFormat = date('Y-m-d H:i:s', $startDate);
        $endDate = $arg['end_date']. " 23:59:59";
        // $endDateFormat = date('Y-m-d H:i:s', $endDate);
        $this->db->select('Stocks.item_code, Stocks.item_name, Stocks.item_total_count');
        $this->db->where('Stocks.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("Stocks.item_name", "ASC");
        $this->db->from('Stocks');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            
            foreach ($query->result() as $row)  
            {  
                $tempData = array();
                $tempData["item_code"] = $row->item_code;
                $tempData["item_name"] = $row->item_name;
                $tempData["item_total_count"] = $row->item_total_count;
                /*
                * Get total sell item count
                */
                $this->db->select_sum('item_count');
                $this->db->from('Stocks_Entry');
                $this->db->where('item_code', $row->item_code);
                $this->db->where('entry_type', "sell");
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $this->db->where("created_at BETWEEN '$startDate' AND '$endDate'");
                $itemSellCountQuery = $this->db->get();
                $sell_count_value = $itemSellCountQuery->row()->item_count;
                $sell_count_value = round($sell_count_value);
                $tempData["sell_count_value"] = $sell_count_value;

                /*
                * Get total purchase item count
                */
                $this->db->select_sum('item_count');
                $this->db->from('Stocks_Entry');
                $this->db->where('item_code', $row->item_code);
                $this->db->where('entry_type', "buy");
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $this->db->where("created_at BETWEEN '$startDate' AND '$endDate'");
                $itemBuyCountQuery = $this->db->get();
                $buy_count_value = $itemBuyCountQuery->row()->item_count;
                $buy_count_value = round($buy_count_value);
                $tempData["buy_count_value"] = $buy_count_value;
                
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
                
                $tempData["bill_per_item_value"] = number_format(($billValue / $itemQuantity), 2);
                $data['result'][] = $tempData;
            }
            $data['code'] = true;
            // $data['result'] = $query->result();
        }else{
            $data['code'] = false;
            $data['result'] = array();
        }
        return $data;
    }

    public function sale_list($arg){
        $startDate = $arg['start_date']." 00:00:00";
        // $startDateFormat = date('Y-m-d H:i:s', $startDate);
        $endDate = $arg['end_date']. " 23:59:59";
        // $endDateFormat = date('Y-m-d H:i:s', $endDate);
        $this->db->select('Account.fk_client_code, Account.fk_client_name, Account.total_amount, Clients.district');
        $this->db->where('Account.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where_not_in('Clients.client_type', 'mine');
        $this->db->order_by("Clients.district", "ASC");
        $this->db->from('Account');
        $this->db->join('Clients', 'Account.fk_client_code = Clients.code');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            
            foreach ($query->result() as $row)  
            {  
                $tempData = array();
                $tempData["fk_client_code"] = $row->fk_client_code;
                $tempData["fk_client_name"] = $row->fk_client_name;
                $tempData["district"] = strtoupper($row->district);
                $tempData["total_amount"] = $row->total_amount;
                /*
                * Get total debit item count
                */
                $this->db->select_sum('amount');
                $this->db->from('Account_Entry');
                $this->db->where('fk_client_code', $row->fk_client_code);
                $this->db->where('payment_type', "debit");
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $this->db->where("payment_date BETWEEN '$startDate' AND '$endDate'");
                $itemSellCountQuery = $this->db->get();
                $sell_count_value = $itemSellCountQuery->row()->amount;
                $sell_count_value = round($sell_count_value);
                $tempData["debit_count_value"] = $sell_count_value;

                /*
                * Get total credit item count
                */
                $this->db->select_sum('amount');
                $this->db->from('Account_Entry');
                $this->db->where('fk_client_code', $row->fk_client_code);
                $this->db->where('payment_type', "credit");
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $this->db->where("payment_date BETWEEN '$startDate' AND '$endDate'");
                $itemBuyCountQuery = $this->db->get();
                $buy_count_value = $itemBuyCountQuery->row()->amount;
                $buy_count_value = round($buy_count_value);
                $tempData["credit_count_value"] = $buy_count_value;
                
                $data['result'][] = $tempData;
            }
            $data['code'] = true;
            // $data['result'] = $query->result();
        }else{
            $data['code'] = false;
            $data['result'] = array();
        }
        return $data;
    }

    public function client_list($arg){
        $startDate = $arg['start_date']." 00:00:00";
        // $startDateFormat = date('Y-m-d H:i:s', $startDate);
        $endDate = $arg['end_date']. " 23:59:59";
        // $endDateFormat = date('Y-m-d H:i:s', $endDate);
        $invoiceStatus = array('completed', 'partial_paid', 'paid');
        $this->db->select('pk_invoice_id, unique_invioce_code, fk_client_code, client_name, gstnumber, payment_mode, lock_bill_amount, created_at');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('invoice_type', 'sell');
        $this->db->where_in('status', $invoiceStatus);
        $this->db->where("created_at BETWEEN '$startDate' AND '$endDate'");
        $this->db->order_by("created_at", "ASC");
        $this->db->from('Invoices');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            
            foreach ($query->result() as $row)  
            {  
                $tempData = array();
                $tempData["pk_invoice_id"] = $row->pk_invoice_id;
                $tempData["unique_invioce_code"] = $row->unique_invioce_code;

                $tempData["fk_client_code"] = $row->fk_client_code;
                $tempData["client_name"] = $row->client_name;
                $tempData["gstnumber"] = $row->gstnumber;
                $tempData["payment_mode"] = $row->payment_mode;

                $tempData["lock_bill_amount"] = $row->lock_bill_amount;
                $tempData["created_at"] = $row->created_at;

                $date = date_create($row->created_at);
                $tempData["bill_date"] = date_format($date,"d-M-y");
                $tempData["invoice_bill_date"] = date_format($date,"m-y");

                $bill_value = (float)$row->lock_bill_amount;
                $basicValue = round((($bill_value * 100) / 118), 2);
                $cgstValue = round((($basicValue * 9) / 100), 2);
                $total_cgst_value = $basicValue + $cgstValue;
                $total_cgst_sgst_value = ($total_cgst_value + $cgstValue);
                $bill_amount = round($total_cgst_sgst_value, 0);
                $round_off = round(($bill_amount - $total_cgst_sgst_value), 2);

                $tempData["basic_value_amount"] =  $basicValue;

                $tempData["cgst_amount"] =  $cgstValue;
                $tempData["sgst_amount"] =  $cgstValue;
                $tempData["round_off_amount"] =  $round_off;
                
                $data['result'][] = $tempData;
            }
            $data['code'] = true;
            // $data['result'] = $query->result();
        }else{
            $data['code'] = false;
            $data['result'] = array();
        }
        return $data;
    }

}
?>