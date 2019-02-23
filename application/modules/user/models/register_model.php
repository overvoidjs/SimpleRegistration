<?php
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
        return $this->db->insert_id();
    }
}
