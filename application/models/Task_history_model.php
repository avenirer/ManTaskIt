<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_history_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'tasks_history';
        $this->primary_key = 'id';
        $this->has_one['task'] = array('Task_model','id','task_id');
        parent::__construct();
    }

    /*public $rules = array(
        'insert' => array(
            'title' => array('field'=>'title','label'=>'Task title','rules'=>'trim|required'),
            'assigned_to' => array('field'=>'assigned_to','label'=>'Assigned to','rules'=>'trim|is_natural_no_zero'),
            'status' => array('field'=>'status','label'=>'Status','rules'=>'trim|is_natural_no_zero'),
            'due_date' => array('field'=>'due_date','label'=>'Due date','rules'=>'trim|datetime|required'),
            'priority' => array('field'=>'priority','label'=>'Priority','rules'=>'trim|is_natural_no_zero'),
            'description' => array('field'=>'description','label'=>'Description','rules'=>'trim'),
            'summary' => array('field'=>'summary','label'=>'Summary','rules'=>'trim'),
            'notes' => array('field'=>'notes','label'=>'Notes','rules'=>'trim'),
            'project_id' => array('field'=>'project_id','label'=>'Project ID','rules'=>'trim|is_natural_no_zero|required')
        ),
        'update' => array(
            'title' => array('field'=>'title','label'=>'Task title','rules'=>'trim|required'),
            'assigned_to' => array('field'=>'assigned_to','label'=>'Assigned to','rules'=>'trim|is_natural_no_zero'),
            'status' => array('field'=>'status','label'=>'Status','rules'=>'trim|is_natural_no_zero'),
            'due_date' => array('field'=>'due_date','label'=>'Due date','rules'=>'trim|datetime|required'),
            'priority' => array('field'=>'priority','label'=>'Priority','rules'=>'trim|is_natural_no_zero'),
            'description' => array('field'=>'description','label'=>'Description','rules'=>'trim'),
            'summary' => array('field'=>'summary','label'=>'Summary','rules'=>'trim'),
            'notes' => array('field'=>'notes','label'=>'Notes','rules'=>'trim'),
            'task_id' => array('field'=>'task_id','label'=>'Task ID','rules'=>'trim|is_natural_no_zero|required')
        ),
    );*/
}