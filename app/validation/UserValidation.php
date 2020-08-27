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

        if(empty($email)) {
            $this->error_msgs[] = 'メールアドレスが未入力です';
        }
        if(empty($password)) {
            $this->error_msgs[] = 'パスワードが未入力です';
        }


        // email重複チェック
        try {
            $dbh = dbConnect();
            $sql = 'SELECT email
                    FROM users
                    WHERE email = :email AND delete_flg = 0';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $db_email = $stmt->fetch(PDO::FETCH_ASSOC);
            if($db_email['email'] === $email){
                $this->error_msgs[] = 'そのメールアドレスは既に登録されています';
            }
        } catch (PDOException $e) {
            $this->error_msgs[] = 'しばらくしてから再度試してください';
        }


        if(count((array)$this->error_msgs) > 0) {
            return false;
        }
        return true;
    }
    // ログイン時
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

    // プロフ更新時チェック
    public function checkProf() {
        $email = $this->data['email'];
        $name = $this->data['name'];
        $profile = $this->data['profile'];

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
}
