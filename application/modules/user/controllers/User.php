<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('register_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();

        if ($this->session->userdata('id')){
            redirect('../dashboard/dashboard');
        }

    }

    function index()
	{
        $this->load->view('register');
        $this->load->view('layout');

	}
	function validation(){
        $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_email','Email Address', 'required|trim'
        );
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');
        if ($this->form_validation->run()==true){

            $verification_key = md5(rand());
            $ver = 'yes';
            $encrypted_password = password_hash($this->input->post('user_password'),PASSWORD_BCRYPT);
            $data= array(
                'name'  => $this->input->post('user_name'),
                'email' => $this->input->post('user_email'),
                'password' => $encrypted_password,
                'verification_key' => $verification_key,
                'is_email_verified' => $ver

            );
            $id= $this->register_model->insert($data);

                if ($id > 0) {
                    $this->load->view('dashboard/dashboard');
                } else {
                    echo "Something went wrong";
                }




        }
        else{
            $this->index();
        }

    }
    function verify_email(){
        if($this->uri->segment(3)){
            $verification_key = $this->uri->segment(3);
            if($this->register_model->verify_email($verification_key)){
                $data['message'] = '<h1 align="center">Invalid Link </h1>';
            }
            $this->load->view('email_verification',$data);
        }
    }
    function login(){
        $this->load->view('login');
    }
    function login_validation(){
        $this->form_validation->set_rules('user_email','Email Address','required|trim|valid_email');
        $this->form_validation->set_rules('user_password','Password','required');
        if($this->form_validation->run()){
            $result = $this->login_model->can_login($this->input->post('user_email'),$this->input->post('user_password'));
            if($result=='')
            {
                $this->load->view('dashboard/dashboard');
            }
            else{
                $this->session->set_flashdata('message',$result);
                redirect('login');
            }
        }
        else{
            $this->index();
        }
    }

}
