<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'projects';
        $this->has_one['category'] = array('Category_model','id','category_id');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'title'=> array('field'=>'title','label'=>'Project name','rules'=>'trim|required|is_unique[projects.title]')
        )
    );
}