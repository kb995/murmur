<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;

$post_detail = $post->getPost($_GET['post_id']);

//削除処理
if( !empty($_POST['type']) && $_POST['type'] === 'delete') {
    $post->delete();
}
?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container">
    <h1 class="h3 text-center m-5">投稿詳細</h1>
    <article>
        <div class="w-50 mx-auto card my-3 p-3">
            <p><?php echo $post_detail['id'] ?></p>
            <p><?php echo $post_detail['text'] ?></p>

            <div class="row">
                    <form action="" method="post">
                        <input type="hidden" name="type" value="delete">
                        <input type="hidden" name="post_id" value="<?php echo $post_detail['id']; ?>">
                        <input class="btn btn-danger my-3" type="submit" value="削除">
                        <a href="editPost.php?post_id=<?php echo $post_detail['id']; ?>" class="btn btn-secondary">編集</a>
                    </form>
            </div>
    
        </div>

    </article>
</main>

<?php require_once('footer.php'); ?>
