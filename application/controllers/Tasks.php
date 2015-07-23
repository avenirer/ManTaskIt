<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller
{
    public $rules = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('task_model');
        $this->rules = $this->task_model->rules;
    }

    public function index($task_id = NULL)
    {
        if(!isset($task_id))
        {
            #TODO
            echo 'here should be displayed all user tasks';
        }
        $task_id = intval($task_id);
        if($task_id==0)
        {
            $this->postal->add('Couldn\'t find the task','error');
            redirect();
        }
        else
        {
            // get the task
            /*$task = $this->task_model
                ->with_status('fields:id,title')
                ->with_creator('fields:email,id')
                ->with_assignee('fields:email,id')
                ->with_priority('fields:id,color,order')
                ->get($task_id);*/

            $task = $this->task_model->get_task($task_id);

            if($task===FALSE)
            {
                $this->postal->add('Couldn\'t find the task','error');
                redirect();
            }

            // get the project
            $project_id = $task->project_id;
            $project = $this->project_model->get($project_id);

            if($project===FALSE)
            {
                $this->postal->add('Project doesn\'t exist.','error');
                redirect();
            }

            // find the user's role in the project
            $this->load->model('project_user_model');
            $project_role = $this->project_user_model->get_role($project->id,$this->user_id);

            // find the user's role in the category of the project
            $this->load->model('category_user_model');
            $category_role = $this->category_user_model->get_role($project->category_id,$this->user_id);

            if($project_role===FALSE && $category_role===FALSE)
            {

                $this->postal->add('You don\'t have the right to access the project page','error');
                redirect();
            }

            // find out the members of the project
            $project_members = $this->project_user_model->with_user('fields:id,email')->where('project_id', $project->id)->get_all();
            $this->data['project_members'] = $project_members;

            // find out the members of the category
            $category_members = $this->category_user_model->where('category_id',$project->category_id)->with_user('fields:email,id')->get_all();
            $this->data['category_members'] = $category_members;

            $this->data['project_role'] = $project_role;
            $this->data['category_role'] = $category_role;
            $this->data['project'] = $project;
            $this->data['task'] = $task;
            $this->render('tasks/index_task_view');
        }
    }

    public function add($project_id)
    {
        // First make sure we have validation rules
        $this->form_validation->set_rules($this->rules['insert']);

        // Get project ID
        $project_id = ($this->form_validation->run() === TRUE) ? $this->input->post('project_id') : intval($project_id);

        // Look for the project
        $project = $this->project_model->with_members('fields:email,id')->get($project_id);
        if ($project === FALSE) {
            $this->postal->add('There is no project with that ID', 'error');
            redirect();
        }
        $this->data['project'] = $project;

        // Find out the role of the user
        $this->load->model('project_user_model');
        $role = $this->project_user_model->get_role($project->id, $this->user_id);
        if (!in_array($role, array('admin', 'edit'))) {
            $this->postal->add('You are not allowed to add tasks to the project', 'error');
            redirect('projects/index/' . $project->id);
        }
        $this->data['role'] = $role;

        // Get the available statuses
        $this->load->model('task_status_model');
        $statuses = $this->task_status_model->as_dropdown('title')->order_by('order', 'ASC')->get_all();
        $this->data['statuses'] = $statuses;

        // Get the priorities
        $this->load->model('task_priority_model');
        $priorities = $this->task_priority_model->as_dropdown('title')->order_by('order', 'DESC')->get_all();
        $this->data['priorities'] = $priorities;

        // Get the members
        $members = array();
        if ($role === 'admin' && !empty($project->members)) {
            foreach ($project->members as $member) {
                $members[$member->id] = $member->email;
            }
        }
        $this->data['members'] = $members;

        if ($this->form_validation->run() === FALSE) {
            $this->render('tasks/add_view');
        } else {
            $title = $this->input->post('title');
            $assigned_to = ($role === 'admin') ? $this->input->post('assigned_to') : $this->user_id;
            $status = $this->input->post('status');
            $priority = $this->input->post('priority');
            $due_date = $this->input->post('due_date');
            $description = $this->input->post('description');
            $summary = $this->input->post('summary');
            $notes = $this->input->post('notes');


            $verify_assigned_to = $this->project_user_model->get_role($project_id, $assigned_to);

            if (!in_array($verify_assigned_to, array('admin', 'edit'))) {
                $this->postal->add('You are not allowed to add the task to that user. You must first add him/her to the project as admin or edit');
                redirect('projects/index/' . $project->id);
                exit;
            }

            $insert_data = array(
                'project_id' => $project_id,
                'title' => $title,
                'assigned_to' => $assigned_to,
                'status' => $status,
                'priority' => $priority,
                'due_date' => $due_date,
                'description' => $description,
                'summary' => $summary,
                'notes' => $notes,
                'created_by' => $this->user_id
            );

            if ($this->task_model->insert($insert_data)) {
                $this->postal->add('The task was created successfully', 'success');
            } else {
                $this->postal->add('Couldn\'t create the task', 'error');
            }
            redirect('projects/index/' . $project->id);

        }
    }

    public function edit($task_id)
    {
        // First make sure we have validation rules
        $this->form_validation->set_rules($this->rules['update']);

        // Get task ID
        $task_id = ($this->form_validation->run() === TRUE) ? $this->input->post('task_id') : intval($task_id);

        // Look for the task
        $task = $this->task_model->get_task($task_id);

        if ($task === FALSE) {
            $this->postal->add('There is no task with that ID', 'error');
            redirect();
        }

        $this->data['task'] = $task;

        // Find out the role of the user
        $this->load->model('project_user_model');
        $role = $this->project_user_model->get_role($task->project_id, $this->user_id);
        if (!in_array($role, array('admin', 'edit'))) {
            $this->postal->add('You are not allowed to change the tasks in this project', 'error');
            redirect('projects/index/' . $task->project_id);
        }
        $this->data['role'] = $role;

        // Get the available statuses
        $this->load->model('task_status_model');
        $statuses = $this->task_status_model->as_dropdown('title')->order_by('order', 'ASC')->get_all();

        $admin_statuses = array('1','3','4','5','6','7');
        $edit_statuses = array('3','4');
        $the_statuses = array();

        foreach($statuses as $id => $the_status)
        {
            if(in_array($id,$admin_statuses)) $the_statuses['admin'][$id] = $the_status;
            if(in_array($id,$edit_statuses)) $the_statuses['edit'][$id] = $the_status;
        }
        $this->data['statuses'] = $the_statuses;

        // Get the priorities
        $this->load->model('task_priority_model');
        $priorities = $this->task_priority_model->as_dropdown('title')->order_by('order', 'DESC')->get_all();
        $this->data['priorities'] = $priorities;

        // Get the project
        $project = $this->project_model->with_members('fields:email,id')->get($task->project_id);

        // Get the members of the project if the $role is admin (only admin has the right to assign to other people)
        $members = array();
        if (!empty($project->members)) {
            foreach ($project->members as $member) {
                $members[$member->id] = $member->email;
            }
        }
        $this->data['members'] = $members;

        if ($this->form_validation->run() === FALSE)
        {
            $this->render('tasks/edit_view');
        }
        else
        {
            echo $role;

            $old_task = $task;


            $update_data = array();
            $history_data = array();
            if($role == 'admin')
            {
                if(strcmp($old_task->title,$this->input->post('title'))!=0)
                {
                    $update_data['title'] = $this->input->post('title');
                    $history_data['title'] = $old_task->title;
                }


                if(strcmp($old_task->summary,$this->input->post('summary'))!=0)
                {
                    $update_data['summary'] = $this->input->post('summary');
                    $history_data['summary'] = $old_task->summary;
                }

                if($old_task->assignee_id!=$this->input->post('assigned_to'))
                {
                    $update_data['assigned_to'] = $this->input->post('assigned_to');
                    $history_data['assigned_to'] = $old_task->assignee_id;
                }

                if(strcmp($old_task->description,$this->input->post('description'))!=0)
                {
                    $update_data['description'] = $this->input->post('description');
                    $history_data['description'] = $old_task->description;
                }

                if($old_task->priority!=$this->input->post('priority'))
                {
                    $update_data['priority'] = $this->input->post('priority');
                    $history_data['priority'] = $old_task->priority;
                }

                if(strcmp($old_task->due_date,$this->input->post('due_date'))!=0)
                {
                    $update_data['due_date'] = $this->input->post('due_date');
                    $history_data['due_date'] = $old_task->due_date;
                }
            }

            if(in_array($role,array('admin','edit')))
            {
                if(strcmp($old_task->notes,$this->input->post('notes'))!=0)
                {
                    $update_data['notes'] = $this->input->post('notes');
                    $history_data['notes'] = $old_task->notes;
                }

                $status = $this->input->post('status');
                if(($old_task->status_id!=$status) && array_key_exists($status, $the_statuses[$role]))
                {
                    $update_data['status'] = $status;
                    $history_data['status'] = $old_task->status_id;
                }

                if($old_task->progress!=$this->input->post('progress'))
                {
                    $update_data['progress'] = $this->input->post('progress');
                    $history_data['progress'] = $old_task->progress;
                }
            }

            if(!empty($update_data))
            {
                $update_data['updated_by'] = $this->user_id;
                $update_data['updated_at'] = date('Y-m-d H:i:s');

                $history_data['task_id'] = $old_task->id;
                $history_data['created_by'] = $this->user_id;
                $history_data['created_at'] = date('Y-m-d H:i:s');
            }
            echo '<pre>';
            print_r($update_data);
            print_r($history_data);
            echo '</pre>';
            dd($old_task);
            /*
            $title = $this->input->post('title');
            $assigned_to = ($role === 'admin') ? $this->input->post('assigned_to') : $this->user_id;
            $status = $this->input->post('status');
            $priority = $this->input->post('priority');
            $due_date = $this->input->post('due_date');
            $description = $this->input->post('description');
            $summary = $this->input->post('summary');
            $notes = $this->input->post('notes');


            $verify_assigned_to = $this->project_user_model->get_role($project_id, $assigned_to);

            if (!in_array($verify_assigned_to, array('admin', 'edit'))) {
                $this->postal->add('You are not allowed to add the task to that user. You must first add him/her to the project as admin or edit');
                redirect('projects/index/' . $project->id);
                exit;
            }

            $insert_data = array(
                'project_id' => $project_id,
                'title' => $title,
                'assigned_to' => $assigned_to,
                'status' => $status,
                'priority' => $priority,
                'due_date' => $due_date,
                'description' => $description,
                'summary' => $summary,
                'notes' => $notes,
                'created_by' => $this->user_id
            );

            if ($this->task_model->insert($insert_data)) {
                $this->postal->add('The task was created successfully', 'success');
            } else {
                $this->postal->add('Couldn\'t create the task', 'error');
            }
            redirect('projects/index/' . $project->id);
            */

        }
    }

