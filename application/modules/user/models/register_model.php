<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 23/02/2019
 * Time: 23:09
 */
class register_model extends CI_Model
{
    function insert($data){

        $this->db->insert('users',$data);
       // $this->get_user(false,$this->input->post('email'))['id'];
        return $this->db->insert_id();

    }
    public function get_user($user_id = FALSE,$user_email = FALSE){
        if($user_id){
            $this->db->where('id',$user_id);
        }else if($user_email){
            $this->db->where('email',$user_email);
        }
        $query = $this->db->get('users');
        return $query->row_array();
    }
    public function sendEmail($verification_key,$email){
        $from = "wambui54mwangi@gmail.com";    //senders email address
        $subject = 'Verify email address';  //email subject

        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        <a href=\'http://www.localhost/Auth/User/confirmEmail/'.$verification_key.'\'>http://www.localhost/Auth/User/confirmEmail/'. $verification_key .'</a><br><br>Thanks';


        $this->load->library('email');
        //config email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';

        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'eyskgctkullhynyb';  //sender's password
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = 'TRUE';
        $config['validation'] = TRUE;
        $config['newline'] = "\r\n";


        $this->email->initialize($config);
        //send email
        $this->email->from($from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);

        if($this->email->send()){
            //for testing
            echo $this->email->print_debugger();
            echo "sent to: ".$email."<br>";
            echo "from: ".$from. "<br>";
            echo "protocol: ". $config['protocol']."<br>";
            echo "message: ".$message;
            return true;
        }else{
            echo "email send failed";
            echo $this->email->print_debugger();
            return false;
        }



    }
    function verifyEmail($key){
        $this->db->where('verification_key',$key);
        $this->db->where('is_email_verified','no');
        $query = $this->db->get('users');
        if ($query->num_rows()>0){
            $data = array(
                'is_email_verified' => 'yes'
            );
            $this->db->where('verification_key',$key);
            $this->db->update('users', $data);
            return true;
        }
        else{
            return false;
        }
    }
}
