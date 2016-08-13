<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/11 0011
 * Time: 15:00
 */
class Start extends CI_Controller{

    private $token = 'gh_68f0a1ffc303';
    private $appId = 'wx81a4a4b77ec98ff4'; //公众号的唯一标识
    private $state = 'auth'; //重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
    private $responseType = 'code'; //返回类型，请填写code
    private $scope = 'snsapi_base'; //应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
    private $redirectUrl = 'http://hongyan.cqupt.edu.cn/XZBBM/index.php/start/weixin'; //授权后重定向的回调链接地址，请使用urlencode对链接进行处理
    private $authtUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect'; //微信授权地址
    private $api = array(
        'isSubscribe' => 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/openidVerify',
        'getUserInfo' => 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/userInfo',
        'webAuth'     => 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/webOAuth',
        'userVerify'  => 'http://hongyan.cqupt.edu.cn/api/verify'
    );

    public function __construct() {
        parent::__construct();//TODO 添加登录验证
        session_start();
//        $_SESSION['openid'] = 'ouRCyjrHGCXiA2OGYbucjLMBka1g';
        $this->on_weixin();
    }

    private function auth() {
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

    public function login(){
        $this->load->view('sign');
    }

    public function doLogin() {
        if(empty($_POST['stuNum']) || empty($_POST['idNum']))
            ajax(retData(400, '请填写账号和密码'));
        $username = $_POST['stuNum'];
        $password = $_POST['idNum'];
        $data = array(
            'stuNum' => $username,
            'idNum'  => $password
        );
        $query = http_build_query($data);
        $result = curl_api($this->api['userVerify'], $query);
        if($result->status != 200){
            ajax(retData(401, '账号或密码错误'));
        }
//        dump($result);
        $result->data->grade = trim($result->data->grade);
        $this->loginSuccess($result->data);

    }

    public function weixin(){
        //TODO:取消注释
        if(empty($_REQUEST['code']) || empty($_REQUEST['state'])){
            ajax(array('msg' => 'unauthorized'));
        }
        $openId = $this->getOpenId($_REQUEST['code']);
//        $openId = 'ouRCyjrHGCXiA2OGYbucjLMBka1g';//TODO:记得删除
        if(!$this->isSubscribe($openId)){
//            redirect('http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Bind/Bind/bind');
            echo '<h1>';
            echo '请先关注小帮手<^_^>';
            echo '</h1>';
            exit;
        }
        $_SESSION['openid'] = $openId;
        redirect(base_url('index.php/start/index'));

    }

    public function user($stuId = '') {
        $this->auth();
        $this->load->model('discuss_model');
        if(empty($stuId)){
            $result = $this->discuss_model->showUser($_SESSION['userInfo']['stuNum']);
            $this->load->view('userDetail', array('render' => $result));
        }else{
            $result = $this->discuss_model->showUser($stuId);
            if(empty($result)){
                ajax(retData(404, '未找到此用户'));
            }
            $this->load->view('userDetail', array('render' => $result));
        }
    }

    public function index($by = '最新问题', $page = 1, $limit = 5){
        $this->auth();
        $by = urldecode($by);
        if($by == '最新问题'){
            $this->load->model('discuss_model');
            $result = $this->discuss_model->getByNew($page, $limit);
            $this->load->view('index', array('render' => $result));
            return;
        }
//        if($by == '最热问题'){
//            $this->load->model('discuss_model');
//            $result = $this->discuss_model->getByHot($page, $limit);
//            ajax($result);
//        }
        ajax(retData(404, '没有改类别'));
    }

    public function userQuestion($stuId){
        $this->auth();
        if(empty($stuId))
            ajax(retData(404, '请访问正确的用户'));
        $this->load->model('discuss_model');
        if(!is_junior($stuId)){
            ajax(retData('403', '你不是萌新，坏人'));
        }
        $result = $this->discuss_model->getUserQues($stuId);
        $this->load->view('searchResult', array('render' => $result));
    }

    public function userReply($stuId) {
        $this->auth();
        if(empty($stuId))
            ajax(retData(404, '请访问正确的用户'));
        if(!is_junior($stuId) || empty($this->discuss_model->isSenior($stuId))){
            ajax(retData('403', '你访问的用户没有回复权限'));
        }
        $result = $this->discuss_model->getReplyQuesByStuId($stuId);
        $this->load->view('searchResult', array('render', $result));
    }

    public function question(){
        $this->auth();
        if(is_junior($_SESSION['userInfo']['stuNum'])){
            $this->load->view('question');
        }else{
            $this->load->view('questionSorry');
        }
    }

    public function search(){
        $this->auth();
        $this->load->view('search');
    }

    public function searchResult($type = 'tag', $query = ""){
        $this->auth();
        if($type == 'tag'){
            $tag = urldecode($query);
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByTag($tag);
            $this->load->view('searchResult', array('render' => $result));
            return;
        }
        if($type == 'word'){
            $word = urldecode($query);
            $this->load->model('discuss_model');
            $result = $this->discuss_model->searchByWord($word);
            $this->load->view('searchResult', array('render' => $result));
            return;
        }
        ajax(retData('404', 'unknown type'));
    }

    public function detail($id){
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
        $this->load->view('detail', array('render' => $result));
    }

    private function getOpenId($code){
        $this->load->helper('string');
        $randomStr = random_string('alnum', 32);
        $timeStamp = time();
        $data = array(
            'string' => $randomStr,
            'token' => $this->token,
            'timestamp' => $timeStamp,
            'secret' => $this->getApiSecret($timeStamp, $randomStr),
            'code' => $code,
        );
        $result = curl_api($this->api['webAuth'], $data);
        $openId = $result->data->openid;
//        $_SESSION['openid'] = $openId;
        return $openId;
    }

    private function isSubscribe($openId){
        $this->load->helper('string');
        $randomStr = random_string('alnum', 32);
        $timeStamp = time();
        $data = array(
            'string' => $randomStr,
            'token' => $this->token,
            'timestamp' => $timeStamp,
            'secret' => $this->getApiSecret($timeStamp, $randomStr),
            'openid' => $openId,
        );
        $result = curl_api($this->api['isSubscribe'], $data);
//        var_dump($result);
        return $result->status == 200?true:false;
    }

    //userType 1 2016级 2 志愿学长 3 其他
    private function loginSuccess($userData) {
        $_SESSION['userInfo'] = object_to_array($userData);
        $_SESSION['isLogin'] = true;
        $this->load->model('senior_model');
        $senior = $this->senior_model->isSenior($userData->stuNum);
        if($senior){
            $_SESSION['userType'] = 2;
            $_SESSION['seniorInfo'] = $senior;
        }else{
            if(is_junior($userData->stuNum)){
                $_SESSION['userType'] = 1;
            }else{
                $_SESSION['userType'] = 3;
            }
            $this->load->model('junior_model');
            $ret = $this->junior_model->checkUserExist($userData->stuNum);
            if(empty($ret)){
                $openId = $_SESSION['openid'];
                $weixinData = $this->getWeiXin($openId);
                $userData->headimgurl = $weixinData->headimgurl;
                $userData->nickname = $weixinData->nickname;
                $ret = $this->junior_model->addUser($userData);
            }
        }
        ajax(retData(200, 'ok'));

    }

    private function getWeiXin($openId) {
        $this->load->helper('string');
        $randomStr = random_string('alnum', 32);
        $timeStamp = time();
        $data = array(
            'string' => $randomStr,
            'token' => $this->token,
            'timestamp' => $timeStamp,
            'secret' => $this->getApiSecret($timeStamp, $randomStr),
            'openid' => $openId,
        );
        $result = curl_api($this->api['getUserInfo'], $data);
        if($result->status != 200)
            return null;
        return $result->data;
    }

    public function test($name='dd'){

    }

    private function getApiSecret($timeStamp, $randomStr) {
        return sha1(sha1($timeStamp).md5($randomStr)."redrock");
    }

    private function getAuthUrl(){
        return sprintf($this->authtUrl, $this->appId, $this->redirectUrl, $this->responseType, $this->scope, $this->state);
    }
}