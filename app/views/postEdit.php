<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');
require_once('../controllers/PostController.php');

$user = new UserController;
$post = new PostController;

$login_user = $_SESSION['login_user'];
$post_id = $_GET['post_id'];
$current_post = $post->getCurrentPost($post_id);

// 記事編集処理
if($_POST) {
    $post->edit($current_post['id']);
}
?>

<?php
$pageTitle = '投稿編集';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container my-5">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-5">投稿編集</h1>
        <d class="form-controll my-4">
            <!-- エラー表示 -->
            <?php require('./template/error_msgs.php'); ?>

            <textarea id="comment" class="form-control" name="text" cols="30" rows="10"><?php echo h($current_post['text']); ?></textarea>

            <div class="text-right my-3">
                <button type="submit" class="post_btn">編集</button>
            </div>
            <span class="post_count">残り文字数 <span id="label">0</span>/300</span>

        </div>
    </form>
</main>

<?php
require_once('./template/footer.php')
?>
