<?php
require_once('../model/Like.php');

class LikeController {

    public function like($login_user, $post_id) {

        if($this->likeDuplicate($login_user, $post_id)) {
            $sql = 'DELETE FROM likes
                    WHERE :user_id = user_id 
                    AND :post_id = post_id';
        }else{
            $sql = 'INSERT INTO likes(user_id, post_id) 
                    VALUES(:user_id, :post_id)';
            }
        try{
            $dbh = dbConnect();
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $login_user, PDO::PARAM_STR);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
            $result = $stmt->execute();

        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
        }
    }

    public function getLikeCount($post_id) {
        $dbh = dbConnect();
        $sql = "SELECT COUNT(user_id) 
                FROM likes 
                WHERE post_id = :post_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();

    }

    // すでにライクしているかチェック
    public function likeDuplicate($user_id,$post_id) {
        $dbh = dbConnect();
        $sql = 'SELECT * 
                FROM likes WHERE user_id = :user_id 
                AND post_id = :post_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
        if($data) {
            return true;
        }else{
            return false;
        }
    }
}