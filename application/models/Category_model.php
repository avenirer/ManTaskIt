<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'categories';
        $this->has_many['projects'] = 'Project_model';
        $this->has_many_pivot['users'] = 'User_model';
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'title'=> array('field'=>'title','label'=>'Category','rules'=>'trim|required|is_unique[categories.title]')
        ),
        'insert_users' => array(
            'category_id' => array('field'=>'category_id','label'=>'Category ID','rules'=>'trim|required|is_natural_no_zero'),
            'email' => array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email')
        )
    );
}