<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Edit task <?php echo $task->title;?>!</h1>
	<div class="row">
        <div class="col-lg-12" style="margin-bottom: 10px;">
            <?php
            echo anchor('tasks/index/'.$task->id,'Back','class="btn btn-primary"');
            echo '<pre>';
            print_r($task);
            echo '</pre>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            $readonly = '';
            if($role!=='admin')
            {
                $readonly = ' readonly';
            }
            echo form_open();

            echo '<div class="form-group">';
            echo form_label('Progress','progress');
                echo '<div class="range range-primary">';
                    echo '<input type="range" name="progress" min="0" max="100" value="'.set_value('progress',$task->progress).'" onchange="rangePrimary.value=value">';
                    echo '<output id="rangePrimary">'.set_value('progress',$task->progress).'</output>';
                echo '</div>';
            echo '</div>';
            echo '<div class="form-group">';
            echo form_label('Status', 'status');
            echo form_error('status');
            if(in_array($role, array('admin','edit'))) {
                echo form_dropdown('status', $statuses[$role], set_select('status', $task->status_id), 'class="form-control"');
            }
            else
            {
                echo form_input('status',$statuses['admin'][$task->status_id],'class="form-control"'.$readonly);
            }
            echo '</div>';
            echo '<div class="form-group">';
            echo form_error('notes');
            echo form_textarea('notes',set_value('notes',$task->notes),'class="form-control" placeholder="Task notes"');
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
            echo form_label('Description','description');
            echo form_error('description');
            echo form_input('description',set_value('description',$task->description),'class="form-control" placeholder="Task description"'.$readonly);
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
        </div>
    </div>
</div>