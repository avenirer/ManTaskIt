<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_user_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'categories_users';
        $this->has_one['category'] = array('Category_model','id','category_id');
        $this->has_one['user'] = array('User_model','id','user_id');
        $this->primary_key = 'id';
        $this->timestamps = FALSE;
        parent::__construct();
    }

    public $rules = array(
        'insert' => array(
            'category_id'=> array('field'=>'category_id','label'=>'Category ID','rules'=>'trim|is_natural_no_zero|required')
        )
    );

    public function get_role($category_id,$user_id)
    {
        $this->db->select('role');
        $this->db->where(array('category_id'=>$category_id,'user_id'=>$user_id));
        $query = $this->db->get($this->table)->row();
        if(isset($query->role))
        {
            return $query->role;
        }
        return FALSE;
    }
}