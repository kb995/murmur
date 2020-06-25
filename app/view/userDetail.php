<?php


require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;
$login_user = $user->getUser($_SESSION['login_user']['id']);
$user_detail = $user->getUser($_GET['user_id']);
// echo "<pre>"; var_dump($_SESSION); echo"</pre>";
// echo "<pre>"; var_dump($login_user); echo"</pre>";

// ログイン有効期限チェック
$user->loginLimit();

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);
$post_count = $post->PostCount($_GET['user_id']);

$posts = $post->getPostsById($start, 5, $user_detail['id']);
echo "<pre>"; var_dump($user_detail); echo"</pre>";
// echo "<pre>"; var_dump($_SESSION); echo"</pre>";



?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h2 class="text-center h3">
    <?php if(empty($user_detail['name'])) {
        echo '名無し';
    } else {
        echo $user_detail['name'];
    }
    ?>
    さんのページ
    </h2>
    <div class="card p-5 my-5">
        <p><?php echo $user_detail['id'] ?></p>
        <p><?php echo $user_detail['email'] ?></p>
        <p><?php echo $user_detail['password'] ?></p>
        <p><?php echo $user_detail['created_at'] ?></p>
        <div>
            <button class="btn btn-primary">フォローする</button>
        </div>
    </div>

    <article>
        <h2 class="text-center h3">
        <?php
        if(empty($user_detail['name'])) {
            echo '名無し';
        } else {
            echo $user_detail['name'];
        }
        ?>
        さんの投稿
        </h2>
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
