<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
	<h1>Add a category!</h1>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo form_open();
            echo '<div class="form-group">';
            echo form_error('category');
            echo form_input('category',set_value('category'),'class="form-control" placeholder="Add category" autofocus');
            echo '</div>';
            echo form_submit('submit','Add category','class="btn btn-primary btn-block"');
            echo anchor('categories', 'Cancel','class="btn btn-default btn-block" onclick="if (window.opener && window.opener.open && !window.opener.closed){window.close()};"');
            echo form_close();
            ?>
        </div>
    </div>
</div>