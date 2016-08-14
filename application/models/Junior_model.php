<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/11 0011
 * Time: 20:30
 */
class Junior_model extends CI_Model{

    private $table = 'junior';

    public function __construct() {
        parent::__construct();
    }

    public function checkUserExist($stuNum){
        $result = $this->db->get_where($this->table, array('stu_id' => $stuNum));
        return $result->row();
    }

    public function addUser($user){
        $userArr = object_to_array($user);
        $needle = array('stuNum' => 'stu_id', 'name' => 'name', 'gender' => 'gender', 'classNum' => 'class_num',
            'major' => 'major', 'college' => 'college', 'grade' => 'grade', 'headimgurl' => 'head_url', 'nickname' => 'nick_name');
        $userVo = array_to_db($needle, $userArr);
        $userVo['stu_id'] = trim($userVo['stu_id']);
        $userVo['gender'] = trim($userVo['gender']);
        $userVo['grade'] = trim($userVo['grade']);
        return $this->db->insert($this->table, $userVo);
    }


}