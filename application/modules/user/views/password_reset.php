
<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 24/02/2019
 * Time: 19:27
 */
$action_url = "";
if($this->uri->segment(3) == null && $this->uri->segment(4) == null ){
    $actin_url = base_url('user/login/password_reset/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
}else{
    $action_url = base_url('user/login/password_reset/');
}
?>
<form action="<?= $action_url; ?>" method="post">
    <div class="card col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4 m-t-30">
        <div class="card-header ch-alt text-center text-capitalize">
            <h2>Enter your new password </h2>
        </div>

        <div class="card-body card-padding">
            <div class="form-group">

                    <input type="password" name="password" class="form-control" value="<?php echo set_value('password')?>" autofocus required>
                    <label>Password</label>

                <small class="help-block"><?php echo form_error('password'); ?></small>
            </div>
            <div class="form-group">

                    <input type="password" name="password2" class="form-control" value="<?php echo set_value('password2')?>" required>
                    <label class="fg-label">Confirm Password</label>

                <small class="help-block"><?php echo form_error('password2'); ?></small>
            </div>

            <div class="clearfix"></div>

            <div class="m-t-10">
                <button class="btn btn-lg btn-success btn-block">Update Password</button>
            </div>
        </div>
    </div>
</form>
