<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;
$login_user = $user->getUser($_SESSION['login_user']['id']);
echo "<pre>"; var_dump($login_user['id']); echo"</pre>";

// ログイン有効期限チェック
$user->loginLimit();

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);
$posts = $post->getSomeMyPost($start, 5, $login_user['id']);
$post_count = $post->myPostCount($login_user['id']);
echo "<pre>"; var_dump($post_count); echo"</pre>";


?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h2 class="text-center h3">プロフィール</h2>
    <div class="card p-5 my-5">
        <p><?php echo $login_user['id'] ?></p>
        <p><?php echo $login_user['email'] ?></p>
        <p><?php echo $login_user['password'] ?></p>
        <p><?php echo $login_user['created_at'] ?></p>
    </div>
    <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-secondary">プロフィール編集する</a>
    <a class="text-danger" href="withdraw.php">退会する</a>

    <article>
        <h2 class="text-center h3">自分の投稿</h2>
        <div>投稿数 : <?php echo $post_count['COUNT(*)']; ?></div>
        <?php foreach($posts as $post): ?>
            <div class="w-50 mx-auto card my-5 p-4">
                <p>投稿ID:<?php echo $post['id']; ?></p>
                <p>投稿日:<?php echo $post['created_at']; ?></p>
                <p>投稿ユーザー:<?php echo $post['user_id']; ?></p>
                <p><a href="detail.php?post_id=<?php echo $post['id']; ?>"><?php echo $post['text']; ?></a></p>
            </div>
        <?php endforeach; ?>
    </article>
<!-- ページング -->
<?php require_once('paging.php'); ?>
</main>

<?php require_once('footer.php'); ?>
