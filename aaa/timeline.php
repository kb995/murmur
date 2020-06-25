<?php
require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;


// ログイン有効期限チェック
$user->loginLimit();

// 削除処理
if(isset($_GET['action']) & $_GET['action'] === 'delete') {
    $post->delete();
}

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);

$posts = $post->getSomePost($start, 5);


?>

<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>

<main class="container">
    <h1 class="h3 text-center m-5">TOP</h1>
        <article>
            <?php foreach($posts as $post): ?>
            <div class="w-50 mx-auto card my-3 p-3">
                <!-- <p>投稿ID:<a href="userDetail.php?detail_id=<?php echo $post['user_id']; ?>"><?php echo $post['id']; ?></a></p> -->
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
