
<div class="container" style="margin-top 100px">
    <div class="row justify-content-center">
        <div class="col-md-6 col-offset-3" align="centre">
            <img src=><br><br>
            <form>
                <input placeholder="Email..." name="email" class="form-control"><br>
                <input placeholder="Password.." name="password" class="form-control"><br>
                <input type="submit" value="Log in" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<div class="lcb-navigation">
    <a href="#" data-ma-action="login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
</div>
</div>

<!-- Forgot Password -->
<div class="lc-block" id="l-forget-password">
    <form action="#" method="POST" class="lcb-form">
        <p class="text-center">A reset link will be sent to the email address below</p>



        <div class="input-group m-b-20">
            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
            <div class="fg-line">
                <input type="text" name="email" class="form-control input-lg" value="#" placeholder="Email Address" required autofocus><br>
            </div>
        </div>
        <button type="submit" class="btn btn-login btn-default btn-float"><i class="zmdi zmdi-check"></i></button><br>
    </form>

    <div class="lcb-navigation">
        <a href="#" data-ma-action="login-switch" data-ma-block="#l-login"><i class="zmdi zmdi-long-arrow-right"></i> <span>Sign in</span></a><br>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 23/02/2019
 * Time: 19:25
 */