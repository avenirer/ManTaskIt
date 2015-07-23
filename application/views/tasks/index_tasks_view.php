<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Task: <?php echo $task->title;?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if(in_array($project_role,array('admin','edit')))
            {
                echo anchor('tasks/edit/' . $task->id, 'Modify task', 'class="btn btn-primary"').' ';
            }
            echo anchor('projects/index/' . $task->project_id, 'Back to project '.$project->title, 'class="btn btn-primary"');
            ?>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if(in_array($project_role, array('admin','edit')) || in_array($category_role,array('admin','edit')))
                    {
                        echo anchor('tasks/add/' . $project->id, 'Add task', 'class="btn btn-primary" target="_blank"');
                    }
                    ?>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">Task</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($tasks))
                {
                    foreach($tasks as $task)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('tasks/index/'.$task->id,$task->title).'</td>';
                        echo '<td>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <h2>Members</h2>
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