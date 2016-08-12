<?php
/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/11 0011
 * Time: 15:08
 */

/**
 * @param string $url
 * @param string $data
 * @return mixed
 */
function curl_api($url, $data = ''){
    // 初始化一个curl对象
    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    // 运行curl，获取网页。
    $contents = json_decode(curl_exec($ch));
    // 关闭请求
    curl_close($ch);
    return $contents;
}

/**
 * @param array|object $data
 */
function ajax($data){
    if(!headers_sent()){
        header('Content-Type: application/json');
    }
    echo json_encode($data);
    exit;
}

/**
 * @param $data
 * @param bool $is_exit
 */
function dump($data, $is_exit = false){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    $is_exit && exit;
}

/**
 * @param $code
 * @param string $msg
 * @return array
 */
function retData($code, $msg = ''){
    return array('status' => $code, 'msg' => $msg);
}

/**
 * 把数组里的指定下标的提取出来
 * @param array $needle
 * @param array $data
 * @return array
 */
function array_vo(array $needle, array $data){
    $result = array();
    foreach($needle as $value){
        if(is_string($value) && key_exists($value, $data))
            $result[$value] = $data[$value];
    }
    return $result;
}

/**
 * 把数组里的指定字段转换成要存入的数据库字段
 * @param array $rule
 * @param array $data
 * @return array
 */
function array_to_db(array $rule, $data){
    $result = array();
    foreach ($rule as $key => $value){
        if(is_string($key) && key_exists($key, $data) && is_string($value)){
            $result[$value] = $data[$key];
        }
    }
    return $result;
}

/**
 * 简单对像变成数组
 * @param $obj
 * @return array
 */
function object_to_array($obj){
    $arr = array();
    foreach ($obj as $key => $value){
        $arr[$key] = $value;
    }
    return $arr;
}

/**
 * 判断是否是正整数
 * @param $num
 * @return bool
 */
function is_pos_int($num){
    $pattern = '/^[1-9]\d*$/';
    $ret = preg_match($pattern, $num);
    return $ret?true:false;
}

/**
 * @param $name
 * @return string
 */
function param($name){
    return htmlspecialchars($name);
}

/**
 * 把通过base64上传的图片截取base64前缀
 * @param $data
 * @return string
 */
function get_base_upload($data){
    $prefix = 'data:image/png;base64,';
    return substr($data, strlen($prefix) - 1);
}

function get_user_group(){

}