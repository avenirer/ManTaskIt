<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public $rules = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('project_model');
        $this->rules = $this->category_model->rules;
    }

    public function index($category_id = 0)
    {
        $id = intval($category_id);
        if($id==0)
        {
            $this->load->model('user_model');
            $this->data['user'] = $this->user_model->fields('id,email')->with_categories('fields:title')->where('id',$this->user_id)->get();
            $this->render('categories/index_view');
        }
        else
        {
            $this->load->model('category_user_model');
            $role = $this->category_user_model->get_role($category_id,$this->user_id);
            if($role===FALSE)
            {
                redirect();
                die();
            }
            $this->data['role'] = $role;
            $users = $this->category_user_model->fields('role')->where('category_id',$category_id)->with_user('fields:email,id')->get_all();
            $this->data['users'] = $users;
            $this->data['category'] = $this->category_model->with_users('fields:email')->get($category_id);
            $this->data['projects'] = $this->project_model->where('category_id',$category_id)->get_all();
            $this->render('categories/index_category_view');
        }
    }
    public function add()
    {
        //$this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        //$this->data['before_body'] .= $this->load->view('templates/_parts/add_members_view','',TRUE);
        $this->form_validation->set_rules($this->rules['insert']);
        if($this->form_validation->run() === FALSE)
        {
            $this->render('categories/add_view');
        }
        else
        {
            $category_title = htmlspecialchars($this->input->post('title'));
            if($category_id = $this->category_model->insert(array('title' => $category_title, 'created_by' => $this->user_id)))
            {
                $this->postal->add('New category added','success');

                $insert_member = array('user_id'=>$this->user_id, 'category_id'=>$category_id,'role'=>'admin');
                $this->load->model('category_user_model');
                if($this->category_user_model->insert($insert_member)===FALSE)
                {
                    $this->postal->add('Couldn\'t add you as member of category','error');
                    redirect();
                }
                else
                {
                    $this->postal->add('You were added as admin of the category','success');
                    redirect('members/index/category/'.$category_id);
                }
            }
            else
            {
                $this->postal->add('Couldn\'t insert category','error');
            }

        }
    }
}