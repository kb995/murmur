<?php
require_once('../config/app.php');
require_once('../controllers/PostController.php');
require_once('../controllers/UserController.php');
require_once('../controllers/LikeController.php');
require_once('../controllers/FollowController.php');
require_once('../controllers/PagingController.php');

$post = new PostController;
$user = new UserController;
$like = new LikeController;
$follow = new FollowController;
$paging = new PagingController;

// $aaa = $paging->pre_path;
// echo "<pre style='color: #fff;'>"; var_dump($aaa); echo"</pre>";


// ページ情報取得
// $login_user = $_SESSION['login_user'];
$login_user = $user->getOneUser($_SESSION['login_user']['id']);
$current_posts = $post->getCurrentPosts($paging->offset, $paging->per_page_post);

// 投稿処理
if(!empty($_POST) && $_POST['action'] === 'new') {
    $result = $post->new();
}

// 投稿削除処理
if(!empty($_POST) && $_POST['action'] === 'delete') {
    $post->delete();
}

// いいね機能
if(!empty($_POST) && $_POST['action'] === 'like') {
    $like->like($login_user['id'], $_POST['post_id']);
}

?>

<?php
$pageTitle = 'マイページ';
require_once('./template/head.php');
require_once('./template/header.php');

?>

<main class="container mb-5">
    <h1 class="text-center my-5">mypage</h1>
    <div class="row">
        <div class="col-4">
            <?php require('./template/myProfCard.php'); ?>
            <?php require('./template/post.php'); ?>
        </div>
        <div class="col-8">
            <?php require('./template/timeline.php'); ?>
            <?php require('./template/paging.php'); ?>
        </div>
    </div>
</main>
<?php
require_once('./template/footer.php')
?>
