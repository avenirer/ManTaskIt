<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
    <h1>Category: <?php echo $category->title;?></h1>
	<div class="row">
        <div class="col-lg-6">
            <h2>Projects</h2>
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    echo anchor('projects/add','Add project','class="btn btn-primary" target="_blank"');
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
        <div class="col-lg-6">
            <h2>Users</h2>
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if($role == 'admin') {
                        echo anchor('categories/admin_users/' . $category->id, 'Administer members', 'class="btn btn-primary"');
                    }
                    ?>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($category->users))
                {
                    $users = $category->users;
                    foreach($users as $user)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('projects/user/'.$category->id,$user->email).'</td>';
                        echo '<td>';

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