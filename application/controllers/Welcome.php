<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function  login(){
	    $this->load->view('login');
    }

    public function check_login(){
	    //1.接收数据
        $username=$this->input->post('username');
        $password=$this->input->post('password');

        //2.验证

        //3.数据库操作
        $this->load->model('user_model');
        $query=$this->user_model->get_by_name_pwd($username,$password);
        if($query){
            echo 'success';
        }else{
            echo 'fail';
        }
    }
}
