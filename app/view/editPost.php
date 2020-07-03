<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;

$post_detail = $post->getPost($_GET['post_id']);

// 編集処理
if($_POST) {
    $post->edit($post_detail['id']);

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}

?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container">
    <article>
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-5">投稿編集</h1>
        <div class="form-controll my-4">
            <!-- エラー表示 -->
            <?php if(!empty($error_msgs)): ?>
                <div class="card p-3">
                    <ul>
                        <?php foreach($error_msgs as $error_msg): ?>
                            <li class="text-danger"><?php echo $error_msg; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <textarea class="form-control" name="text" cols="30" rows="10"><?php echo $post_detail['text']; ?></textarea>
            <div class="text-right my-3">
                <button type="submit" class="btn btn-primary">編集</button>
            </div>
        </div>
    </form>
    </article>
</main>

<?php require_once('footer.php'); ?>
