<?php 
require_once('../config/app.php');
require_once('../controllers/PostController.php');
require_once('../controllers/UserController.php');

$post = new PostController;
$user = new UserController;

// ページ情報取得
$login_user = $_SESSION['login_user'];
$login_user = $user->getOneUser($_SESSION['login_user']['id']);
$current_posts = $post->getCurrentPosts(0, 3);

// 投稿処理
if(!empty($_POST) && $_POST['action'] == 'new') {
    $result = $post->new();
}

// 投稿処理
if(!empty($_POST) && $_POST['action'] == 'delete') {
    $result = $post->delete();
}

?>

<?php
$pageTitle = 'マイページ';
require_once('./template/head.php');
require_once('./template/header.php');

?>

<main class="container mb-5">
    <h1 class="text-center my-5">mypage</h1>
    <div class="row">
        <div class="col-4">
            <?php require('./template/myProfCard.php'); ?>
            <?php require('./template/post.php'); ?>
        </div>
        <div class="col-8">
            <?php require('./template/timeline.php'); ?>
        </div>
    </div>
</main>

<?php 
require_once('./template/footer.php')
?>

