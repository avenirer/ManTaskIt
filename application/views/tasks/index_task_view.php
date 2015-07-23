<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Task: <?php echo $task->title;?></h1>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $task->progress;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                    <?php echo $task->progress;?>%
                </div>
            </div>
            <?php echo '<span class="label" style="background-color: '.$task->priority_color.'; border:1px solid #ccc;">&nbsp</span> <strong>Due date:</strong> '.$task->due_date;?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if(in_array($project_role,array('admin','edit')))
            {
                echo anchor('tasks/edit/' . $task->id, 'Modify task', 'class="btn btn-primary"').' ';
                echo anchor('tasks/add/' . $project->id, 'Add task', 'class="btn btn-primary" target="_blank"').' ';
            }
            echo anchor('projects/index/' . $task->project_id, 'Back to project '.$project->title, 'class="btn btn-primary"');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2>Description:</h2>
            <?php echo $task->description;?>
            <h2>Summary:</h2>
            <?php echo $task->summary;?>
            <h2>Notes:</h2>
            <?php echo $task->notes;?>

        </div>
        <?php
        /*
        echo '<pre>';
        print_r($task);
        echo '</pre>';
        */
        ?>
    </div>
	<div class="row">
        <div class="col-lg-12">
            <h2>Members</h2>
        </div>
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