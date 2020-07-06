<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;
$pageTitle = 'いいね';


// 認証
$user->loginLimit();

// データ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);
$count_data = $user->countData($login_user['id']);

if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);

// 取得記事を条件で変える
if($_GET['location'] === 'mypage') {
    $current_user = $user->getUser($login_user['id']);
    $posts = $post->getLikePost($start, 5, $current_user['id']);

}elseif ($_GET['location'] === 'other'){
    $current_user = $user->getUser($_GET['user_id']);
    $posts = $post->getLikePost($start, 5, $current_user['id']);
}

// いいね処理
if(!empty($_POST) && $_POST['type'] == 'like') {
    $post_id = $_POST['post_id'];
    $like->like($login_user['id'], $post_id);
}

?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h1 class="text-center mb-5">いいねした投稿</h1>

    <h2 class="text-center h3">プロフィール</h2>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p>ID : <?php echo $current_user['id']; ?></p>
        <p>名前 : <?php echo $current_user['name']; ?></p>
        <p>メールアドレス : <?php echo $current_user['email']; ?></p>
        <div class="my-3">
            <span>投稿数 : <a href="myPost.php"><?php echo $count_data['post']['COUNT(*)']; ?></a></span>
            <span>いいね : <a href="likeList.php?location=mypage"><?php echo $count_data['like']['COUNT(*)']; ?></a></span>
            <span>フォロー : <a href="followList.php?location=mypage"><?php echo $count_data['follow']['COUNT(*)']; ?></a></span>
            <span>フォロワー : <?php echo $count_data['followed']['COUNT(*)']; ?></span>
        </div>
    </div>

    <!-- いいねされた記事 -->
    <article>
        <?php foreach($posts as $post): ?>
            <div class="w-50 mx-auto card my-5 p-4">
                <p>投稿ID:<a href="detail.php?post_id=<?php echo $post['id']; ?>"><?php echo $post['id']; ?></a></p>
                <p>投稿日:<?php echo $post['created_at']; ?></p>
                <p><?php echo $post['text']; ?></a></p>

                <!-- いいね -->
                <form action="" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <button type="submit" name="type" value="like" class="like_btn text-danger border border-0">
                        <?php if (!$like->likeDuplicate($login_user['id'], $post['id'])): ?>
                            <i class="far fa-heart"></i>
                        <?php else: ?>
                            <i class="fas fa-heart"></i>
                        <?php endif; ?>
                    </button>
                    <span>
                        <?php
                         $count = $like->getLikeCount($post['id']);
                         echo $count[0];
                         ?>
                    </span>
                </form>

            </div>
        <?php endforeach; ?>
    </article>

    <!-- ページング -->
    <?php require_once('paging.php'); ?>

</main>

<?php require_once('footer.php'); ?>
