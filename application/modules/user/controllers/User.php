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
            redirect('dashboard');
        }

    }

    function index()
	{

        $this->load->view('header');
        $this->load->view('register');
        $this->load->view('footer');

	}
	function validation(){
        $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_email','Email Address', 'trim|required|is_unique[users.email]',array('is_unique' => 'This %s already exists')
        );
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');
        if ($this->form_validation->run()==true) {

            $verification_key = md5(rand());

            $encrypted_password = password_hash($this->input->post('user_password'), PASSWORD_BCRYPT);
            $ans = 'yes';
            $data = array(
                'name' => $this->input->post('user_name'),
                'email' => $this->input->post('user_email'),
                'password' => $encrypted_password,
                'verification_key' => $verification_key,



            );

            if ($this->register_model->insert($data)) {
                $email= $this->input->post('user_email');
                if ($this->register_model->sendEmail($verification_key,$email)) {
                    $this->session->set_flashdata('message', 'Successfully registered. Please confirm the mail that has been sent to your email');
                    $this->load->view('header');
                    $this->load->view('register');
                    $this->load->view('footer');

            } else {
                $this->session->set_flashdata('message', 'Could not verify your email');
                redirect('user');
            }

        }


        }
        else{
            $this->index();
        }

    }

    function confirmEmail($verification_key){
        if($this->register_model->verifyEmail($verification_key)){
            $this->session->set_flashdata('verify', '<div class="alert alert-success text-center">Email address is confirmed. Please login to the system</div>');
            redirect('login');
        }else{
            $this->session->set_flashdata('verify', '<div class="alert alert-danger text-center">Email address is not confirmed. Please try to re-register.</div>');
            redirect('login');
        }
    }
    function login(){
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
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
