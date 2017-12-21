<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{
    public function get_by_name_pwd($username,$password){
        return $this -> db -> get_where('t_user', array(
            'username' => $username ,
            'password' => $password
        )) -> row();
    }

    public function get_by_name($username){
        return $this -> db -> get_where('t_user',array(
            'username' => $username
        )) -> row();
    }

    public function save($email, $username, $password, $gender, $province, $city){
        $this -> db -> insert('t_user', array(
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'sex' => $gender,
            'province' => $province,
            'city' => $city
        ));
        return $this -> db -> affected_rows();
    }
}
?>