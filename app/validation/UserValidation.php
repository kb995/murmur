<?php

class UserValidation {

    public $data;
    public $error_msgs = array();

    public function setData($data) {
        $this->data = $data;
    }
    public function getData() {
        return $this->data;
    }
    public function getErrorMsgs() {
        return $this->error_msgs;
    }

    // ユーザー登録時
    public function checkSignup() {
        $email = $this->data['email'];
        $password = $this->data['password'];
        $error_msgs = $_SESSION['error_msgs'];

        if(empty($email)) {
            $_SESSION['error_msgs'] = 'メールアドレスが未入力です';
        }
        if(empty($password)) {
            $_SESSION['error_msgs'] = 'パスワードが未入力です';
        }

        if(count($error_msgs > 0)) {
            return false;
        }
        return true;
    }
    // ログイン時 ====================> 完成形
    public function checkLogin() {
        $email = $this->data['email'];
        $password = $this->data['password'];

        if(empty($email)) {
             $this->error_msgs[] = 'メールアドレスが未入力です';
        }
        if(empty($password)) {
            $this->error_msgs[] = 'パスワードが未入力です';
        }

        if(count((array)$this->error_msgs) > 0) {
            return false;
        }
        return true;
    }
// ========================================================
    // プロフ更新時チェック
    public function checkProf() {
        $email = $this->data['email'];
        $name = $this->data['name'];
        $profile = $this->data['profile'];

        if(empty($email)) {
            $_SESSION['error_msgs'] = 'メールアドレスが未入力です';
        }

        // if(count((array)$this->error_msgs) > 0) {
            // return false;
        // }
        return true;
    }
}
