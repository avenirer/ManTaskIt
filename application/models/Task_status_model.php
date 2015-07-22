<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_status_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'tasks_statuses';
        $this->has_many['tasks'] = array('Task_model','status','id');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public function init()
    {
        $insert_data = array(
            array('title'=>'Assigned','order'=>1),
            array('title'=>'Viewed','order'=>2),
            array('title'=>'In progress','order'=>3),
            array('title'=>'Reviewed','order'=>4),
            array('title'=>'Completed','order'=>5),
            array('title'=>'Incomplete','order'=>6),
            array('title'=>'Failed','order'=>7),
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