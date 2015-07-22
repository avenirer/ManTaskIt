<div class="container">
	<h1>Welcome to the Dashboard!</h1>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Categories</div>
                    <?php
                    if(!empty($categories))
                    {
                        echo '<ul class="list-group">';
                        foreach($categories as $category)
                        {
                            echo '<li class="list-group-item">';
                            echo anchor('categories/index/'.$category->id,$category->title);
                            echo ' <span class="badge">42</span>';
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

        </div>
    </div>
</div>