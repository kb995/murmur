<?php
require_once('../config/app.php');

class Post {

    // プロパティ
    public $post_id;
    public $user_id;
    public $text;
    public $error_msgs = array();


    //　アクセサ
    public function getText() {
        return $this->text;
    }
    public function setText($text) {
        $this->text = $text;
    }
    public function getId() {
        return $this->post_id;
    }
    public function setId($post_id) {
        $this->post_id = $post_id;
    }
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    public function getUserId() {
        $this->user_id = $user_id;
    }


    // ===== データ取得 =====

    // 投稿を一件取得
    public static function getOnePost($post_id) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT * FROM posts WHERE id = :post_id AND delete_flg = 0';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo '例外エラー発生 : ' . $e->getMessage();
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 投稿をページ分取得
    public static function getSomePost($start, $count) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT users.name, posts.id, posts.user_id, posts.text, posts.created_at FROM posts JOIN users ON posts.user_id = users.id WHERE users.delete_flg = 0 AND posts.delete_flg = 0 ORDER BY posts.created_at DESC LIMIT :start, :count';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', $count, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo '例外エラー発生 : ' . $e->getMessage();
            $err_msg['etc'] = 'しばらくしてから再度試してください';
        }
        return $result;
    }

    // ユーザーを指定して投稿をページ文取得
    public static function getPostsById($start, $count, $user_id) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT users.name, posts.id, posts.user_id, posts.text, posts.created_at FROM posts JOIN users ON posts.user_id = users.id WHERE users.delete_flg = 0 AND posts.delete_flg = 0 AND posts.user_id = :user_id ORDER BY posts.created_at DESC LIMIT :start, :count';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', $count, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo '例外エラー発生 : ' . $e->getMessage();
            $err_msg['etc'] = 'しばらくしてから再度試してください';
        }
        return $result;
    }

    // 投稿数取得
    public static function getPostCount($user_id) {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) FROM posts WHERE delete_flg = 0 AND user_id = :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $post_count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $post_count;
    }

    // ===== CRUD =====

    // 投稿保存
    public function save() {
        try {
            $dbh = dbConnect();
            $dbh->beginTransaction();
            $sql = 'INSERT INTO posts ( text, user_id, created_at, updated_at ) VALUE (:text, :user_id,:created_at, :updated_at)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':text', $this->text, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $result = $stmt->execute();
            $dbh->commit();
            return $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $this->error_msgs[] = 'しばらくしてから再度試してください';
        }
    }

    // 投稿削除
    public function delete() {
        try {
            $dbh = dbConnect();
            $dbh->beginTransaction();
            $sql = 'UPDATE posts SET delete_flg = 1, updated_at = :updated_at WHERE id = :post_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':post_id', $this->post_id, PDO::PARAM_STR);
            $result = $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $this->error_msgs[] = 'しばらくしてから再度試してください';
        }
    }

    // 投稿更新
    public function update($post_id) {
        try {
            $dbh = dbConnect();
            $dbh->beginTransaction();
            $sql = 'UPDATE posts SET text = :text, updated_at = :updated_at WHERE id = :post_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':text', $this->text, PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
            $result = $stmt->execute();

            $dbh->commit();

        } catch (PDOException $e) {
            $dbh->rollBack();
            echo 'DB接続エラー発生 : ' . $e->getMessage();
            $error_msg[] = 'しばらくしてから再度試してください';
        }
    }

}