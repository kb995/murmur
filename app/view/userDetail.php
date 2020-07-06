<?php


require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;

$pageTitle = 'ユーザー詳細';

// 認証
$user->loginLimit();

// ユーザーデータ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);
$user_detail = $user->getUser($_GET['user_id']);

// カウントデータ取得
$count_data = $user->countData($user_detail['id']);

// ログイン有効期限チェック
$user->loginLimit();

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);
$posts = $post->getPostsById($start, 5, $user_detail['id']);


// フォロー処理
if(!empty($_POST) && $_POST['type'] === 'follow') {
    $user->follow($login_user['id'], $user_detail['id']);
}


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

    <!-- プロフカード -->
    <h2 class="text-center h4 text-muted my-5">プロフィール</h2>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p><?php echo $user_detail['id']; ?></p>
        <p><?php echo $user_detail['name']; ?></p>
        <p><?php echo $user_detail['email']; ?></p>
        
        <!-- フォローボタン -->
        <form action="" method="post">
            <input type="hidden" name="type" value="follow">
            <?php if($user->check_follow($login_user['id'], $user_detail['id'])) : ?>
                <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
            <?php else : ?>
               <button class="btn btn-primary" name="follow" type="submit">フォロー</button>
            <?php endif; ?>
        </form>

        <!-- カウントデータ -->
        <div class="my-3">
            <span>投稿数 : <a href="myPost.php"><?php echo $count_data['post']['COUNT(*)']; ?></a></span>
            <span>いいね : <a href="likeList.php?location=other&user_id=<?php echo $user_detail['id']; ?>"><?php echo $count_data['like']['COUNT(*)']; ?></a></span>
            <span>フォロー : <a href="followList.php?location=mypage"><?php echo $count_data['follow']['COUNT(*)']; ?></a></span>
            <span>フォロワー : <?php echo $count_data['followed']['COUNT(*)']; ?></span>
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
