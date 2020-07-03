<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;
$pageTitle = 'マイページ';


// 認証
$user->loginLimit();


// ユーザ情報取得
$login_user = $user->getUser($_SESSION['login_user']['id']);

// カウントデータ取得
$count_data = $user->countData($login_user['id']);

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);

$posts = $post->getSomePost($start, 5);


// 投稿処理
if(!empty($_POST) && $_POST['type'] == 'new') {
    $result = $post->new();

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}

// いいね処理
if(!empty($_POST) && $_POST['type'] == 'like') {
    $post_id = $_POST['post_id'];
    $like->like($login_user['id'], $post_id);
}

?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container mb-5">
    <h1 class="text-center mb-5">Mypage</h1>

    <!-- プロフカード -->
    <h2 class="text-center h4 text-muted">プロフィール</h2>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p>ID : <?php echo $login_user['id']; ?></p>
        <p>名前 : <?php echo $login_user['name']; ?></p>
        <p>メールアドレス : <?php echo $login_user['email']; ?></p>
        <p>プロフィール : <?php echo $login_user['profile']; ?></p>
        <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-secondary">プロフィール編集</a>
        <div class="my-3">
            <span>投稿数 : <a href="myPost.php"><?php echo $count_data['post']['COUNT(*)']; ?></a></span>
            <span>いいね : <a href="myLike.php"><?php echo $count_data['like']['COUNT(*)']; ?></a></span>
            <span>フォロー : <a href="followList.php?location=mypage"><?php echo $count_data['follow']['COUNT(*)']; ?></a></span>
            <span>フォロワー : <?php echo $count_data['followed']['COUNT(*)']; ?></span>
        </div>
    </div>

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

            <input type="hidden" name="type" value="new">
            <textarea class="form-control" name="text" cols="5" rows="5"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
        </div>
        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">送信</button>
        </div>
    </form>

    <!-- タイムライン -->
    <article>
        <h2 class="text-center h3">全体タイムライン</h2>
        <?php foreach($posts as $post): ?>
            <div class="w-50 mx-auto card my-5 p-4">
                <p>ユーザーID:<a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['user_id']; ?></a></p>
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
