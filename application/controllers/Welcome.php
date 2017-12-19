<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin:*');
@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');

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

    public function reg(){
        $this -> load -> view('reg');
    }

    public function check_name(){
        //1.接收数据
        $username=$this -> input -> get('username');
        //2.验证
        if($username==''){
            echo '数据不能为空';
        }else{
        //3.数据库操作
            $this -> load -> model('user_model');
            $result=$this -> user_model -> get_by_name($username);
            if($result){
                echo 'fail';
            }else{
                echo 'success';
            }
        }
        //4.加载view
    }
}
