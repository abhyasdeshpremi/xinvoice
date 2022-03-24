<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $this->load->model('Company_model', '', TRUE);
        $this->load->model('Invoice_model', '', TRUE);
        $this->load->model('Tags_model', '', TRUE);
        $this->load->library("pagination");
    }

    public function createTag(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['tagName'] = $this->input->post('tagName');
            $data['tagColor'] = $this->input->post('tagColor');
            $data['description'] = $this->input->post('description');
            $uniqueCodeVerify = $this->Tags_model->unique_tag_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createCompany = $this->Tags_model->create_tag($data);
                if($createCompany ){
                    unset($data);
                    $data['successMessage'] = "Successfully Tag Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save tag information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('buttonName', 'Tag List');
        $this->template->set('buttonLink', base_url('/tagdetails'));
        $this->template->set('title', 'Create Tag');
        $this->template->load('default_layout', 'contents' , 'tags/createtag', $data);
    }

    public function tagdetails(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("tagdetails");
        $config["total_rows"] = $this->Tags_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Tags_model->tag_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'New Tag');
        $this->template->set('buttonLink', base_url('/createtag'));
        $this->template->set('title', 'Tag List');
        $this->template->load('default_layout', 'contents' , 'tags/tagdetail', $data);
    }

    public function updateTag($tagCode = null){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['tagName'] = $this->input->post('tagName');
            $data['tagColor'] = $this->input->post('tagColor');
            $data['description'] = $this->input->post('description');
            $uniqueCodeCheck = $this->Tags_model->unique_tag_code_check($this->input->post('uniqueCode'));
            if($uniqueCodeCheck){
                $updateCompany = $this->Tags_model->update_tag($data);
                if($updateCompany ){
                    $data['successMessage'] = "Successfully Tag Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
         }

        $tag_result = $this->Tags_model->update_tag_detail($tagCode);
        $data['data'] = $tag_result['result'];
        $this->template->set('buttonName', 'Tag List');
        $this->template->set('buttonLink', base_url('/tagdetails'));
        $this->template->set('title', 'Update Tag');
        $this->template->load('default_layout', 'contents' , 'tags/updatetag', $data);
    }

    public function deleteTag(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['tagCode'] = $this->input->post('tagCode');
            $tag_delete_result = $this->Tags_model->delete_tag($data);
            if($tag_delete_result['code']){
                $data['code'] = $tag_delete_result['code'];
                $data['tagCode'] = $tag_delete_result['tagCode'];
                $data["message"] = "Successfully company deleted!";
            }else{
                $data['code'] = $tag_delete_result['code'];
                $data['tagCode'] = $tag_delete_result['tagCode'];
                $data["message"] = "Unable to delete this company. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['tagCode'] = $this->input->post('tagCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

    // Tag was assigned product
    public function assigntoTag($tagCode = null){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
        }
        $tag_result = $this->Tags_model->update_tag_detail($tagCode);
        $data['data'] = $tag_result['result'];
        foreach($tag_result['result'] as $value){ 
            $data['uniqueCode'] = $value->tag_code;
            $data['tagName'] =  $value->tag_name;
            $data['tagColor'] =  $value->tag_color;
            $data['description'] = $value->description; 
        }

        $assigneditemsList = $this->Tags_model->assigned_tag_detail($tagCode, array('product'));
        $data['assigneditemsList'] = $assigneditemsList["result"];
        $data['itemsList'] = $this->Invoice_model->items_list();
        $this->template->set('buttonName', 'Tag List');
        $this->template->set('buttonLink', base_url('/tagdetails'));
        $this->template->set('title', 'Assign Tag'.$tagCode);
        $this->template->load('default_layout', 'contents' , 'tags/assigntotag', $data);
    }

    public function assignTagtoProduct(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemcode'] = $this->input->post('itemcode');
            $data['globaltagcode'] = $this->input->post('globaltagcode');
            $data['tag_type'] = 'product';
            $tag_assign_result = $this->Tags_model->assign_tag($data);
            if($tag_assign_result['code']){
                $data['code'] = $tag_assign_result['code'];
                $data['tags_assign_id'] = $tag_assign_result['tags_assign_id'];
                $data["message"] = "Successfully assigned!";
                $data["previewData"] = array(
                    "tags_assign_id" => $tag_assign_result['tags_assign_id'], 
                    "assign_tag_to_code" => $data['itemcode'],
                    "itemname" => $this->input->post('item_name'), 
                    "tag_color" => $this->input->post('tagColor'),
                    "fk_tag_code" => $data['globaltagcode'], 
                    "tag_name" => $this->input->post('tagName')
                    );
            }else{
                $data['code'] = $tag_assign_result['code'];
                $data['tags_assign_id'] = $tag_assign_result['tags_assign_id'];
                $data["message"] = "Unable to assign this product. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['tags_assign_id'] = 0;
            $data["message"] = "Unable to serve assign Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function deleteassignitem(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['assigneditemid'] = $this->input->post('assigneditemid');
            $tag_delete_result = $this->Tags_model->delete_assigntag($data['assigneditemid']);
            if($tag_delete_result['code']){
                $data['code'] = $tag_delete_result['code'];
                $data["message"] = "Successfully assigned item deleted!";
            }else{
                $data['code'] = $tag_delete_result['code'];
                $data["message"] = "Unable to delete assigned item. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }


}