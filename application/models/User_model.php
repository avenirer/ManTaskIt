<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'users';
        $this->has_many_pivot['projects'] = array('Project_model','category_id','id');
        $this->has_many_pivot['categories'] = 'Category_model';
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'category'=> array('field'=>'category','label'=>'Category','rules'=>'trim|required|is_unique[categories.title]')
        )
    );
}