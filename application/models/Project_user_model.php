<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_user_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'projects_users';
        $this->has_one['project'] = array('Project_model','id','project_id');
        $this->has_one['user'] = array('User_model','id','user_id');
        $this->timestamps = FALSE;
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            //'project_id'=> array('field'=>'project_id','label'=>'Project ID','rules'=>'trim|is_natural_no_zero|required')
        )
    );

    public function get_role($project_id,$user_id)
    {
        $this->db->select('role');
        $this->db->where(array('project_id'=>$project_id,'user_id'=>$user_id));
        $query = $this->db->get($this->table)->row();
        if(isset($query->role))
        {
            return $query->role;
        }
        return FALSE;
    }
}