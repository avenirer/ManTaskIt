<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'categories';
        $this->has_many['projects'] = array('Project_model','category_id','id');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'category'=> array('field'=>'category','label'=>'Category','rules'=>'trim|required|is_unique[categories.title]')
        )
    );
}