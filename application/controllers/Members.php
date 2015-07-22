<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('project_model');
        $this->load->model('user_model');
        $this->types = array('category','project');
        $this->roles = array('admin','edit','view','removed');
    }

    public function index($type,$type_id)
    {

        $type = ($this->form_validation->run()===FALSE) ? $type : $this->input->post('type');
        if(($this->form_validation->alpha($type) === FALSE) || !in_array($type,$this->types))
        {
            $this->postal->add('What is this???','error');
            redirect();
            exit();
        }
        $type_id = ($this->form_validation->run() === FALSE) ? $type_id : $this->input->post($type.'_id');

        $model = $type.'_user_model';
        $this->load->model($model, 'relation_model');
        $type_content = $this->{$type.'_model'}->get($type_id);
        if($type==='project')
        {
            $this->load->model('category_user_model');
            $role = $this->category_user_model->get_role($type_content->category_id,$this->user_id);
            if(!in_array($role,array('admin','edit')))
            {
                $role = $this->project_user_model->get_role($type_content->id, $this->user_id);
                if($role!=='admin')
                {
                    $this->postal->add('You are not allowed to add members to the '.$type.' "'.$type_content->title.'"');
                    redirect();
                    exit;
                }
            }
        }
        else
        {
            $role = $this->relation_model->get_role($type_id, $this->user_id);
        }
        if($role!=='admin')
        {
            $this->postal->add('You are not allowed to administer the members of the '.$type,'error');
            redirect();
            exit();
        }

        $this->data['role'] = $role;
        $users = $this->relation_model->where($type.'_id',$type_id)->with_user('fields:email,id')->get_all();
        $the_users = array();
        if(!empty($users))
        {
            foreach($users as $user)
            {
                $the_users[] = $user->user_id;
            }
        }
        if($type==='category')
        {
            $available_users = $this->user_model->where('id',$the_users,NULL,TRUE,TRUE)->get_all();
        }
        elseif($type==='project')
        {
            $available_users = array();
            $category_users = $this->category_model->as_array()->where('id',$type_content->category_id)->with_users('fields:email,id')->get();
            $available_users = $category_users['users'];

            foreach($available_users as $user_id => $user)
            {
                if(in_array($user_id,$the_users))
                {
                    unset($available_users[$user_id]);
                }
            }
        }

        $this->data['available_users'] = $available_users;
        $this->data['type'] = $type;
        $this->data['users'] = $users;
        $this->data['type_content'] = $type_content;
        //$this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        //$this->data['before_body'] .= $this->load->view('templates/_parts/add_members_view','',TRUE);
        $rules = $this->{$type.'_model'}->rules;
        $this->form_validation->set_rules($rules['insert_users']);
        if($this->form_validation->run() === FALSE)
        {
            $this->render('members/admin_members_view');
        }
        else
        {
            echo 'bau';
            /*
            $title = htmlspecialchars($this->input->post('title'));
            $members = htmlspecialchars($this->input->post('members'),ENT_NOQUOTES);
            $type_members = json_decode($members);
            $verified_members = array();
            foreach($type_members as &$member)
            {
                if($this->form_validation->valid_email($member) !== FALSE)
                {
                    $verified_members[] = $member;
                }
            }

            $this->load->model('user_model');
            $get_members = $this->user_model->where('email',$verified_members)->fields('id')->get_all();
            $the_members = array();
            foreach($get_members as $member)
            {
                $the_members[] = $member->id;
            }

            $insert_members = array();
                foreach($the_members as $member)
                {
                    $insert_members[] = array('user_id'=>$member,'category_id'=>$id);
                }
                $this->load->model('category_user_model');
                if($inserted = $this->category_user_model->insert($insert_members))
                {
                    $this->postal->add(sizeof($inserted).' members were attached to the category.', 'success');
                }
                echo '<script>window.close();</script>';
            }
            else
            {
                $this->postal->add('Couldn\'t insert category','error');
            }*/

        }
    }

    public function add($type, $type_id, $user_id)
    {
        if(!in_array($type,$this->types) || $this->form_validation->integer($type_id) === FALSE || $this->form_validation->integer($user_id) === FALSE || $this->user_model->get($user_id)===FALSE)
        {
            $this->postal->add('Don\'t know how you got there...','error');
            redirect();
            die();
        }
        $this->load->model($type.'_user_model','relation_model');
        $role = $this->relation_model->get_role($type_id,$this->user_id);

        if(!in_array($role, array('admin','edit')))
        {
            $this->postal->add('Don\'t know how you got there...','error');
            redirect();
            die();
        }
        if($this->relation_model->where(array($type.'_id'=>$type_id, 'user_id'=>$user_id))->get()!==FALSE)
        {
            $this->postal->add('The user is already part of that '.$type,'error');
            redirect(plural($type).'/index/'.$type_id);
            exit;
        }
        elseif($this->relation_model->insert(array($type.'_id'=>$type_id,'user_id'=>$user_id,'role'=>'edit'))!== FALSE)
        {
            $this->postal->add('The user was added to the '.$type,'success');
            redirect(plural($type).'/index/'.$type_id);
            exit;
        }
        else
        {
            $this->postal->add('An error was encountered','error');
            redirect(plural($type).'/index/'.$type_id);
            exit;
        }
    }

    public function change_role($type,$type_id,$user_id,$user_role)
    {
        if(!in_array($type,$this->types) || !in_array($user_role,$this->roles) || $this->form_validation->integer($type_id) === FALSE || $this->form_validation->integer($user_id) === FALSE)
        {
            $this->postal->add('Don\'t know how you got there...','error');
            redirect();
            die();
        }
        if($this->user_id===$user_id)
        {
            $this->postal->add('You are not allowed to change your own role...','error');
            redirect('members/index/'.$type.'/'.$type_id);
            die();
        }
        $this->load->model($type.'_user_model','relation_model');
        $role = $this->relation_model->get_role($type_id,$this->user_id);
        if($role!=='admin')
        {
            $this->postal->add('You are not allowed to change roles on that category','error');
            redirect(plural($type).'/index/'.$type_id);
            die();
        }
        $updated = $this->relation_model->where(array($type.'_id'=>$type_id,'user_id'=>$user_id))->update(array('role'=>$user_role));
        if($updated===FALSE)
        {
            $this->postal->add('Couldn\'t update member','error');
        }
        else
        {
            $this->postal->add('Member role updated','success');
        }
        redirect('members/index/'.$type.'/'.$type_id);

    }

    public function suggest_members($q = NULL)
    {
        $data = array();
        $this->load->model('user_model');
        if($members = $this->user_model->fields('email')->order_by('email','asc')->set_cache('get_all_users')->get_all())
        {
            foreach ($members as $member)
            {
               $data[] = $member->email;
            }
        }
        $data = json_encode($data);
        echo $data;

    }
}