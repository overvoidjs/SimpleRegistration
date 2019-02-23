<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->module('register_model');
    }

    function index()
	{
        $this->load->view('register');
        $this->load->view('layout');

	}
	function validation(){
        $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_email','Email Address', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');
        if ($this->form_validation->run()){
            $verification_key = md5(rand());
            $encrypted_password = $this->encrypt->encode($this->input->post('user_password'));
            $data= array(
                'name'  => $this->input->post('user_name'),
                'email' => $this->input->post('user_email'),
                'password' => $encrypted_password,
                'verification_key' => $verification_key

            );
            $id = $this->register_model->insert($data);
            if ($id>0){
                
            }
        }
        else{
            $this->index();
        }

    }
}
