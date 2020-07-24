<?php
require_once('../config/app.php');
// require_once('../models/Follow.php');

class FollowController {

    // フォロー機能
    public function follow($login_id, $user_id) {
        if($this->check_follow($login_id, $user_id)) {
            $sql ='DELETE FROM follow 
                   WHERE :follow_id = follow_id AND :followed_id = followed_id';
        }else{
            $sql ='INSERT INTO follow(follow_id,followed_id) 
                   VALUES(:follow_id,:followed_id)';
        }
        try {
            $dbh = dbConnect();
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':follow_id', $login_id, PDO::PARAM_INT);
            $stmt->bindValue(':followed_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
    }

    // フォローチェック
    public function check_follow($follow_user, $followed_user) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT follow_id,followed_id
                    FROM follow 
                    WHERE follow_id = :follow_id AND followed_id = :followed_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':follow_id', $follow_user, PDO::PARAM_INT);
            $stmt->bindValue(':followed_id', $followed_user, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (PDOException $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
    }

    // フォロー数取得
    public function followCount($user_id) {
        $dbh = dbConnect();
        $sql = "SELECT COUNT(*) 
                FROM follow 
                WHERE follow_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // フォロワー数取得
    public function followedCount($user_id) {
        $dbh = dbConnect();
        $sql = "SELECT COUNT(*) 
                FROM follow 
                WHERE followed_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}