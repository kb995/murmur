<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;

$pageTitle = 'フォローリスト';

$user->loginLimit();

// ユーザーデータ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);
$user_detail = $user->getUser($_GET['user_id']);

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);

// ページ遷移元で条件分岐
if(!empty($_GET['page']) && $_GET['page'] === 'self') {
    $posts = $post->getPostsById($start, 5, $login_user['id']);
    $count_data = $user->countData($login_user['id']);

} elseif (!empty($_GET['page']) && $_GET['page'] === 'other') {
    // カウントデータ取得
    $count_data = $user->countData($user_detail['id']);
    $posts = $post->getPostsById($start, 5, $user_detail['id']);
}
