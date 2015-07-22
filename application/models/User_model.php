<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'users';
        $this->has_many_pivot['projects'] = array('Project_model','id','id');
        $this->has_many_pivot['categories'] = 'Category_model';
        $this->primary_key = 'id';
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'category'=> array('field'=>'category','label'=>'Category','rules'=>'trim|required|is_unique[categories.title]')
        )
    );

    public function get_members($type,$type_id)
    {
        $this->db->select('email');
        $this->db->join(plural($type).'_users', 'users.id = '.plural($type).'_users.user_id','left');
        $this->db->where(plural($type).'_users.'.$type.'_id',$type_id);
        $result = $this->db->get($this->table)->result();
        $members = array();
        foreach($result as $row)
        {
            $members[] = $row->email;
        }
        return $members;
    }
}