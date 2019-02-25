<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* HODController
*/
class Dashboard extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('user_id')){
		    redirect('user/login');
        }

	}

	public function index()
	{
		//echo "<br><br><br><h1 align='center'>Welcome User</h1>";
        //echo '<p align="center"><a href="'.base_url().'dashboard/logout">Logout</a></p>';
        $this->load->view('dashboard');

	}
	function logout(){
	    $data = $this->session->all_userdata();
	    foreach ($data as $row => $rows_value){
	        $this->session->unset_userdata($row);
        }
	    redirect('user/login');
    }
}

/* End of file HODController.php */
/* Location: ./application/modules/dashboard/controller/HODController.php */