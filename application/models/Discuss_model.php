<?php

/**
 * Created by PhpStorm.
 * User: Nobup
 * E-mail: mail@vekwu.com
 * Date: 2016/8/12 0012
 * Time: 13:40
 */
class Discuss_model extends CI_Model{

    private $table = 'discuss';

    public function add($data){
        $ret = $this->db->insert($this->table, $data);
        $this->incReplyCount($data['pid']);
        //dump($ret);
    }

    public function incReplyCount($id){
        $this->db->where(array('id' => $id));
        $ques = $this->db->get($this->table)->row_array();
        $this->db->update($this->table, array('reply_count' => ++$ques['reply_count']));
    }

    public function searchByTag($tag){
        $like = array('tag' => $tag);
        $this->db->like($like);
        $this->db->order_by('create_time', 'DESC');
        $result = $this->db->get($this->table);
//        dump($this->db->get_compiled_select($this->table));
        return $result->result_array();
    }

    public function searchByWord($word){
        $like = array('content' => $word);
        $this->db->like($like);
        $this->db->order_by('create_time', 'DESC');
        $result = $this->db->get($this->table);
//        dump($this->db->get_compiled_select($this->table));
        return $this->filter($result->result_array());
    }

    public function getByNew($page, $limit){
        $this->db->limit(($page - 1) * $limit, $page * $limit);
        $this->db->order_by('create_time');
        $result = $this->db->get_where($this->table, array('pid' => 0));
        return $this->filter($result->result_array());
    }

    public function getByHot($page, $limit) {
        $this->db->limit(($page - 1) * $limit, $page * $limit);
        $this->db->order_by('create_time desc, reply_count desc');
        $result = $this->db->get_where($this->table, array('pid' => 0));
        return $this->filter($result);
    }

    private function filter($result){
        $result_f = array();
        foreach ($result as $value){
            if($value['pid'] == 0){
                $value['commentCount'] = $this->getCommentCount($value['id']);
                $resultUser = $this->db->get_where('junior', array('stu_id' => $value['author_id']));
                $userInfo = $resultUser->row_array();
                $value['headImg'] = $userInfo['head_url'];
                $value['name'] = $userInfo['nick_name'];
                $result_f[] = $value;
            }
        }
        return $result_f;
    }

    private function getComment($id){
        $where = array('pid' => $id);
        $this->db->order_by('create_time', 'DESC');
        $result = $this->db->get_where($this->table, $where);
        return $result->result_array();
    }

    private function getCommentCount($id){
        return count($this->getComment($id));
    }

}