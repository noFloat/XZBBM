<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/12 0012
 * Time: 0:11
 */
class Senior_model extends CI_Model{

    private $table = 'senior';

    public function isSenior($stuId){
        $result = $this->db->get_where($this->table, array('stu_id' => $stuId));
        return $result->row();
    }
}