<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'projects';
        $this->has_one['category'] = array('Category_model','id','category_id');
        $this->has_many_pivot['members'] = array('User_model','id','id');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'title'=> array('field'=>'title','label'=>'Project name','rules'=>'trim|required|is_unique[projects.title]'),
            'category_id' => array('field'=>'category_id','label'=>'Category ID','rules'=>'trim|is_natural_no_zero|required')
        ),
        'insert_users' => array(
            'project_id' => array('field'=>'project_id','label'=>'Project ID','rules'=>'trim|required|is_natural_no_zero'),
            //'email' => array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email')
        )
    );
}