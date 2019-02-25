
<div class="container">
	<div class="jumbotron">

			<h1>Hello <?php echo  print_r($this->session->userdata('name'));?></h1>
         <div class="container">
             <p>Welcome to this dashboard.</p>

            <a href="<?php echo base_url('user/login/logout'); ?>" class="btn btn-primary">LOGOUT</a>
         </div>
         </div>
    </div>