<?php
require_once('../config/app.php');
require_once('../model/User.php');
require_once('../validation/UserValidation.php');


class UserController {
    public function all() {
        $user = new User;
        $users = $user->all();
        return $users;
    }

    // ユーザー一件取得
    public function getUser($user_id) {
        $user = new User;
        return $user->getOneUser($user_id);
    }

    // ユーザー登録
    public function new() {
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
        $user->save();
        header("Location: index.php");
        }
    }

    // ログイン
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
                header("Location:index.php");
            }
        }
    }

    // 
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

    //　プロフ 編集
    public function edit($user_id) {
        // バリデーション処理
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

}