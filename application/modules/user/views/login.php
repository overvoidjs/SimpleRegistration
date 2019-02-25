
<div class="container" style="margin-top 100px">
    <div class="row justify-content-center">
        <div class="col-md-6 col-offset-3" align="centre">
            <img src=><br><br>
            <div id="l-login">
            <form method="post" class="form" action="<?php echo base_url();?>user/login/validation">
                <?php if($this->session->flashdata('message')): ?>
                    <?php
                    echo '<p class="alert alert-danger">'.
                        $this->session->flashdata('message').
                        '</p>'
                    ?>
                <?php endif; ?>

                <?php if($this->session->flashdata('invalid_reset_code')): ?>
                    <?php
                    echo '<p class="alert alert-danger">'.
                        $this->session->flashdata('invalid_reset_code').
                        '</p>'
                    ?>
                <?php endif; ?>

                <?php if($this->session->flashdata('user_logged_out')): ?>
                    <?php
                    echo '<p class="alert alert-success">'.
                        $this->session->flashdata('user_logged_out').
                        '</p>'
                    ?>
                <?php endif; ?>

                <?php if($this->session->flashdata('updated_password')): ?>
                    <?php
                    echo '<p class="alert alert-success">'.
                        $this->session->flashdata('updated_password').
                        '</p>'
                    ?>
                <?php endif; ?>
                <h3 class="text-center text-info">Login</h3>


                <div class="form-group">
                    <input type="email" placeholder="Email..." name="user_email" class="form-control" value="<?php echo set_value('user_email')?>" >
                    <span class="text-danger"> <?php echo form_error('user_email');?></span>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password.." name="user_password" class="form-control" value="<?php echo set_value('user_password')?>"><br>
                    <span class="text-danger"> <?php echo form_error('user_password');?></span>
                </div>
                <div class="form-group">
                  <input type="checkbox" name="remember_me" value="true">
                    <i class="input-helper"></i>
                    <label>Keep me Signed in</label>

                </div>
                <div class="form-group">
                <input type="submit" name="login" value="Log in" class="btn btn-primary"> <a href="<?php echo base_url();?>user/index">Register</a>
                </div>
            </form>
            <div class="lcb-navigation">
                <a href="<?php echo base_url();?>user/login/forgot_password" data-ma-action="login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
            </div>
        </div>


    </div>
</div>





<?php
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 23/02/2019
 * Time: 19:25
 */