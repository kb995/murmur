<?php
require_once('../config/app.php');
require_once('../model/User.php');
require_once('../controller/PostController.php');
require_once('../validation/UserValidation.php');


class UserController {

    // ===== データ取得 =====

    // すべてのユーザーを取得
    public function all() {
        $user = new User;
        $users = $user->all();
        return $users;
    }

    // IDからユーザーを一件取得
    public function getUser($user_id) {
        $user = new User;
        return $user->getOneUser($user_id);
    }

    // カウントデータ取得
    public function countData($user_id) {
        $user = new User;
        $post = new Post;

        $user->count_data['post'] = $post->getPostCount($user_id);
        $user->count_data['like'] = $user->getLikeCount($user_id);
        $user->count_data['follow'] = $user->getFollowCount($user_id);
        $user->count_data['followed'] = $user->getFollowedCount($user_id);
        
        return $user->count_data;
    }

    // ===== CRUD =====

    // 新しいユーザーを登録
    public function new() {
        $validation = new UserValidation;
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        ];
        $validation->setData($data);

        if($validation->checkSignup() === false) {
            $error_msgs = $validation->getErrorMsgs();
            $_SESSION['error_msgs'] = $error_msgs;
        } else {
        $user = new User;
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setPassword($data['password']);
        $user->save();
        header("Location: mypage.php");

        }
    }

    //　プロフィールを更新する
    public function edit($user_id) {
        $validation = new UserValidation;
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "profile" => $_POST['profile'],
        ];
        $validation->setData($data);

        if($validation->checkProf() === false) {
            $error_msgs = $validation->getErrorMsgs();
            $_SESSION['error_msgs'] = $error_msgs;
        } else {
            $validate_data = $validation->getData();
            $name = $validate_data['name'];
            $email = $validate_data['email'];
            $profile = $validate_data['profile'];

            $user = new User;
            $user->setName($name);
            $user->setEmail($email);
            $user->setProfile($profile);
            $user->update($user_id);
            header("Location: mypage.php");
        }
    }

    // ===== 認証 =====

    // ログインする
    public function login() {
        $validation = new UserValidation;
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        ];
        $validation->setData($data);

        if($validation->checkSignup() === false) {
            $error_msgs = $validation->getErrorMsgs();
            $_SESSION['error_msgs'] = $error_msgs;
        } else {
            $user = new User;
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->authUser($data['email'], $data['password']);
            header("Location: mypage.php");
        }
    }

    // ログイン期限を確認する
    public function loginLimit() {
        if (!empty($_SESSION['login_flg'])) {
            if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
                $error_msg['etc'] = 'ログイン有効期限切れです';
                session_destroy();
                header('Location: login.php');

            } else {
                $_SESSION['login_date'] = time();
                if(basename($_SERVER['PHP_SELF']) === 'login.php'){
                    header("Location: mypage.php");
                  }
            }
        } else {
            header('Location: login.php');
        }
    }

    // ===== フォロー機能 =====
    public function follow($login_user, $user_detail) {
        if($this->check_follow($login_user, $user_detail)) {
            $sql ='DELETE FROM follow 
                   WHERE :follow_id = follow_id AND :followed_id = followed_id';
        }else{
            $sql ='INSERT INTO follow(follow_id,followed_id) 
                   VALUES(:follow_id,:followed_id)';
        }
        try {
            $dbh = dbConnect();
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':follow_id', $login_user, PDO::PARAM_INT);
            $stmt->bindValue(':followed_id', $user_detail, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $this->error_msgs[] = 'しばらくしてから再度試してください';
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
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $this->error_msgs[] = 'しばらくしてから再度試してください';
        }
}
}