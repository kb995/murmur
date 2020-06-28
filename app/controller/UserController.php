<?php
require_once('../config/app.php');
require_once('../model/User.php');
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

    // ライク数を取得
    public function LikeCount($user_id) {
        return $count =  User::getLikeCount($user_id);
    }
    // フォロー数取得
    public function followCount($user_id) {
        return $count =  User::getFollowCount($user_id);
    }
    // フォロワー数取得
    public function followedCount($user_id) {
        return $count =  User::getFollowedCount($user_id);
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
        }
    }

    //　プロフプロフィールを更新する
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

            if($_SESSION['login_flg']) {
            }
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
                    header("Location: index.php");
                  }
            }
        } else {
            header('Location: login.php');
        }
    }

    

}