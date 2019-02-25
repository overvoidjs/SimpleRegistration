<?php
/**
 * Created by PhpStorm.
 * User: wambu
 * Date: 24/02/2019
 * Time: 12:17
 */
class login_model extends CI_Model{
    function login(){

        $this->db->where('email', $this->input->post('user_email'));
        $result = $this->db->get('users');
        if($result->num_rows() >0){
            return password_verify($this->input->post('user_password'),$result->row(0)->password)? $result->row(0): false;
        }



    }
    //Gets user details
    public function get_user($user_id = FALSE,$user_email = FALSE){
        if($user_id){
            $this->db->where('id',$user_id);
        }else if($user_email){
            $this->db->where('email',$user_email);
        }
        $query = $this->db->get('users');
        return $query->row_array();
    }
    public function update_password($encrypted_password, $user_id, $activated = FALSE){
        $data = array(
            'password' => $encrypted_password,
        );
        if(!$activated){
            $data['activated'] = 'true';
        }
        $this->db->where('id',$user_id);
        return $this->db->update('users',$data);
    }
    public function check_email($email){
        $this->db->where('email',$email);
        $query = $this->db->get('users');

        return ($query->num_rows() == 1);
    }
    //Updates the reset code on password change request
    public function set_reset_code($reset_code,$user_id){
        //Revoke any expired codes
        $this->revoke_expired_codes();
        $data = array(
            'user_id' => $user_id,
            'reset_code' => $reset_code
        );
        return $this->db->insert('password_reset',$data);
    }
    public function validate_reset_code($user_id,$reset_code){
        //Revoke any expired codes
        $this->revoke_expired_codes();
        $where = array(
            'user_id' => $user_id,
            'reset_code' => $reset_code,
            'valid' => 1
        );
        $this->db->where($where);
        $query = $this->db->get('password_reset');
        return ($query->num_rows() === 1);
    }
    //Revoke any links expired for password reset
    public function revoke_expired_codes(){
        $this->db->where('valid',1);
        $query = $this->db->get('password_reset');
        if($query->num_rows() > 0){

            foreach ($query->result() as $row) {
                $sent_at = date_create($row->sent_at);
                $now = date_create();
                $diff = date_diff($now,$sent_at);
                if($diff->d >= 2){
                    $this->db->update('password_reset',array('valid' => 0),array('reset_code'=> $row->reset_code));
                }

            }
        }
    }

    /**
     * Revoke used reset codes
     */
    public function revoke_reset_code($user_id,$reset_code){
        $where = array(
            'user_id' => $user_id,
            'reset_code' => $reset_code
        );
        $data = array('valid'=>0);
        $this->db->where($where);
        return $this->db->update('password_reset',$data);
    }



}