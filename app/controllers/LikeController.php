<?php
require_once('../config/app.php');
// require_once('../models/Like.php');

class LikeController {

    public function like($user_id, $post_id) {
        if($this->likeDuplicate($user_id, $post_id)) {
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
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
            $result = $stmt->execute();

        } catch (Exception $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
    }

    // 記事のいいね数取得
    public function getLikeCountByPost($post_id) {
        $dbh = dbConnect();
        $sql = "SELECT COUNT(user_id) 
                FROM likes 
                WHERE post_id = :post_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // ユーザーのいいね数取得
    public function getLikeCountByUser($user_id) {
        $dbh = dbConnect();
        $sql = "SELECT COUNT(*) 
                FROM likes 
                WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // すでにライクしているかチェック
    public function likeDuplicate($user_id, $post_id) {
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