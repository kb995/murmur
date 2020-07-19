<?php 
require_once('../config/app.php');
require_once('../controllers/PostController.php');
require_once('../controllers/UserController.php');

$post = new PostController;
$user = new UserController;

$login_user = $_SESSION['login_user'];
$current_user = $user->getOneUser($_GET['user_id']);
$current_posts = $post->getUserPosts($current_user['id'], 0, 3);

?>

<?php
$pageTitle = 'ユーザー投稿詳細';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container mb-5">
    <h1 class="text-center my-5"><?php echo $current_user['name']; ?> の投稿一覧</h1>
    <div class="w-50 mx-auto">
        <article class="card p-5 mb-5 mx-auto">
            <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
            <!-- プロフィール -->
            <!-- TODO:サムネイル(仮) -->
            <!-- TODO:各リンク -->
            <!-- カウント取得 -->
            <!-- ユーザー情報取得 -->
            <div class="m-auto" style="width:150px;height:150px;background-color:gray;"></div>
            <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo $current_user['name']; ?></a></p>
            <p><?php echo $current_user['profile']; ?></p>

            <!-- カウント表示 -->
            <div class="my-3 row">
                <a class="col-6 block count_btn" href="#">
                    <p class="text-center text-muted">投稿数</p>
                    <p class="text-center h4">10<?php // echo $count_data['post']['COUNT(*)']; ?></p>
                </a>
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">いいね</p>
                    <p class="text-center h4">10<?php //echo $count_data['like']['COUNT(*)']; ?></p>
                </a>
            </div>
            <div class="my-3 row">
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロー</p>
                    <p class="text-center h4">10<?php //echo $count_data['follow']['COUNT(*)']; ?></p>
                </a>
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロワー</p>
                    <p class="text-center h4">10<?php //echo $count_data['followed']['COUNT(*)']; ?></p>
                </a>
            </div>
        </article>
        
        <?php require('./template/timeline.php'); ?>
    </div>
</main>

