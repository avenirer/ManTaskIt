<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Project: <?php echo $project->title;?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo anchor('categories/index/' . $project->category_id, 'Back to category', 'class="btn btn-primary"');
            ?>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-12">
            <h2>Tasks</h2>
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if(in_array($project_role, array('admin','edit')) || in_array($category_role,array('admin','edit')))
                    {
                        echo anchor('tasks/add/' . $project->id, 'Add task', 'class="btn btn-primary"');
                    }
                    ?>
                </div>
            </div>
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
                if(!empty($tasks))
                {
                    foreach($tasks as $task)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('tasks/index/'.$task->id,'<span class="label" style="background-color:'.$task->priority->color.'; border:1px solid #ccc;">&nbsp;</span>').'</td>';
                        echo '<td>'.anchor('tasks/index/'.$task->id,$task->title).'</td>';
                        echo '<td>'.$task->status->title.'</td>';
                        echo '<td>'.$task->assignee->email.'</td>';
                        echo '<td>';
                        echo '<div class="progress">';
                        echo '<div class="progress-bar" role="progressbar" aria-valuenow="'.$task->progress.'" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">';
                        echo $task->progress.'%';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo explode(' ',$task->due_date)[0];
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
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
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if(in_array($project_role, array('admin')) || in_array($category_role, array('admin','edit')))
                    {
                        echo anchor('members/index/project/' . $project->id, 'Administer members', 'class="btn btn-primary"');
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
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