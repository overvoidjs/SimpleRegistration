
<!-- Forgot Password -->
<div class="container" style="margin-top 100px">
    <div class="row justify-content-center">
        <div class="col-md-6 col-offset-3" align="centre">
    <form action="<?= base_url('user/login/forgot_password'); ?>" method="POST">
        <p class="text-center">A reset link will be sent to the email address below</p>
        <?php echo validation_errors() ?>

        <?php if($this->session->flashdata('failed_email')): ?>
            <?php
            echo '<p class="alert alert-danger">'.
                $this->session->flashdata('failed_email').
                '</p>'
            ?>
        <?php endif; ?>

        <?php if($this->session->flashdata('reset_email_sent')): ?>
            <?php
            echo '<p class="alert alert-success">'.
                $this->session->flashdata('reset_email_sent').
                '</p>'
            ?>
        <?php endif; ?>


            <div class="form-group">
                <input type="email" name="email" class="form-control" value="<?php echo set_value('email') ?>" placeholder="Email Address" autofocus><br>
                <span class="text-danger"> <?php echo form_error('user_email');?></span>


        <button type="submit" class="btn btn-primary" value="Submit">Submit</button><br>
    </form>

    <div class="lcb-navigation">
        <a href="<?php echo base_url()?>user/index" data-ma-action="login-switch" data-ma-block="#l-login"><i class="zmdi zmdi-long-arrow-right"></i> <span>Sign in</span></a><br>
    </div>
</div>
    </div>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 24/02/2019
 * Time: 19:20
 */