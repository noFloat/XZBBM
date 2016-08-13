<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/12 0012
 * Time: 2:16
 */
class Api extends CI_Controller{

    public function __construct() {
        //TODO:记得取消注释
//        if(!checkLogin()){
//            redirect('index.php');
//        }
        parent::__construct();
        session_start();
    }

    private function auth() {
        $this->on_weixin();
        if(empty($_SESSION['isLogin'])){
            redirect(base_url('index.php/start/login'));
            exit;
        }
    }

    private function on_weixin(){
        if(empty($_SESSION['openid'])){
            redirect($this->getAuthUrl());
            exit;
        }
    }

    public function showImg($name){
        $this->auth();
        $path = './upload/';
        $file = $path.$name;
        if(!file_exists($file) || !check_filename($name)){
            set_status_header(404);
            exit;
        }
        $data = file_get_contents($file);
        $result = get_base_upload($data);
        header('Content-Type: '.$result['mime']);
        echo $result['data'];
    }

    public function addQuestion(){
        $this->auth();
        if($_SESSION['userType'] != 1){
            ajax(retData(401, '只允许萌新提问哦'));
        }
        $data['title'] = param($_POST['title']);
        $data['content'] = param($_POST['content']);
        $data['tag'] = $_POST['tag'];
        if(empty($data['title']) || mb_strlen($data['title']) > 20){
            ajax(retData(410, '标题长度大于20'));
        }
        if(empty($data['content']) || mb_strlen($data['content']) > 100)
            ajax(retData(411, '问题描述大于100'));
        if(!($data['tag'] = $this->checkTag($data['tag'])))
            ajax(retData(412, '请添加标签'));
//        dump($data);
        $data['pic_name'] = $this->uploadImg();
//        $_SESSION['userInfo']['stuNum'] = '2016210001';//TODO:记得删除
        $data['author_id'] = $_SESSION['userInfo']['stuNum'];
        $data['pid'] = 0;
        $this->load->model('discuss_model');
        $this->discuss_model->add($data);
        ajax(retData(200, 'ok'));
    }

    public function reply(){
        $this->auth();
        if($_SESSION['userType'] == 3){
            ajax(retData(401, '只允许志愿者和萌新回答哦'));
        }
        $data['pid'] = intval($_POST['pid']);
        $data['content'] = param($_POST['content']);
//        $_SESSION['userInfo']['stuNum'] = '2016210001';//TODO:记得删除
        $data['author_id'] = $_SESSION['userInfo']['stuNum'];
        $data['pic_name'] = $this->uploadImg();
        $this->load->model('discuss_model');
        $this->discuss_model->add($data);
        ajax(retData(200, 'ok'));
    }

    public function search($type = 'tag', $query = ""){
        $this->auth();
        $query = urldecode($query);
        if($type == 'tag'){
            $tag = $query;
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByTag($tag);
            ajax($result);
        }
        if($type == 'w'){
            $word = $query;
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByWord($word);
            ajax($result);
        }
        ajax(retData('404', 'unknown type'));
    }

    public function getQuestion($by = '最新问题', $page = 1, $limit = 10){
        $this->auth();
        $by = urldecode($by);
        if($by == '最新问题'){
            $this->load->model('discuss_model');
            $result = $this->discuss_model->getByNew($page, $limit);
            ajax($result);
        }
        if($by == '最热问题'){
            $this->load->model('discuss_model');
            $result = $this->discuss_model->getByHot($page, $limit);
            ajax($result);
        }
        ajax(retData(404, '没有改类别'));
    }

    public function question($id){
        $this->auth();
        if(empty($id)){
            ajax(retData(400, '错误的问题id'));
        }
        $id = intval($id);
        $this->load->model('discuss_model');
        $result = $this->discuss_model->showQuestion($id);
        if(empty($result)){
            ajax(retData(400, '错误的问题id'));
        }
        ajax($result);
    }

    public function user($stuId) {
        $this->auth();
        if(empty($stuId)){
            ajax(retData(400, '参数错误'));
        }
        $this->load->model('discuss_model');
        $result = $this->discuss_model->showUser($stuId);
        if(empty($result)){
            ajax(retData(404, '未找到此用户'));
        }
        ajax($result);
    }

    public function whoami(){
        $this->auth();
//        $_SESSION['userInfo']['stuNum'] = '2015210001';
        $stuId = $_SESSION['userInfo']['stuNum'];
        $this->load->model('discuss_model');
        $result = $this->discuss_model->showUser($stuId);
        ajax($result);
    }

    public function like($id){
        $this->auth();
//        $_SESSION['userInfo']['stuNum'] = '2015210001';
        if(empty($id)){
            ajax(retData(400, '请传入id'));
        }
        $id = intval($id);
        $this->load->model('discuss_model');
        $ret = $this->discuss_model->likeMgr($id);
        if($ret === false){
            ajax(retData(400, '参数错误'));
        }
        ajax(array('like_count' => $ret));
    }

    private function uploadImg(){
        $result = "";
        foreach ($_POST['pic'] as $value){
            $filename = uniqid('base64');
            if(empty($result)){
                $result = $filename;
            }else{
                $result .= '#'.$filename;
            }
            file_put_contents($filename, get_base_upload($value));
        }
        return $result;
    }

    private function checkTag($tag){
        if(empty($tag))
            return false;
        $tags = implode('#', $tag);
        return $tags;
    }

}