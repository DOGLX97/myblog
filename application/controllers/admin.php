<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin:*');
@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');


class Admin extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('article_model');
    }

    public function index(){
        $this->load->view('admin_index');
    }

    public function new_blog(){
        $loginedUser=$this->session->userdata('loginedUser');
        $types=$this->article_model->get_types_by_user($loginedUser->user_id);
        $this->load->view('new_blog',array(
            'types' => $types
        ));
    }

    public function post_blog(){
        //接收数据
        $title=htmlspecialchars($this->input->post('title'));
        $type_id=$this->input->post('type_id');
        $content=htmlspecialchars($this->input->post('content'));
        $loginedUser=$this->session->userdata('loginedUser');
        //验证
        //数据库操作
        $row=$this->article_model->save_article($title,$content,$loginedUser->user_id,$type_id);
        if($row > 0){
            redirect('admin/list_blogs');
        }else{
            echo 'fail';
        }
        //显示view上
    }

    public function list_blogs(){
        $loginedUser = $this->session->userdata('loginedUser');
        $articles = $this->article_model->get_ariticles_by_user($loginedUser->user_id);
        $this->load->view('list_blogs', array(
            'articles' => $articles
        ));
    }
}