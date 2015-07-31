<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <h1>Tasks to do</h1>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col"><span class="glyphicon glyphicon-tag"></span></th>
                    <th scope="col">Task</th>
                    <th scope="col">Status</th>
                    <th scope="col">Assigned to</th>
                    <th scope="col">Progress</th>
                    <th scope="col">Due date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($unfinished_tasks))
                {
                    foreach($unfinished_tasks as $task)
                    {
                        echo '<tr>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, '<span class="label" style="background-color:' . $task->priority->color . '; border:1px solid #ccc;">&nbsp;</span>') . '</td>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, $task->title) . '</td>';
                        echo '<td>' . $task->status->title . '</td>';
                        echo '<td>' . $task->assignee->email . '</td>';
                        echo '<td>';
                        echo '<div class="progress">';
                        echo '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="' . $task->progress . '" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: ' . $task->progress . '%;">';
                        echo $task->progress . '%';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td class="text-right">';
                        $date = explode('-', explode(' ', $task->due_date)[0]);
                        $due_date = $date[2] . '.' . $date[1];
                        echo $due_date;
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>

            <h1>Finished tasks</h1>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col"><span class="glyphicon glyphicon-tag"></span></th>
                    <th scope="col">Task</th>
                    <th scope="col">Status</th>
                    <th scope="col">Assigned to</th>
                    <th scope="col">Progress</th>
                    <th scope="col">Due date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($finished_tasks))
                {
                    foreach($finished_tasks as $task)
                    {
                        echo '<tr>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, '<span class="label" style="background-color:' . $task->priority->color . '; border:1px solid #ccc;">&nbsp;</span>') . '</td>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, $task->title) . '</td>';
                        echo '<td>' . $task->status->title . '</td>';
                        echo '<td>' . $task->assignee->email . '</td>';
                        echo '<td>';
                        echo '<div class="progress">';
                        echo '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="' . $task->progress . '" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: ' . $task->progress . '%;">';
                        echo $task->progress . '%';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td class="text-right">';
                        $date = explode('-', explode(' ', $task->due_date)[0]);
                        $due_date = $date[2] . '.' . $date[1];
                        echo $due_date;
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile">
                    <div class="panel status panel-danger">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">
                                <?php
                                echo ($unfinished_tasks) ? sizeof($unfinished_tasks) : '0';
                                ?></h1>
                        </div>
                        <div class="panel-body text-center">
                            <strong>unfinished tasks</strong>
                        </div>
                    </div>
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-title">
                    <div class="profile-category">
                        <?php echo anchor(site_url('categories/index/'.$category->id), 'Category: '.$category->title);?>
                    </div>
                    <div class="profile-project">
                        <?php echo anchor(site_url('projects/index/'.$project->id), 'Project: '.$project->title);?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <?php
                    if(in_array($project_role, array('admin','edit')) || in_array($category_role,array('admin','edit')))
                    {
                        echo anchor('tasks/add/' . $project->id, 'Add task', 'class="btn btn-success btn-sm"');
                    }
                    ?>
                    <!--<button type="button" class="btn btn-danger btn-sm">Message</button>-->
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <?php
                        if(in_array($project_role, array('admin')) || in_array($category_role, array('admin','edit')))
                        {
                            echo '<li>';
                            echo anchor('members/index/project/' . $project->id, '<i class="glyphicon glyphicon-user"></i> Administer members');
                            echo '</li>';
                        }
                        ?>
                        <li>
                            <a href="#" target="_blank">
                                <i class="glyphicon glyphicon-ok"></i>
                                Tasks </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="glyphicon glyphicon-flag"></i>
                                Help </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->

                <h3>Project members</h3>
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th scope="col">Member</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($members))
                    {
                        foreach($members as $member)
                        {
                            echo '<tr';
                            if($member->user_id===$this->user_id)
                            {
                                echo ' class="info"';
                            }
                            elseif($member->role==='admin')
                            {
                                echo ' class="success"';
                            }
                            elseif($member->role==='view')
                            {
                                echo ' class="warning"';
                            }
                            elseif($member->role==='removed')
                            {
                                echo ' class="danger"';
                            }
                            echo '>';
                            echo '<td>'.anchor('projects/user/'.$project->id,$member->user->email).'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>

                <h3>Category members</h3>
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th scope="col">Member</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($category_members))
                    {
                        foreach($category_members as $member)
                        {
                            echo '<tr';
                            if($member->user_id===$this->user_id)
                            {
                                echo ' class="info"';
                            }
                            elseif($member->role==='admin')
                            {
                                echo ' class="success"';
                            }
                            elseif($member->role==='view')
                            {
                                echo ' class="warning"';
                            }
                            elseif($member->role==='removed')
                            {
                                echo ' class="danger"';
                            }
                            echo '>';
                            echo '<td>'.anchor('projects/user/'.$project->id,$member->user->email).'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <?php echo $this->make_bread->output();?>
</div>