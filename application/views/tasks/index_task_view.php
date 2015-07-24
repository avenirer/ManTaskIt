<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <?php echo $this->make_bread->output();?>
    <?php
    if(in_array($project_role,array('admin','edit')))
    {
        ?>
    <div class="dropdown pull-right">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Options
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <?php
            echo '<li>'.anchor('tasks/edit/' . $task->id, 'Modify task').'</li>';
            echo '<li>'.anchor('tasks/add/' . $project->id, 'Add task', 'target="_blank"').'</li>';
            ?>
        </ul>
    </div>
    <?php }?>
    <h1>Task: <?php echo $task->title;?></h1>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $task->progress;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?php echo $task->progress;?>%;">
                    <?php echo $task->progress;?>%
                </div>
            </div>
            <?php echo '<span class="label" style="background-color: '.$task->priority_color.'; border:1px solid #ccc;">&nbsp</span> <strong>Due date:</strong> '.$task->due_date;?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h2>About:</h2>
            <h3>Description:</h3>
            <?php echo $task->description;?>
            <h3>Summary:</h3>
            <?php echo $task->summary;?>
            <h3>Notes:</h3>
            <?php echo $task->notes;?>

            <h2>Members</h2>

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
        <div class="col-lg-6">
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

    </div>
</div>