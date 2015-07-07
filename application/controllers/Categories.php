<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public $rules = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->rules = $this->category_model->rules;
    }

    public function index($id = 0)
    {
        $id = intval($id);
        if($id==0)
        {
            $this->data['categories'] = $this->category_model->get_all();
            $this->render('categories/index_view');
        }
        else
        {
            $data['category'] = $this->category_model->with_projects()->get($id);
            $this->render('categories/index_category_view');
        }
    }
    public function add()
    {
        $this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        $this->form_validation->set_rules($this->rules['insert']);
        if($this->form_validation->run() === FALSE)
        {
            $this->render('categories/add_view');
        }
        else
        {
            $category_title = htmlspecialchars($this->input->post('category'));
            if($id = $this->category_model->insert(array('title' => $category_title, 'created_by' => $this->user_id)))
            {
                $this->postal->add('New category added','success');
                echo '<script>window.close();</script>';
            }
            else
            {
                $this->postal->add('Couldn\'t insert category','error');
            }

        }
    }
}