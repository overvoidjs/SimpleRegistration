<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 24/02/2019
 * Time: 11:38
 */
class Login extends MX_Controller{
    function __construct()
    {
        parent::__construct();
      //  if ($this->session->userdata('id')){
         //   redirect('private_area');
       // }

        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('login_model');
        if(isset($_COOKIE['user_id'])){
            $user = $this->login_model->get_user($_COOKIE['user_id'],FALSE);
            $user_data = array(
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],

                'logged_in' => true
            );
            $this->session->set_userdata($user_data);
        }



    }
    function index(){
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');




    }
    function validation(){
        $this->form_validation->set_rules('user_email','Email Address','required|trim|valid_email');
        $this->form_validation->set_rules('user_password','Password','required');
        if($this->form_validation->run()){
            $user = $this->login_model->login();
            $remember_me = $this->input->post('remember_me');
            if($user)
            {
                $user_data = array(
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'logged_in' => true
                );
                $this->session->set_userdata($user_data);
                if($remember_me){
                    //Create cookie
                    setcookie('user_id', $user_data['user_id'], time() + (86400 * 30), "/");
                }

                    redirect('dashboard');


            }
            else{
                $this->session->set_flashdata('message','Invalid credentials');
                redirect('login');
            }
        }

    }
    public function logout(){
        $data = $this->session->all_userdata();
        foreach ($data as $row => $rows_value){
            $this->session->unset_userdata($row);
        }
        $this->session->set_flashdata('user_logged_out','You are now logged out');
        redirect('login');

    }
    public function password_reset($user_id = FALSE,$reset_code = FALSE)
    {
        if ($user_id && $reset_code) {
            $valid_code = $this->login_model->validate_reset_code($user_id, $reset_code);
            if (!$valid_code) {
                $this->session->set_flashdata('invalid_reset_code', "The reset link has expired or does not exist");
                redirect(base_url());
            }
        } else {
            $user_id = $this->session->userdata('user_id');
        }
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]',array(
            'matches' => "Passwords do not match"
        ));
        if($this->form_validation->run() == FALSE){
            $this->load->view('header');
            $this->load->view('password_reset');
            $this->load->view('footer');

        }else{
            $encrypted_password = password_hash($this->input->post('password'),PASSWORD_BCRYPT);
            $this->login_model->update_password($encrypted_password,$user_id,TRUE);
            if($user_id && $reset_code){
                $this->user_model->revoke_reset_code($user_id,$reset_code);
            }
            $this->session->set_flashdata('updated_password','Password successfully updated');
            redirect('login');
        }


    }
    public function forgot_password(){


        //validation
        $this->form_validation->set_rules('email','Email Address','trim|required|valid_email');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">', '</div>');

        if($this->form_validation->run() == FALSE){
            $this->load->view('header');
            $this->load->view('forgot_password');
            $this->load->view('footer');

        }else{
            //Send email to user with a reset link
            $reset_code = md5(rand());
            $user = $this->login_model->get_user(FALSE,$this->input->post('email'));
            //Update reset code to database
            $updated = $this->login_model->set_reset_code($reset_code,$user['id']);
            $body = '<p>Dear '.$user['name'].',</p>
                <p>Use the link below to reset your password. If you have not requested for a password
                reset, please check your account for security reasons.</p>
                <a href="'.base_url('user/login/password_reset/'.$user['id'].'/'.$reset_code).'">Reset Password</a>
                <p>This link will expire in 48 hours</p>';

            $settings = array(
                'to' => $this->input->post('email'),
                'subject' => 'PASSWORD RESET',
                'body' => $body
            );
            if($updated){
                // Send email to user
                if($this->email->send($settings)){
                    $this->session->set_flashdata('reset_email_sent','Reset link sent to your email');
                    redirect('login');
                }
            }else {
                //Set session message
                $this->session->set_flashdata('failed_email','Email could not be sent. Please try again later');
                redirect('login');
            }

        }
    }
    /**
     * Callback custom validation to check email exists
     */
    public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists','Email is not registered');
        return $this->login_model->check_email($email);
    }

}
