<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Add a project to category <?php echo $category->title;?>!</h1>
	<div class="row">
        <div class="col-lg-12" style="margin-bottom: 10px;">
            <?php
            echo anchor('categories/index/'.$category->id,'Back','class="btn btn-primary"');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo form_open();
            echo '<div class="form-group">';
            echo form_error('title');
            echo form_input('title',set_value('title'),'class="form-control" placeholder="Add project" autofocus');
            echo '</div>';
            echo form_error('category_id');
            echo form_hidden('category_id',$category->id);
            echo form_submit('submit','Add project','class="btn btn-primary btn-block"');
            echo anchor('categories/index/'.$category->id, 'Cancel','class="btn btn-default btn-block" onclick="if (window.opener && window.opener.open && !window.opener.closed){window.close()};"');
            echo form_close();
            ?>
        </div>
    </div>
</div>