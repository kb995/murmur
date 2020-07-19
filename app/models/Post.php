<?php
require_once('../config/app.php');

class Post {

    // * ---------- プロパティ ---------- *

    public $post_id;
    public $user_id;
    public $text;
    public $error_msgs = array();

    // * ---------- アクセサ ---------- *

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

    // * ---------- CRUD ---------- *

    // 投稿保存
    public function save() {
        try {
            $dbh = dbConnect();
            $sql = 'INSERT INTO posts ( text, user_id, created_at, updated_at ) 
                    VALUE (:text, :user_id,:created_at, :updated_at)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':text', $this->text, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $result = $stmt->execute();
            return $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
    }

    // 投稿更新
    public function update($post_id) {
        try {
            $dbh = dbConnect();
            $sql = 'UPDATE posts 
                    SET text = :text, updated_at = :updated_at 
                    WHERE id = :post_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':text', $this->text, PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
            $result = $stmt->execute();

        } catch (PDOException $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
    }

    // * ---------- データ取得 ---------- *

    // 投稿を指定分取得
    public function getAllPosts($start, $limit) {
            try {
                $dbh = dbConnect();
                $sql = 'SELECT *, posts.id
                        FROM posts 
                        JOIN users ON posts.user_id = users.id
                        WHERE users.delete_flg = 0 AND posts.delete_flg = 0 
                        ORDER BY posts.created_at DESC LIMIT :start, :limit';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
            }
            return $result;
        }

        // 投稿を一件取得
        public function getPostById($post_id) {
            try {
                 $dbh = dbConnect();
                $sql = 'SELECT * 
                        FROM posts 
                        WHERE id = :post_id';
                 $stmt = $dbh->prepare($sql);
                 $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
                 $stmt->execute();
                 $result = $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
            }
            return $result;
        }
    }

