<?php

class Home_model extends CI_Model {

    public $title;
    public $content;
    public $date;

    public function get_last_ten_entries()
    {
            $query = $this->db->get('entries', 10);
            return $query->result();
    }

    public function insert_entry()
    {
            $this->title    = $_POST['title']; // please read the below note
            $this->content  = $_POST['content'];
            $this->date     = time();

            $this->db->insert('entries', $this);
    }

    public function update_entry()
    {
            $this->title    = $_POST['title'];
            $this->content  = $_POST['content'];
            $this->date     = time();

            $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function today_sale(){
        $tempData = array();
        $startDate = date('y-m-d 00:00:00', strtotime('-6 days'));
        $endDate = date('y-m-d 23:59:59');
        $tempData["startDate"] = $startDate;
        $tempData["endDate"] = $endDate;

        $today = date('y-m-d 00:00:00');
        $thisWeek = date('y-m-d 00:00:00', strtotime('this week'));
        $thisMonth = date('y-m-01 00:00:00', strtotime('this month'));

        if (date('m') <= 3) {
            $thisFYear = (date('Y')-1);
            $financial_year = (date('Y')-1) . '-' . date('Y');
        } else {
            $thisFYear = date('Y');
            $financial_year = date('Y') . '-' . (date('Y') + 1);
        }
        $tempData["financial_year"] = $financial_year;

        $thisSFinancialYear = $thisFYear.'-04-01 00:00:00'; 

        $thisStartFinancial = date($thisSFinancialYear);
        $thisEndFinancial = date('y-m-d 23:59:59');

        $tempData["thisWeek"] = $thisWeek;
        $tempData["thisMonth"] = $thisMonth;
        $tempData["thisStartFinancial"] = $thisStartFinancial;
        $tempData["thisEndFinancial"] = $thisEndFinancial;
        $startDate = date('y-m-d 00:00:00', strtotime('-6 days'));
        $endDate = date('y-m-d 23:59:59');

        

        $tempData["debit_count_value_today"] = $this->amountSumforDuration($today ,$endDate , "debit");
        $tempData["credit_count_value_today"] = $this->amountSumforDuration($today ,$endDate , "credit");
        

        $tempData["debit_count_value_week"] = $this->amountSumforDuration($thisWeek, $endDate, "debit");
        $tempData["credit_count_value_week"] = $this->amountSumforDuration($thisWeek, $endDate, "credit");
        
        $tempData["debit_count_value_month"] = $this->amountSumforDuration($thisMonth, $endDate, "debit");
        $tempData["credit_count_value_month"] = $this->amountSumforDuration($thisMonth , $endDate, "credit");

        $tempData["debit_count_value_year"] = $this->amountSumforDuration($thisStartFinancial, $thisEndFinancial, "debit");
        $tempData["credit_count_value_year"] = $this->amountSumforDuration($thisStartFinancial , $thisEndFinancial, "credit");
        

        return $tempData;
    }
    public function amountSumforDuration($startDate, $endDate, $payment_type = "credit"){
        //debit
        $this->db->select_sum('amount');
        $this->db->from('Account_Entry');
        $this->db->where('payment_type', $payment_type);
        $this->db->where('delete_flag', "no");
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where("payment_date BETWEEN '$startDate' AND '$endDate'");
        $itemCountQuery = $this->db->get();
        $count_value = $itemCountQuery->row()->amount;
        $count_value = round($count_value);
        return $count_value;
    }

    public function sell_30graph(){
        $today = date('y-m-d 00:00:00');
        $last30day = date('y-m-d 23:59:59', strtotime('-30 days'));
        $status = array('completed', 'paid', 'partial_paid');
        $this->db->select('lock_bill_amount as amount, created_at as date');
        $this->db->where('invoice_type', 'sell');
        $this->db->where_in('status', $status);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where("created_at BETWEEN '$last30day' AND '$today'");
        $query = $this->db->get('Invoices');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function purchase_30graph(){
        $today = date('y-m-d 00:00:00');
        $last30day = date('y-m-d 23:59:59', strtotime('-36 days'));
        $status = array('completed', 'paid', 'partial_paid');
        $this->db->select('lock_bill_amount as amount, created_at as date');
        $this->db->where('invoice_type', 'purchase');
        $this->db->where_in('status', $status);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where("created_at BETWEEN '$last30day' AND '$today'");
        $query = $this->db->get('Invoices');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function cash_30graph(){
        $today = date('y-m-d 00:00:00');
        $last30day = date('y-m-d 23:59:59', strtotime('-30 days'));
        $client_type = array('distributer', 'vendor', 'outlet', 'other');
        $this->db->select('Account_Entry.amount as amount, Account_Entry.payment_date as date');
        $this->db->where_in('Clients.client_type', $client_type);
        $this->db->where('Account_Entry.payment_type', 'credit');
        $this->db->where("Account_Entry.payment_date BETWEEN '$last30day' AND '$today'");
        $this->db->where('Account_Entry.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->from('Account_Entry');
        $this->db->join('Clients', 'Account_Entry.fk_client_code = Clients.code');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
}

?>