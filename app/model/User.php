<?php
require_once('../config/app.php');

class User {

    // プロパティ
    public const DEFAULT_IMG = '';

    public $user_id;
    public $email;
    public $password;
    public $name;
    public $profile;
    public $thumbnail;

    public $count_data = array();
    public $error_msgs = array();

    // アクセサメソッド
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getProfile() {
        return $this->profile;
    }
    public function setProfile($profile) {
        $this->profile = $profile;
    }

    // ===== データ取得 =====

    // ユーザーを全件取得
    public function all() {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM users ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ユーザーを一件取得
    public function getOneUser($user_id) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT * 
                    FROM users 
                    WHERE id = :user_id AND delete_flg = 0';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo '例外エラー発生 : ' . $e->getMessage();
            $error_msgs[] = 'しばらくしてから再度試してください';
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ライク数取得
    public static function getLikeCount($user_id) {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) 
                FROM likes 
                WHERE user_id = :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $like_count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $like_count;
    }

    // フォロー数取得
    public static function getFollowCount($user_id) {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) 
                FROM follow 
                WHERE follow_id = :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $follow_count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $follow_count;
    }

    // フォロワー数取得
    public static function getFollowedCount($user_id) {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) 
                FROM follow 
                WHERE followed_id = :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $followed_count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $followed_count;
    }

    // ===== CRUD =====

    // ユーザー登録
    public function save() {
        try {
            $dbh = dbConnect();
            $dbh->beginTransaction();
            $sql = 'INSERT INTO users (email, password, name, created_at, updated_at) 
                    VALUE (:email, :password, :name, :created_at, :updated_at)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $result = $stmt->execute();
            $dbh->commit();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $error_msgs['etc'] = 'しばらくしてから再度試してください';
        }
    }

    // プロフィール更新
    public function update($user_id) {
        try {
            $dbh = dbConnect();
            $dbh->beginTransaction();
            $sql = 'UPDATE users 
                    SET email = :email, name = :name, profile = :profile, updated_at = :updated_at 
                    WHERE id = :user_id';

            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':profile', $this->profile, PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $result = $stmt->execute();
            $dbh->commit();

        } catch (PDOException $e) {
            $dbh->rollBack();
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $error_msg[] = 'しばらくしてから再度試してください';
        }
    }

    // ===== 認証 =====

    // ログイン認証
    public function authUser($email, $password) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT id,email,password 
                    FROM users 
                    WHERE email = :email 
                    AND delete_flg = 0';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password, $result['password'])) {
                $session_default_limit = 60 * 60;
                $_SESSION['login_user'] = $result;
                $_SESSION['login_flg'] = true;
                $_SESSION['login_date'] = time();
                $_SESSION['login_limit'] = $session_default_limit;

            } else {
                $error_msg['password'] = 'メールアドレスかパスワードが間違っています';
            }

        } catch (PDOException $e) {
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $error_msg['etc'] = 'しばらくしてから再度試してください';
        }
    }
}