/*

        //echo $project_id;
        //exit;


        $project = $this->project_model->get($project_id);

        if($project===FALSE)
        {
            $this->postal->add('Project doesn\'t exist.','error');
            redirect();
            die();
        }

        $this->load->model('project_user_model');
        $role = $this->project_user_model->get_role($project_id,$this->user_id);
        if($role===FALSE)
        {
            $role = $this->category_user_model->get_role($project->category_id,$this->user_id);
            if($role===FALSE)
            {
                redirect();
                die();
            }
        }
        if($role==='view')
        {
            $this->postal->add('You don\'t have the right to add projects to this project','error');
            redirect('projects/index/'.$project->id);
        }

        $role = $this->category_user_model->fields('role')->where(array('category_id'=>$category_id, 'user_id'=>$this->user_id))->get();

        if($role===FALSE || !in_array($role->role,array('admin','edit')))
        {
            $this->postal->add('You are not allowed to create a project in this category','error');
            redirect('categories/index/'.$category_id);
            exit();
        }
        //$this->data['before_body'] = $this->load->view('templates/_parts/reload_parent_view','',TRUE);
        //$this->data['before_body'] .= $this->load->view('templates/_parts/add_members_view','',TRUE);

        $this->form_validation->set_rules($this->rules['insert']);

        if($this->form_validation->run() === FALSE)
        {
            $this->data['category'] = $category;
            $this->render('projects/add_view');
        }
        else
        {
            $project_title = htmlspecialchars($this->input->post('title'));

            if($project_id = $this->project_model->insert(array('title' => $project_title, 'category_id'=>$category->id, 'created_by' => $this->user_id)))
            {
                $this->postal->add('New project added','success');

                $insert_member = array('user_id'=>$this->user_id, 'project_id'=>$project_id,'role'=>'admin');
                $this->load->model('project_user_model');
                if($this->project_user_model->insert($insert_member)===FALSE)
                {
                    $this->postal->add('Couldn\'t add you as member of the project','error');
                    redirect();
                }
                $this->postal->add('You were added as admin of the project','success');
                redirect('members/index/project/'.$project_id);
            }
            else
            {
                $this->postal->add('Couldn\'t create a project','error');
            }

        }*/
}