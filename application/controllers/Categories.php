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
            $this->data['category'] = $this->category_model->with_users('fields:email')->get($category_id);
            $this->data['projects'] = $this->project_model->where('category_id',$category_id)->get_all();
            $this->render('categories/index_category_view');
        }
    }
    public function add()
    {
        $this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        $this->data['before_body'] .= $this->load->view('templates/_parts/category_add_members_view','',TRUE);
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

                $members = htmlspecialchars($this->input->post('members'),ENT_NOQUOTES);
                $category_members = json_decode($members);
                $verified_members = array();
                foreach($category_members as &$member)
                {
                    if($this->form_validation->valid_email($member) !== FALSE)
                    {
                        $verified_members[] = $member;
                    }
                }

                $this->load->model('user_model');
                $get_members = $this->user_model->where('email',$verified_members)->fields('id')->get_all();
                $insert_members = array();
                foreach($get_members as $member)
                {
                    if($member != $this->user_id)
                    {
                        $insert_members[] = array('user_id'=>$member->id, 'category_id'=>$category_id,'role'=>'edit');
                    }
                }
                $insert_members[] = array('user_id'=>$this->user_id, 'category_id'=>$category_id,'role'=>'admin');
                $this->load->model('category_user_model');
                if($inserted = $this->category_user_model->insert($insert_members))
                {
                    $this->postal->add(sizeof($inserted).' members were attached to the category.', 'success');
                }
                echo '<script>window.close();</script>';
            }
            else
            {
                $this->postal->add('Couldn\'t insert category','error');
            }

        }
    }

    public function admin_users($category_id)
    {
        $this->load->model('category_user_model');
        $role = $this->category_user_model->get_role($category_id,$this->user_id);
        if($role!=='admin')
        {
            $this->postal->add('You are not allowed to administer the members of the category','error');
            redirect('categories/index/'.$category_id);
            die();
        }
        $this->data['role'] = $role;
        $category = $this->category_model->get($category_id);
        $users = $this->category_user_model->where('category_id',$category_id)->with_user('fields:email,id')->get_all();
        $this->data['users'] = $users;
        $this->data['category'] = $category;
        $this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        $this->data['before_body'] .= $this->load->view('templates/_parts/category_add_members_view','',TRUE);
        $this->form_validation->set_rules($this->rules['insert_users']);
        if($this->form_validation->run() === FALSE)
        {
            $this->render('categories/admin_users_view');
        }
        else
        {
            $category_title = htmlspecialchars($this->input->post('title'));
            $members = htmlspecialchars($this->input->post('members'),ENT_NOQUOTES);
            $category_members = json_decode($members);
            $verified_members = array();
            foreach($category_members as &$member)
            {
                if($this->form_validation->valid_email($member) !== FALSE)
                {
                    $verified_members[] = $member;
                }
            }

            $this->load->model('user_model');
            $get_members = $this->user_model->where('email',$verified_members)->fields('id')->get_all();
            $the_members = array();
            foreach($get_members as $member)
            {
                $the_members[] = $member->id;
            }

            if($id = $this->category_model->insert(array('title' => $category_title, 'created_by' => $this->user_id)))
            {
                $this->postal->add('New category added','success');

                $insert_members = array();
                foreach($the_members as $member)
                {
                    $insert_members[] = array('user_id'=>$member,'category_id'=>$id);
                }
                $this->load->model('category_user_model');
                if($inserted = $this->category_user_model->insert($insert_members))
                {
                    $this->postal->add(sizeof($inserted).' members were attached to the category.', 'success');
                }
                echo '<script>window.close();</script>';
            }
            else
            {
                $this->postal->add('Couldn\'t insert category','error');
            }

        }
    }

    public function suggest_members($q = NULL)
    {
        $data = array();
        $this->load->model('user_model');
        if($members = $this->user_model->fields('email')->order_by('email','asc')->set_cache('get_all_users')->get_all())
        {
            foreach ($members as $member)
            {
               $data[] = $member->email;
            }
        }
        $data = json_encode($data);
        echo $data;

    }
}