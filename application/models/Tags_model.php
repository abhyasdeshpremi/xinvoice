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

    public function assigned_tag_detail($tagcode = '', $tagType = array('product')){
        $this->db->select('tags_assigned.tags_assign_id, tags_assigned.fk_tag_code, Tags.tag_name, Tags.tag_color, tags_assigned.assign_tag_to_code, Items.name as itemname');
        if($tagcode != ''){
            $this->db->where('tags_assigned.fk_tag_code', strtoupper($tagcode));
        }
        $this->db->where('tags_assigned.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where_in('tags_assigned.assign_tag_type', $tagType);
        $this->db->from('tags_assigned');
        $this->db->join('Tags', 'Tags.tag_code = tags_assigned.fk_tag_code');
        $this->db->join('Items', 'Items.item_code = tags_assigned.assign_tag_to_code');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function assign_tag($tag){
        $result = array();
        $this->db->where('fk_tag_code', $tag['globaltagcode']);
        $this->db->where('assign_tag_to_code', $tag['itemcode']);
        $this->db->where('assign_tag_type', $tag['tag_type']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('tags_assigned');
        if($query->num_rows() == 0){
            $data = array(
                'fk_tag_code'=>$tag['globaltagcode'],
                'assign_tag_to_code'=>$tag['itemcode'],
                'assign_tag_type'=>$tag['tag_type'],
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=> $this->session->userdata('username')
            );
            $this->db->insert('tags_assigned',$data);
            $result['code'] = ($this->db->affected_rows() != 1) ? false : true;
            $result['tags_assign_id']  = $this->db->insert_id();
        }else{
            $result['code']  = false;
            $result['tags_assign_id']  = 0;
        }
        return $result;
    }

    public function delete_assigntag($tag){
        $result = array();
        $this->db->where('tags_assign_id', $tag);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('tags_assigned');
        if($query->num_rows() == 1){
            $this->db->where('tags_assign_id', $tag);
            $this->db->delete('tags_assigned');
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
        }else{
            $result['code']  = false;
        }
        return $result;
    }
}

?>