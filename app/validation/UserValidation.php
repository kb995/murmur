<?php

class UserValidation {

    private $data;
    private $error_msgs = array();

    // 値セット
    public function setData($data) {
        $this->data = $data;
    }
    // 値取得
    public function getData() {
        return $this->data;
    }

    // エラー取得
    public function getErrorMsgs() {
        return $this->error_msgs;
    }

    // ユーザー登録時チェック
    public function checkSignup() {
        $email = $this->data['email'];
        $password = $this->data['password'];

        if(empty($email)) {
            $this->error_msgs[] = 'メールアドレスが未入力です';
        }
        if(empty($password)) {
            $this->error_msgs[] = 'パスワードが未入力です';
        }

        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    // プロフ更新時チェック
    public function checkProf() {
        $email = $this->data['email'];
        $name = $this->data['name'];
        $profile = $this->data['profile'];

        if(empty($email)) {
            $this->error_msgs[] = 'メールアドレスが未入力です';
        }

        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }
}