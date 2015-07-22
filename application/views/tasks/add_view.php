<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Add a task to project <?php echo $project->title;?>!</h1>
	<div class="row">
        <div class="col-lg-12" style="margin-bottom: 10px;">
            <?php
            echo anchor('projects/index/'.$project->id,'Back','class="btn btn-primary"');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo form_open();
            echo '<div class="form-group">';
            echo form_label('Title','title');
            echo form_error('title');
            echo form_input('title',set_value('title'),'class="form-control" placeholder="Task title" autofocus');
            echo '</div>';
            if($role==='admin')
            {
                echo '<div class="form-group">';
                echo form_label('Assigned to','assigned_to');
                echo form_error('assigned_to');
                echo form_dropdown('assigned_to',$members,set_select('assigned_to',$this->user_id),'class="form-control"');
                echo '</div>';
            }
            else
            {
                echo form_error('assigned_to');
                echo form_hidden('assigned_to',$this->user_id);
            }
            echo '<div class="form-group">';
            echo form_label('Priority','priority');
            echo form_error('priority');
            echo form_dropdown('priority',$priorities,set_select('priority'),'class="form-control"');
            echo '</div>';
            if($role==='admin')
            {
                echo form_error('status');
                echo form_hidden('status',1);
            }
            else
            {
                echo '<div class="form-group">';
                echo form_label('Status', 'status');
                echo form_error('status');
                echo form_dropdown('status', $statuses, set_select('status', 'Assigned'), 'class="form-control"');
                echo '</div>';
            }
            echo '<div class="form-group">';
            echo form_label('Due date','due_date');
            echo form_error('due_date');
            echo '<div class="input-group date datetimepicker">';
            echo form_input('due_date', set_value('due_date', date('Y-m-d H:i:s')), 'class="form-control"');
            echo '<span class="input-group-addon">';
            echo '<span class="glyphicon glyphicon-calendar"></span>';
            echo '</span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group">';
            echo form_error('description');
            echo form_input('description',set_value('description'),'class="form-control" placeholder="Task description"');
            echo '</div>';
            echo '<div class="form-group">';
            echo form_error('summary');
            echo form_textarea('summary',set_value('summary'),'class="form-control" placeholder="Task summary"');
            echo '</div>';
            echo '<div class="form-group">';
            echo form_error('notes');
            echo form_textarea('notes',set_value('notes'),'class="form-control" placeholder="Task notes"');
            echo '</div>';
            echo form_error('project_id');
            echo form_hidden('project_id',$project->id);
            echo form_submit('submit','Add task','class="btn btn-primary btn-block"');
            echo anchor('projects/index/'.$project->id, 'Cancel','class="btn btn-default btn-block" onclick="if (window.opener && window.opener.open && !window.opener.closed){window.close()};"');
            echo form_close();
            ?>
        </div>
    </div>
</div>