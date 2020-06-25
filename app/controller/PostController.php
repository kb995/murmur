<?php
require_once('../model/Post.php');
require_once('../validation/PostValidation.php');

class PostController {

// 全件取得
// public function all() {
//     $dbh = dbConnect();
//     $sql = 'SELECT * FROM posts WHERE delete_flg = 0';
//     $stmt = $dbh->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

// 投稿 ページ分
public function getSomePost($start, $count) {
    $post = new Post;

    return $post =  Post::getSomePost($start, $count);
}


// 投稿 個別取得
public function getPost($post_id) {
    $post = new Post;
    return $post =  Post::getOnePost($post_id);
}


//　投稿 登録
public function new() {
        // バリデーション処理
        $validation = new PostValidation;
        $data = [
            "text" => $_POST['text'],
        ];
        $validation->setData($data);

        if($validation->checkPost() === false) {
            $error_msgs = $validation->getErrorMsgs();
            $_SESSION['error_msgs'] = $error_msgs;
            
        } else {
            $validate_data = $validation->getData();
            $text = $validate_data['text'];

            $post = new Post;
            $post->setText($text);
            $post->setUserId($_SESSION['login_user']['id']);
            $post->save();
        }
    }
    
    public function delete() {
        $post_id = $_GET['post_id'];

        $post = Post::getOnePost($post_id);
        echo "<pre>"; var_dump($post); echo"</pre>";
        if(!isset($post)) {
            header('Location: index.php');
        }
        $post = new Post;
        $post->setId($post_id);
        $result = $post->delete();
        if($result === false) {
            $_SESSION['error_msgs'] = '削除に失敗しました';
        }
        header('Location: index.php');
    }

    //　投稿 編集
    public function edit($post_id) {
        // バリデーション処理
        $validation = new PostValidation;
        $data = [
            "text" => $_POST['text'],
        ];
       
        $validation->setData($data);

        if($validation->checkPost() === false) {
            $error_msgs = $validation->getErrorMsgs();
            $_SESSION['error_msgs'] = $error_msgs;
            
        } else {
            $validate_data = $validation->getData();
            $text = $validate_data['text'];

            $post = new Post;
            $post->setText($text);
            $post->update($post_id);
        }
    }

    // 自分の投稿取得 旧getMySomePost
    public function getPostsById($start, $count, $user_id) {
        $post = new Post;
        return $post =  Post::getPostsById($start, $count, $user_id);
    }
    // 自分の投稿数取得
    public function PostCount($user_id) {
        $post = new Post;
        return $count =  Post::getPostCount($user_id);
    }
}