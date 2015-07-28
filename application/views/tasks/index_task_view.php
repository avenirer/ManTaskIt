<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <?php echo $this->make_bread->output();?>
            <h1>Task: <?php echo $task->title;?></h1>
            <div class="well"><?php echo $task->summary;?></div>


            <h2>Task changes:</h2>
            <?php
            if(!empty($task_history))
            {
                foreach($task_history as $change)
                {
                    echo '<div class="panel panel-info">';
                    echo '<div class="panel-heading">'.$change->created_at.'</div>';
                    echo '<div class="panel-body">'.$change->changes.'</div>';
                    echo '</div>';
                }
            }
            ?>
            <?php
            /*
            echo '<pre>';
            print_r($task_history);
            echo '</pre>';
            */
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            $readonly = '';
            if($role!=='admin')
            {
                $readonly = ' readonly';
            }
            echo form_open();
            echo '<div class="profile-sidebar"><div class="profile">';
            echo '<div class="form-group">';
            echo form_label('Progress','progress');
            echo form_input('progress',set_value('progress',$task->progress), 'data-fgColor="#66CC66" data-angleOffset="-125" data-angleArc="250" class="dial" data-step="5" data-width="100%" data-displayPrevious="true"');
            echo '<script>$(".dial").knob();</script>';
            echo '</div>';
            echo '</div>';

            ?>

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

                <?php


                echo '<div class="form-group">';
                echo form_label('Status', 'status');
                echo form_error('status');
                if(in_array($role, array('admin','edit'))) {
                    echo form_dropdown('status', $statuses[$role], set_value('status', $task->status_id), 'class="form-control"');
                }
                else
                {
                    echo form_input('status',$statuses['admin'][$task->status_id],'class="form-control"'.$readonly);
                }
                echo '</div>';
                echo form_submit('submit','Edit task','class="btn btn-primary btn-block btn-lg"');
                echo anchor('projects/index/'.$task->id, 'Cancel','class="btn btn-default btn-block btn-lg" onclick="if (window.opener && window.opener.open && !window.opener.closed){window.close()};"');
                echo '<div class="form-group">';
                echo form_label('Title','title');
                echo form_error('title');
                echo form_input('title',set_value('title',$task->title),'class="form-control" placeholder="Task title"'.$readonly);
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Assigned to','assigned_to');
                echo form_error('assigned_to');
                if($role==='admin')
                {
                    echo form_dropdown('assigned_to', $members, set_value('assigned_to', $task->assignee_id), 'class="form-control"');
                }
                else
                {
                    echo form_input('',$members[$task->assignee_id],'class="form-control"'.$readonly);
                    echo form_hidden('assigned_to',$task->assignee_id);
                }
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Priority','priority');
                echo form_error('priority');
                if($role==='admin') {
                    echo form_dropdown('priority', $priorities, set_value('priority',$task->priority), 'class="form-control"');
                }
                else
                {
                    echo form_input('',$priorities[$task->priority],'class="form-control"'.$readonly);
                    echo form_hidden('priority',$task->priority);
                }
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Due date','due_date');
                echo form_error('due_date');
                if($role=='admin') {
                    echo '<div class="input-group date datetimepicker">';
                    echo form_input('due_date', set_value('due_date', $task->due_date), 'class="form-control"');
                    echo '<span class="input-group-addon">';
                    echo '<span class="glyphicon glyphicon-calendar"></span>';
                    echo '</span>';
                    echo '</div>';
                }
                else
                {
                    echo form_input('due_date',set_value('due_date',$task->due_date),'class="form-control"'.$readonly);
                }
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Summary','summary');
                echo form_error('summary');
                echo form_textarea('summary',set_value('summary',$task->summary),'class="form-control" placeholder="Task summary"'.$readonly);
                echo '</div>';
                echo form_error('task_id');
                echo form_hidden('task_id',$task->id);
                echo form_close();
                ?>


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
                    if(!empty($project_members))
                    {
                        foreach($project_members as $member)
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

</div>