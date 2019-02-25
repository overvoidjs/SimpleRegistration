<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="container" style="margin-top 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="centre">
                <img src=><br><br>
                <?php
                if($this->session->flashdata('message')){
                    echo '
                <div class = "alert alert-success">
                '.$this->session->flashdata("message").'
                </div>
                ';
                }
                ?>
                <form action="<?php echo base_url();?>user/validation" method="post" >
                    <div class="form-group">
                        <input type="text" placeholder="Name.." name="user_name" class="form-control" value="<?php echo set_value('user_name')?>">
                        <span class="text-danger"> <?php echo form_error('user_name');?></span>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email..." name="user_email" class="form-control" value="<?php echo set_value('user_email')?>" >
                        <span class="text-danger"> <?php echo form_error('user_email');?></span>
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password.." name="user_password" class="form-control" value="<?php echo set_value('user_password')?>"><br>
                        <span class="text-danger"> <?php echo form_error('user_password');?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="register" value="Register" class="btn btn-info" />
                    </div>


                </form>
                <button><a href="<?php echo base_url('')?>user/login">Login</a></button>

    </div>
    </div>
    </div>
<?php
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 23/02/2019
 * Time: 12:26
 */
