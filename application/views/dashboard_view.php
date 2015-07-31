<div class="container">
	<h1>Welcome to the Dashboard!</h1>
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Categories</div>
                    <?php
                    if(!empty($categories))
                    {
                        echo '<ul class="list-group">';
                        foreach($categories as $category)
                        {
                            echo '<li class="list-group-item">';
                            echo ' <span class="label label-danger">'.$category->number_tasks.'</span> ';
                            echo anchor('categories/index/'.$category->id,$category->title);
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                <div class="panel-footer">
                    <?php
                    echo anchor('categories/add','<span class="glyphicon glyphicon-plus"></span>','class="btn btn-primary btn-block"');
                    /*
                    echo form_open();
                    echo form_error('category');
                    echo form_input('category',set_value('category'),'class="form-control" placeholder="Add category"');
                    echo form_close();
                    */
                    ?>
                </div>
            </div>

            <h1>Tasks to do</h1>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col"><span class="glyphicon glyphicon-tag"></span></th>
                    <th scope="col">Task</th>
                    <th scope="col">Status</th>
                    <th scope="col">Assigned to</th>
                    <th scope="col">Progress</th>
                    <th scope="col">Due date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($active_tasks))
                {
                    foreach($active_tasks as $task)
                    {
                        echo '<tr>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, '<span class="label" style="background-color:' . $task->priority_color . '; border:1px solid #ccc;">&nbsp;</span>') . '</td>';
                        echo '<td>' . anchor('tasks/index/' . $task->id, $task->title) . '</td>';
                        echo '<td>' . $task->status_title . '</td>';
                        echo '<td>' . $task->assignee_email . '</td>';
                        echo '<td>';
                        echo '<div class="progress">';
                        echo '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="' . $task->progress . '" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: ' . $task->progress . '%;">';
                        echo $task->progress . '%';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td class="text-right">';
                        $date = explode('-', explode(' ', $task->due_date)[0]);
                        $due_date = $date[2] . '.' . $date[1];
                        echo $due_date;
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>


        <div class="col-lg-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile">
                    <div class="panel status panel-danger">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">
                                <?php
                                echo ($active_tasks) ? sizeof($active_tasks) : '0';
                                ?></h1>
                        </div>
                        <div class="panel-body text-center">
                            <strong>unfinished tasks</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>