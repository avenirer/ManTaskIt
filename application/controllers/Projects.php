<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller
{
    public $rules = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('category_user_model');
        $this->load->model('project_model');
        $this->rules = $this->project_model->rules;
    }

    public function index($project_id = 0)
    {
        $project_id = intval($project_id);
        if($project_id==0)
        {
            $this->load->model('user_model');
            $this->data['user'] = $this->user_model->fields('id,email')->with_projects('fields:title')->where('id',$this->user_id)->get();
            $this->render('projects/index_view');
        }
        else
        {
            $project = $this->project_model->get($project_id);

            if($project===FALSE)
            {
                $this->postal->add('Project doesn\'t exist.','error');
                redirect();
                die();
            }

            $this->load->model('project_user_model');
            $project_role = $this->project_user_model->get_role($project_id,$this->user_id);
            $category_role = $this->category_user_model->get_role($project->category_id,$this->user_id);
            if($project_role===FALSE && $category_role===FALSE)
            {

                $this->postal->add('You don\'t have the right to access the project page','error');
                redirect();
                exit();
            }

            // Get the tasks
            $this->load->model('task_model');
            $tasks = $this->task_model->where('project_id',$project->id)->order_by('priority','asc')->with_status('fields:id,title')->with_priority('fields:id,title,color')->get_all();

            $this->data['tasks'] = $tasks;

            $members = $this->project_user_model->with_user('fields:id,email')->where('project_id',$project->id)->get_all();
            $this->data['members'] = $members;
            $this->load->model('category_user_model');
            $category_members = $this->category_user_model->where('category_id',$project->category_id)->with_user('fields:email,id')->get_all();
            $this->data['category_members'] = $category_members;
            $this->data['project'] = $project;
            $this->data['project_role'] = $project_role;
            $this->data['category_role'] = $category_role;

            $this->render('projects/index_project_view');
        }
    }

    public function add($category_id)
    {
        $category_id = ($this->form_validation->run() === TRUE) ? $this->input->post('category_id') : intval($category_id);

        $category = $this->category_model->get($category_id);

        if($category===FALSE)
        {
            $this->postal->add('Category doesn\'t exist.','error');
            redirect();
            die();
        }

        $role = $this->category_user_model->fields('role')->where(array('category_id'=>$category_id, 'user_id'=>$this->user_id))->get();

        if($role===FALSE || !in_array($role->role,array('admin','edit')))
        {
            $this->postal->add('You are not allowed to create a project in this category','error');
            redirect('categories/index/'.$category_id);
            exit();
        }
        //$this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        //$this->data['before_body'] .= $this->load->view('templates/_parts/add_members_view','',TRUE);

        $this->form_validation->set_rules($this->rules['insert']);

        if($this->form_validation->run() === FALSE)
        {
            $this->data['category'] = $category;
            $this->render('projects/add_view');
        }
        else
        {
            $project_title = htmlspecialchars($this->input->post('title'));

            if($project_id = $this->project_model->insert(array('title' => $project_title, 'category_id'=>$category->id, 'created_by' => $this->user_id)))
            {
                $this->postal->add('New project added','success');

                $insert_member = array('user_id'=>$this->user_id, 'project_id'=>$project_id,'role'=>'admin');
                $this->load->model('project_user_model');
                if($this->project_user_model->insert($insert_member)===FALSE)
                {
                    $this->postal->add('Couldn\'t add you as member of the project','error');
                    redirect();
                }
                $this->postal->add('You were added as admin of the project','success');
                redirect('members/index/project/'.$project_id);
            }
            else
            {
                $this->postal->add('Couldn\'t create a project','error');
            }

        }
    }
}