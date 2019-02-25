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
        $this->get_user(false,$this->input->post('email'))['id'];
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
    function verify_email($key){
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
