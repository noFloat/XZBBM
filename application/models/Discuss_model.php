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
        $result = $this->db->get_where($this->table, array('pid' => 0));
//        dump($this->db->get_compiled_select($this->table));
        return $this->filter($result->result_array());
    }

    public function searchByWord($word){
        $like = array('content' => $word);
        $this->db->like($like);
        $this->db->order_by('create_time', 'DESC');
        $result = $this->db->get_where($this->table, array('pid' => 0));
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

    public function likeMgr($id){
        $discuss = $this->getById($id);
        if(empty($discuss) || $discuss['pid'] == 0){
            return false;
        }
        $stuId = $_SESSION['userInfo']['stuNum'];
        if(empty($discuss['like_it'])){
            $like_set = array();
        }else{
            $like_set = explode(',', $discuss['like_it']);
        }
        if(in_array($stuId, $like_set)){
            $like_set_op = array_flip($like_set);
            unset($like_set_op[$stuId]);
            $like_set = array_flip($like_set_op);
        }else{
            $like_set[] = $stuId;
        }
        $this->db->where(array('id' => $id));
        $this->db->update($this->table, array('like_it' => implode(',', $like_set)));
        return $this->getLikeCount($id);
    }

    public function showQuestion($id){
        $result = array();
        $question = $this->getById($id);
        if(empty($question)){
            return null;
        }
        if($question['pid'] != 0){
            return null;
        }
        $question_arr = $this->filter(array($question));
        $result['question'] = $question_arr[0];
        $result['comment'] = $this->getComment($id);
        return $result;
    }

    public function showUser($stuId){

        if(!$this->isSenior($stuId)){
            $result = $this->db->get_where('junior', array('stu_id' => $stuId));
            $user = $result->row_array();
            if(empty($user))
                return null;
            $questions = $this->getQuestionByStuId($stuId);
            $user['question_count'] = count($questions);
            $replies = $this->getReplyStuId($stuId);
            $user['reply_count'] = count($replies);
            $user['is_senior'] = false;
        }else{
            $result = $this->db->get_where('senior', array('stu_id' => $stuId));
            $user = $result->row_array();
            if(empty($user))
                return null;
            $user['is_senior'] = true;
            $replies = $this->getReplyStuId($stuId);
            $user['reply_count'] = count($replies);
        }
        $user['is_junior'] = is_junior($stuId);
        return $user;
    }

    public function getLikeCount($id){
        $discuss = $this->getById($id);
        if(empty($discuss) || $discuss['pid'] == 0){
            return false;
        }
        if(empty($discuss['like_it'])){
            return 0;
        }else{
            $like_set = explode(',', $discuss['like_it']);
            return count($like_set);
        }
    }

    private function filter($result){
        $result_f = array();
        foreach ($result as $value){
            //$value['commentCount'] = $this->getCommentCount($value['Id']);
            $resultUser = $this->db->get_where('junior', array('stu_id' => $value['author_id']));
            $userInfo = $resultUser->row_array();
            if(empty($userInfo)){
                $resultUser = $this->db->get_where('senior', array('stu_id' => $value['author_id']));
                $userInfo = $resultUser->row_array();
                $userType = 2;
            }else{
                $userType = 1;
            }
            if($userType == 1){
                $value['headImg'] = $userInfo['head_url'];
                $value['name'] = $userInfo['nick_name'];
                $value['gender'] = $userInfo['gender'];
            }else{
                $value['headImg'] = $userInfo['photo'];
                $value['name'] = $userInfo['name'];
                $value['gender'] = $userInfo['sex'];
            }
            $value['pic_name'] = explode("#", $value['pic_name']);
            $value['tag'] = explode(",", $value['tag']);
            $value['time'] = formatTime(strtotime($value['create_time']));
            $value['is_like'] = in_array($_SESSION['userInfo']['stuNum'], explode(',', $value['like_it']))?true:false;
            $result_f[] = $value;
        }
        return $result_f;
    }

    private function getComment($id){
        $where = array('pid' => $id);
        $this->db->order_by('create_time', 'DESC');
        $result = $this->db->get_where($this->table, $where);
        return $this->filter($result->result_array());
    }

    private function getById($id){
        $result = $this->db->get_where($this->table, array('id' => $id));
        return $result->row_array();
    }

    private function getByStuId($stuId){
        $result = $this->db->get_where($this->table, array('author_id' => $stuId));
        return $result->result_array();
    }

    private function getQuestionByStuId($stuId){
        $result = $this->db->get_where($this->table, array('author_id' => $stuId, 'pid' => 0));
        return $result->result_array();
    }
    private function getReplyStuId($stuId){
        $result = $this->db->get_where($this->table, array('author_id' => $stuId, 'pid >' => 0));
        return $result->result_array();
    }

    public function isSenior($stuId){
        $result = $this->db->get_where('senior', array('stu_id' => $stuId));
        return $result->row();
    }

    private function getCommentCount($id){
        return count($this->getComment($id));
    }

}