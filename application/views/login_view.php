<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ManTaskIt</title>
    <link href="<?php echo site_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"
                   href="<?php echo site_url();?>">ManTaskIt</a>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
    <div class="container" style="padding-top:60px;">
        <?php
        echo $this->postal->get();
        ?>
    </div>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <h1>Login</h1>
            <?php echo $this->session->flashdata('message');?>
            <?php echo form_open();?>
            <div class="form-group">
                <?php echo form_label('Username','identity');?>
                <?php echo form_error('identity');?>
                <?php echo form_input('identity','','class="form-control"');?>
            </div>
            <div class="form-group">
                <?php echo form_label('Password','password');?>
                <?php echo form_error('password');?>
                <?php echo form_password('password','','class="form-control"');?>
            </div>
            <div class="form-group">
                <label>
                    <?php echo form_checkbox('remember','1',FALSE);?> Remember me
                </label>
            </div>
            <?php echo form_submit('submit', 'Log in', 'class="btn btn-primary btn-lg btn-block"');?>
            <?php echo form_close();?>
        </div>
    </div>
    <footer>
        <div class="container">
            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        </div>
    </footer>
</body>
</html>