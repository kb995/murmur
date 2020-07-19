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

<?php require('../view/common/head.php'); ?>
<?php require('../view/common/header.php'); ?>

<main class="container mb-5">
    <h1 class="text-center my-5">mypage</h1>
    <div class="row">
        <div class="col-4">
            <!-- プロフィールカード -->
            <?php require_once('../view/common/profCard.php'); ?>
            <!-- 投稿フォーム -->
            <?php require_once('../view/common/form.php'); ?>
        </div>

        <div class="col-8">
            <!-- タイムライン -->
            <section class="border-w p-2">
                <h2 class="text-center h3 my-3">全体タイムライン</h2>
                <?php foreach($posts as $post): ?>
                    <div class="mx-auto card my-3 p-4">
                        <div class="thumb" style="background:white; width:50px; height:50px;"></div>
                        <p class="pt-2"><a href="postList.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></p>
                        <div class="row">
                            <?php if(!$user->checkUser($login_user['id'], $post['user_id'])): ?>
                                <!-- いいね -->
                                <?php require('../view/common/like.php'); ?>
                            <?php else: ?>
                                <!-- 編集 -->
                                <a class="px-3" href="editPost.php?post_id=<?php echo $post['id']; ?>">
                                    <i class="fas fa-edit text-white"></i>
                                    <span class="text-white">編集</span>
                                </a>
                                <!-- 削除 -->
                                <a class="mr-auto" href="#">
                                    <i class="fas fa-trash-alt text-white"></i>
                                    <span class="text-white">削除</span>
                                </a>
                            <?php endif; ?>

                            <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
                        </div>
                        <div style="border: solid 1px white;" class="my-2"></div>
                        <p class="p-3"><?php echo $post['text']; ?></a></p>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- ページング -->
            <?php require_once('../view/common/paging.php'); ?>
        </div>
    </div>
</main>

<?php require_once('../view/common/footer.php'); ?>
