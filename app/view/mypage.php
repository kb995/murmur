<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;
$login_user = $user->getUser($_SESSION['login_user']['id']);
echo "<pre>"; var_dump($_SESSION); echo"</pre>";

// ログインチェック
$user->loginLimit();

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);
// $posts = $post->getPostsById($start, 5, $login_user['id']);

// データ取得
$post_count = $post->PostCount($login_user['id']);
$posts = $post->getSomePost($start, 5);

// 投稿
if($_POST) {
    $controller = new PostController;
    $result = $controller->new();
    header("Location: mypage.php");

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}



?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h1 class="text-center mb-5">マイページ</h1>

    <h2 class="text-center h3">プロフィール</h2>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p>ID : <?php echo $login_user['id'] ?></p>
        <p>名前 : <?php echo $login_user['name'] ?></p>
        <p>メールアドレス : <?php echo $login_user['email'] ?></p>
        <p>パスワード : <?php echo $login_user['password'] ?></p>
        <p>プロフィール : <?php echo $login_user['profile'] ?></p>
        <p>作成日 : <?php echo $login_user['created_at'] ?></p>
        <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-secondary">プロフィール編集</a>
        <div class="my-3">
            <span>投稿数 : <?php echo $post_count['COUNT(*)']; ?></span>
            <span>いいね : </span>
            <span>フォロー : </span>
            <span>フォロワー : </span>
        </div>
    </div>
    <!-- <a class="text-danger" href="withdraw.php">退会</a> -->

    <!-- 投稿フォーム -->
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-4">投稿</h1>
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
            <textarea class="form-control" name="text" cols="10" rows="10"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
        </div>
        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">Post</button>
        </div>
    </form>

    <article>
        <h2 class="text-center h3">タイムライン</h2>
        <?php foreach($posts as $post): ?>
            <div class="w-50 mx-auto card my-5 p-4">
                <p>ユーザーID:<a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['user_id']; ?></a></p>

                <p>投稿ID:<a href="detail.php?post_id=<?php echo $post['id']; ?>"><?php echo $post['id']; ?></a></p>
                <p>投稿日:<?php echo $post['created_at']; ?></p>
                <p><?php echo $post['text']; ?></a></p>
            </div>
        <?php endforeach; ?>
    </article>
<!-- ページング -->
<?php require_once('paging.php'); ?>
</main>

<?php require_once('footer.php'); ?>
