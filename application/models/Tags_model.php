<?php

class Tags_model extends CI_Model {
    protected $table = 'Tags';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count() {
        $this->db->select('pk_tag_id');
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function unique_tag_code_verify($unique_code){
        $this->db->where('tag_code', strtoupper($unique_code));
        $query = $this->db->get('Tags');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_tag_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('tag_code', strtoupper($unique_code));
        $query = $this->db->get('Tags');
        if($query->num_rows() === 1){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_tag($data){
        $data = array(
            'tag_code'=>strtoupper($data['uniqueCode']),
            'tag_name'=>$data['tagName'],
            'tag_color'=>$data['tagColor'],
            'description'=>$data['description'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Tags',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function tag_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("tag_name", "ASC");
        $query = $this->db->get('Tags');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_tag_detail($tagcode){
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('tag_code', $tagcode);
        $query = $this->db->get('Tags');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_tag($data){
        $itemdata = array(
            'tag_name'=>$data['tagName'],
            'tag_color'=>$data['tagColor'],
            'description'=>$data['description'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('tag_code', strtoupper($data['uniqueCode']));
        $this->db->update('Tags',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete_tag($tag){
        $result = array();
        $this->db->where('tag_code', $tag['tagCode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Tags');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'yes'
            );
            $this->db->where('tag_code', $tag['tagCode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Tags', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['tagCode']  = $tag['tagCode'];
        }else{
            $result['code']  = false;
            $result['tagCode']  = $tag['tagCode'];
        }
        return $result;
    }
}

?>