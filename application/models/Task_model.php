<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'tasks';
        $this->has_one['project'] = array('Project_model','id','project_id');
        $this->has_one['status'] = array('Task_status_model','id','status');
        $this->has_one['priority'] = array('Task_priority_model','id','priority');
        $this->has_one['creator'] = array('User_model','id','created_by');
        $this->has_one['assignee'] = array('User_model','id','assigned_to');
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
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
    );

    public function get_task($task_id)
    {
        if(!is_numeric( (int)$task_id))
        {
            return FALSE;
        }
        $this->db->select('tasks.id,tasks.project_id,tasks.title,tasks.summary,tasks.description,tasks.notes,tasks.status as status_id,tasks.priority,tasks.progress,tasks.due_date');
        $this->db->select('tasks_statuses.title as status_title');
        $this->db->select('tasks_priorities.color as priority_color');
        $this->db->select('tasks_priorities.title as priority_title');
        $this->db->select('tasks_priorities.order as priority_order');
        $this->db->select('tasks.created_by as creator_id');
        $this->db->select('tasks.assigned_to as assignee_id');
        $this->db->select('creator_table.email as creator_email');
        $this->db->select('assignee_table.email as assignee_email');
        $this->db->where('tasks.id',$task_id);
        $this->db->join('tasks_statuses','tasks.status = tasks_statuses.id','left');
        $this->db->join('tasks_priorities','tasks.priority = tasks_priorities.id','left');
        $this->db->join('users creator_table','tasks.created_by = creator_table.id');
        $this->db->join('users assignee_table','tasks.assigned_to = assignee_table.id');
        $query = $this->db->get('tasks');
        return $query->row();
    }
}