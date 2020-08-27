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
        $result = $user->save();

        // $this->login();

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
            "thumbnail" => $_FILES['image']['name']
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
            $thumbnail = $_SESSION['image']['name'];

            $user = new User;
            $user->setName($name);
            $user->setEmail($email);
            $user->setProfile($profile);
            $user->setThumbnail($thumbnail);
            $user->update($user_id);
            // header("Location: mypage.php");
        }
    }

    // 退会処理
    public function withdraw($user_id) {

        $user = new User;
        try {
            $dbh =  dbConnect();
            $sql = 'UPDATE users
                    SET delete_flg = 1
                    WHERE id = :user_id';
            $data = array(':user_id' => $user_id);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            if($stmt) {
                $_SESSION = array();
                session_destroy();
                header('Location: login.php');
            }

        } catch(Exception $e) {
            echo '例外エラー発生 : ' . $e->getMessage();
            $err_msg['etc'] = 'しばらくしてから再度試してください';
        }

        header("Location: login.php");
    }



    // * ---------- データ取得 ---------- *

    public function getOneUser($user_id) {
        $user = new User;
        return $data = $user->getUserById($user_id);
    }
    public function showThumbnail($user_id) {
        $user = new User;
        $thumbnail = $user->getThumbnail($user_id);
        if(!empty($thumbnail)) {
            return $thumbnail;
        }
        else {
            return 'default_img';
        }
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

        if($validation->checkLogin() === false) {
            // バリデーションチェックがクリアならユーザー認証
            $_SESSION['error_msgs'] = $validation->getErrorMsgs();
        } else {
            $user = new User;
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->authUser($data['email'], $data['password']);
            if(isset($_SESSION['login_flg']) && $_SESSION['login_flg'] === true) {
                header("Location: mypage.php");
            }
        }

    }

        // ログイン有効期限期限チェック
        public function loginLimit() {
            if (!empty($_SESSION['login_flg'])) { // TODO:新規登録後はスキップ
                if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
                    $_SESSION['error_msgs'][] = 'ログイン有効期限切れです';
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
}
