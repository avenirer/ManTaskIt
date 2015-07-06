<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'categories';
        $this->primary_key = 'id';
        parent::__construct();
    }
}