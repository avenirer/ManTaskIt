<div class="container" style="margin-top:60px;">
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
                            echo anchor('categories/index/'.$category->id,$category->title).' ';
                            echo anchor('categories/edit/'.$category->id,'<span class="glyphicon glyphicon-pencil"></span>');
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                <div class="panel-footer">
                    <?php
                    echo form_open();
                    echo form_error('category');
                    echo form_input('category',set_value('category'),'class="form-control" placeholder="Add category"');
                    echo form_close();
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>