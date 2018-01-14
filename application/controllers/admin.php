<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin:*');
@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');


class Admin extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('comment_model');
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

    public function delete_articles(){
        $ids = $this->input->get('ids');

        $rows = $this->article_model->delete_articles($ids);
        if($rows > 0){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    public function get_blog_by_id(){
        //接数据
        $id=$this->input->get('id');
        $user_id=$this->session->userdata('loginedUser')->user_id;
        $results = $this->article_model->get_ariticles_by_user($user_id);
        $comment_results = $this->comment_model->get_comment_by_articleid($id);
        $prevArticle = null;
        $nextArticle = null;
        foreach ($results as $index=>$result){
            if($id == $result->article_id){
                $row = $result;
                if($index>0){
                    $prevArticle = $results[$index-1];
                }

                if($index<count($results)-1){
                    $nextArticle = $results[$index+1];
                }

                break;
            }
        }
        //到页面
        if($results){
            $this->load->view('viewPost',array(
                'row' => $row,
                'prevArticle' => $prevArticle,
                'nextArticle' => $nextArticle,
                'comment_results' => $comment_results
            ));
        }else{
            echo 'fail';
        }
    }
}