<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <?php echo $this->make_bread->output();?>
    <h1>Projects</h1>
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    echo anchor('projects/add/' . $category->id,'Add project','class="btn btn-primary"');
                    ?>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">Project</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($projects))
                {
                    foreach($projects as $project)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('projects/index/'.$project->id,$project->title).'</td>';
                        echo '<td>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <h1>Members</h1>
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if($role == 'admin') {
                        echo anchor('members/index/category/' . $category->id, 'Administer members', 'class="btn btn-primary"');
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
                if(!empty($users))
                {
                    foreach($users as $user)
                    {
                        echo '<tr';
                        if($user->user_id===$this->user_id)
                        {
                            echo ' class="info"';
                        }
                        elseif($user->role==='admin')
                        {
                            echo ' class="success"';
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
                        echo '<td>'.anchor('projects/user/'.$category->id,$user->user->email).'</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>