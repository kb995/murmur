<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');
require_once('../controllers/PostController.php');

$user = new UserController;
$post = new PostController;

$login_user = $_SESSION['login_user'];
$post_id = $_GET['post_id'];
$current_post = $post->getCurrentPost($post_id);
echo "<pre>"; var_dump($current_post); echo"</pre>";

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
        <div class="form-controll my-4">
            <!-- エラー表示 -->
            <div class="card"><?php require('./template/error_msgs.php'); ?></div>

            <textarea class="form-control" name="text" cols="30" rows="10"><?php echo $current_post['text']; ?></textarea>

            <div class="text-right my-3">
                <button type="submit" class="btn btn-primary">編集</button>
            </div>
        </div>
    </form>
</main>