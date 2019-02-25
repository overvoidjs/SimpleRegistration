

	<div class="jumbotron">
		<div class="container">
			<h1>Hello <?php echo '<pre>'; print_r($this->session->userdata('name'));?></h1>

            <a href="<?php echo base_url('user/login/logout'); ?>" class="btn btn-primary">LOGOUT</a>
        </div>
    </div>