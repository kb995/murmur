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
    // * ---------- データ取得 ---------- *

    // 最新記事取得
    public function getCurrentPosts($start, $limit) {
        $post = new Post;
        return $data = $post->getAllPosts($start, $limit);
    }

    // 投稿を一件取得
    public function getCurrentPost($post_id) {
        $post = new Post;
        return $data = $post->getPostById($post_id);
    }

}