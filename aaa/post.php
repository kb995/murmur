<?php
require_once('../model/Post.php');
require_once('../controller/PostController.php');

if($_POST) {
    $controller = new PostController;
    $result = $controller->new();

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}

?>

<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>

<main class="container">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-4">POST</h1>
        <div class="form-controll my-4">
            <label class="control-label p-3 h3" for="">つぶやく</label>
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
            <textarea class="form-control" name="text" cols="30" rows="10"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
        </div>
        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">Post</button>
        </div>
    </form>
</main>

<?php require('footer.php'); ?>
