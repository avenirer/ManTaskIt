<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
	<h1>Add users to category "<?php echo $category->title;?>"!</h1>
    <div class="row">
        <div class="col-lg-6">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Role</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($users))
                {
                    foreach($users as $user)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('projects/index/'.$category->id.'/'.$user->user_id,$user->user->email).'</td>';
                        echo '<td>';
                        echo '<span class="glyphicon glyphicon-tree-deciduous'.(($user->role==='admin') ? ' text-danger' : ' text-muted').'"></span> ';
                        if($role==='admin')
                        {
                            echo anchor('category/change_role/'.$category->id.'/'.$user->user_id,'<span class="glyphicon glyphicon-apple"></span>');
                        }
                        else {
                            echo '<span class="glyphicon glyphicon-apple' . (($user->role === 'edit') ? ' text-danger' : ' text-muted') . '"></span> ';
                        }
                        echo '</td>';
                        echo '<td>';
                        if($role==='admin')
                        {
                            echo anchor('categories/remove_user/' . $category->id . '/' . $user->user_id, '<span class="glyphicon glyphicon-minus"></span>');
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <?php
            echo '<pre>';
            print_r($category);
            echo '</pre>';
            echo form_open();
            echo '<div class="form-group">';
            echo form_error('members');
            echo form_input('members','','id="members_options" autofocus autocomplete="off" placeholder="Members"');
            echo '</div>';
            echo form_error('category_id');
            echo form_hidden('category_id',$category->id);
            echo form_submit('submit','Add users','class="btn btn-primary btn-block"');
            echo anchor('categories', 'Cancel','class="btn btn-default btn-block" onclick="if (window.opener && window.opener.open && !window.opener.closed){window.close()};"');
            echo form_close();
            ?>
        </div>
    </div>
</div>