<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
	<h1>Categories</h1>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo anchor('categories/add','Add category','class="btn btn-primary" target="_blank"');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($user->categories))
                {
                    $categories = $user->categories;
                    foreach($categories as $category)
                    {
                        echo '<tr>';
                        echo '<td>'.anchor('categories/index/'.$category->id,$category->title).'</td>';
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