<?php 
require_once('../config/app.php');
require_once('../models/User.php');
require_once('../validation/UserValidation.php');

class UserController {

    // * ---------- CRUD ---------- *

    // 新規ユーザー登録
    public function new() {
        $validation = new UserValidation;
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        ];
        $validation->setData($data);

        if($validation->checkSignup() === false) {
            $_SESSION['error_msgs'] = $validation->getErrorMsgs();

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


    // * ---------- データ取得 ---------- *

    public function getOneUser($user_id) {
        $user = new User;
        return $data = $user->getUserById($user_id);
    }

    // * ---------- 認証 ---------- *

    // ログイン処理
    public function login() {
        $validation = new UserValidation;
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        ];
        $validation->setData($data);

        if($validation->checkSignup() === false) {
            $_SESSION['error_msgs'] = $validation->getErrorMsgs();
        } else {
            $user = new User;
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->authUser($data['email'], $data['password']);

            header("Location: mypage.php");
        }
    }

        // ログイン有効期限期限チェック
        public function loginLimit() {
            if (!empty($_SESSION['login_flg'])) { // TODO:新規登録後はスキップ
                if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
                    $_SESSION['error_msgs'] = 'ログイン有効期限切れです';
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

        // ログインユーザーの投稿かの確認
        public function checkUserType($login_user, $check_user) {
            if($login_user === $check_user) {
                return true;
            } else {
                return false;
            }
        }

    // * ---------- フォロー機能 ---------- *


}