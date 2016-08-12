<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/12 0012
 * Time: 2:16
 */
class Api extends CI_Controller{

    public function addQuestion(){
        //TODO:xss过滤有问题
        $data['title'] = param($_POST['title']);
        $data['content'] = param($_POST['content']);
        $data['tag'] = $_POST['tag'];
        if(empty($data['title']) || mb_strlen($data['title']) > 20){
            ajax(retData(410, '标题长度大于20'));
        }
        if(empty($data['content']) || mb_strlen($data['content']) > 100)
            ajax(retData(411, '问题描述大于100'));
        if(!($tags = $this->checkTag($data['tag'])))
            ajax(retData(412, '请添加标签'));
//        dump($data);
        $data['pic_name'] = $this->uploadImg();
        $_SESSION['userInfo']['stuNum'] = '2016210001';//TODO:记得删除
        $data['author_id'] = $_SESSION['userInfo']['stuNum'];
        $data['pid'] = 0;
        $this->load->model('discuss_model');
        $this->discuss_model->add($data);
        ajax(retData(200, 'ok'));
    }

    public function reply(){
        $data['pid'] = intval($_POST['pid']);
        $data['content'] = param($_POST['content']);
        $_SESSION['userInfo']['stuNum'] = '2016210001';//TODO:记得删除
        $data['author_id'] = $_SESSION['userInfo']['stuNum'];
        $data['pic_name'] = $this->uploadImg();
        $this->load->model('discuss_model');
        $this->discuss_model->add($data);
        ajax(retData(200, 'ok'));
    }

    public function search(){
        $type = $_GET['type'];
        if($type == 'tag'){
            $tag = $_POST['tag'];
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByTag($tag);
            ajax($result);
        }
        if($type == 'word'){
            $word = $_POST['word'];
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByWord($word);
            ajax($result);
        }
        ajax(retData('404', 'unknown type'));
    }

    public function getQuestion($by = 'new', $page = 1, $limit = 10){
        if($by == 'new'){
            $this->load->model('discuss_model');
            $result = $this->discuss_model->getByNew($page, $limit);
            ajax($result);
        }
        if($by == 'hot'){
            $this->load->model('discuss_model');
            $result = $this->discuss_model->getByHot($page, $limit);
            ajax($result);
        }
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