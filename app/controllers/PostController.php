<?php
require_once('../config/app.php');
require_once('../models/Post.php');
require_once('../validation/PostValidation.php');

class PostController {

    // * ---------- CRUD ---------- *

    // 新規投稿登録
    public function new() {
        $validation = new PostValidation;
        $data = [
            "text" => $_POST['text'],
        ];
        $validation->setData($data);
        if($validation->checkPost() === false) {
            $_SESSION['error_msgs'] = $validation->getErrorMsgs();
        } else {
            $validate_data = $validation->getData();
            $text = $validate_data['text'];
            $post = new Post;
            $post->setText($text);
            $post->setUserId($_SESSION['login_user']['id']);
            $post->save();
            header("Location: mypage.php");
        }
    }

    // 投稿編集
    public function edit($post_id) {
        $validation = new PostValidation;
        $data = [
            "text" => $_POST['text'],
        ];
        $validation->setData($data);
        if($validation->checkPost() === false) {
            $_SESSION['error_msgs'] = $validation->getErrorMsgs();
        } else {
            $validate_data = $validation->getData();
            $text = $validate_data['text'];
            $post = new Post;
            $post->setText($text);
            $post->update($post_id);
            header("Location: mypage.php");
        }
    }

    // 投稿削除
    public function delete() {
        $post_id = $_POST['post_id'];
        $post = new Post;
        $post->setId($post_id);
        $result = $post->delete();
        if($result === false) {
            $_SESSION['error_msgs'] = '削除に失敗しました';
        }
        header('Location: mypage.php');

    }
    // * ---------- データ取得 ---------- *

    // 最新記事取得
    public function getCurrentPosts($start, $limit) {
        $post = new Post;
        return $data = $post->getPosts($start, $limit);
    }
    // 最新記事取得(ユーザー指定)
    public function getUserPosts($user_id, $start, $limit) {
        $post = new Post;
        return $data = $post->getUserPosts($user_id, $start, $limit);
    }

    // 投稿を一件取得
    public function getCurrentPost($post_id) {
        $post = new Post;
        return $data = $post->getPostById($post_id);
    }

    // 投稿件数を取得
    public function postCount($user_id) {
        $post = new Post;
        return $count =  $post->getPostCount($user_id);
    }

    // ライクしている記事を取得
    public function getLikePost($user_id, $start, $count) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT users.name, posts.id, posts.user_id, posts.text,
            posts.created_at
            FROM posts
            INNER JOIN likes ON posts.id = likes.post_id
            INNER JOIN users ON users.id = posts.user_id
            WHERE likes.user_id = :user_id AND posts.delete_flg = 0
            LIMIT :start, :count';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', $count, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_msgs'] = 'しばらくしてから再度試してください';
        }
        return $result;
    }
}
