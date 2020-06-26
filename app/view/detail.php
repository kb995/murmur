<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;

$post_detail = $post->getPost($_GET['post_id']);

?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container">
    <h1 class="h3 text-center m-5">投稿詳細</h1>
    <article>
        <div class="w-50 mx-auto card my-3 p-3">
            <p><?php echo $post_detail['id'] ?></p>
            <p><?php echo $post_detail['text'] ?></p>
        <button class="delete_btn btn btn-danger" data-id="<?php echo $post_detail['id']; ?>">削除</button>
        <a href="editPost.php?post_id=<?php echo $post_detail['id']; ?>" type="button" class="btn btn-primary">編集</a>
        </div>

    </article>
</main>

<?php require_once('footer.php'); ?>