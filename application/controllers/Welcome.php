<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('task_model');
    }

    public function index()
    {
        $rules = $this->category_model->rules;
        $this->form_validation->set_rules($rules['insert']);
        $this->data['categories'] = $this->task_model->count_tasks_with_categories();
        $this->data['active_tasks'] = $this->task_model->get_summary_tasks($this->user_id, 10);
        if($this->form_validation->run())
        {
            $category_title = htmlspecialchars($this->input->post('category'));
            if($id = $this->category_model->insert(array('title'=>$category_title,'created_by'=>$this->user_id)))
            {
                redirect();
            }
        }
        $this->render('dashboard_view');

    }
}