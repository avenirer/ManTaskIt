<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_priority_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'tasks_priorities';
        $this->has_many['tasks'] = array('Task_model','priority','id');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public function init()
    {
        $insert_data = array(
            array('title'=>'Critical','order'=>1,'color'=>'#ff0000'),
            array('title'=>'Urgent','order'=>2,'color'=>'#ff6600'),
            array('title'=>'Important','order'=>3,'color'=>'#ffff66'),
            array('title'=>'Not urgent','order'=>4,'color'=>'#ffffe0')
        );
        $this->insert($insert_data);
    }

    /*
    public $rules = array(
        'insert' => array(
            'title'=> array('field'=>'title','label'=>'Task title','rules'=>'trim|required'),

            'project_id' => array('field'=>'project_id','label'=>'Project ID','rules'=>'trim|is_natural_no_zero|required')
        ),
        'insert_users' => array(
            'project_id' => array('field'=>'project_id','label'=>'Project ID','rules'=>'trim|required|is_natural_no_zero'),
            //'email' => array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email')
        )
    );
    */
}