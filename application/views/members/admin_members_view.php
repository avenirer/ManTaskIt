<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <?php echo $this->make_bread->output();?>
	<h1>Administer members on <?php echo $type.' "'.$type_content->title.'"';?>!</h1>
    <?php echo anchor(plural($type).'/index/'.$type_content->id,'Back','class="btn btn-primary"');?>
    <div class="row">
        <div class="col-lg-6">
            <h2>Members assigned</h2>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">Member</th>
                    <th scope="col">Role</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($users))
                {
                    foreach($users as $user)
                    {
                        echo '<tr';
                        if($user->user_id===$this->user_id)
                        {
                            echo ' class="info"';
                        }
                        elseif($user->role==='view')
                        {
                            echo ' class="warning"';
                        }
                        elseif($user->role==='removed')
                        {
                            echo ' class="danger"';
                        }
                        echo '>';
                        echo '<td>';
                        if($type === 'category')
                        {
                            echo anchor('projects/index/'.$type_content->id.'/'.$user->user_id,$user->user->email);
                        }
                        else
                        {
                            echo anchor('tasks/index/'.$type_content->id.'/'.$user->user_id,$user->user->email);
                        }
                        echo '</td>';
                        echo '<td>';
                        if($role==='admin' && $user->role!=='admin')
                        {
                            echo anchor('members/change_role/'.$type.'/'.$type_content->id.'/'.$user->user_id.'/admin','<span class="glyphicon glyphicon-tree-deciduous"></span>').' ';
                        }
                        else
                        {
                            echo '<span class="glyphicon glyphicon-tree-deciduous' . (($user->role === 'admin') ? ' text-danger' : ' text-muted') . '"></span> ';
                        }
                        if($role==='admin' && $user->role!=='edit')
                        {
                            echo anchor('members/change_role/'.$type.'/'.$type_content->id.'/'.$user->user_id.'/edit','<span class="glyphicon glyphicon-apple"></span>').' ';
                        }
                        else
                        {
                            echo ' <span class="glyphicon glyphicon-apple' . (($user->role === 'edit') ? ' text-danger' : ' text-muted') . '"></span> ';
                        }
                        if($role==='admin' && $user->role!=='view')
                        {
                            echo anchor('members/change_role/'.$type.'/'.$type_content->id.'/'.$user->user_id.'/view','<span class="glyphicon glyphicon-eye-open"></span>').' ';
                        }
                        else
                        {
                            echo '<span class="glyphicon glyphicon-eye-open' . (($user->role === 'view') ? ' text-danger' : ' text-muted') . '"></span> ';
                        }
                        if($role==='admin' && $user->role!=='removed')
                        {
                            echo anchor('members/change_role/'.$type.'/'.$type_content->id.'/'.$user->user_id.'/removed','<span class="glyphicon glyphicon-remove"></span>').' ';
                        }
                        else
                        {
                            echo '<span class="glyphicon glyphicon-remove' . (($user->role === 'removed') ? ' text-danger' : ' text-muted') . '"></span> ';
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
            <h2>Add members</h2>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">Member</th>
                    <th scope="col">Add</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($available_users))
                {
                    foreach($available_users as $user)
                    {
                        echo '<tr>';
                        echo '<td>';
                        echo $user['email'];
                        echo '</td>';
                        echo '<td>';
                        echo anchor('members/add/'.$type.'/'.$type_content->id.'/'.$user['id'],'<span class="glyphicon glyphicon-user"></span>').' ';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>