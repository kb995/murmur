<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');
require_once('../controllers/PostController.php');
require_once('../controllers/LikeController.php');
require_once('../controllers/FollowController.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;
$follow = new FollowController;

// ページ情報取得
$login_user = $user->getOneUser($_SESSION['login_user']['id']);
$current_user = $user->getOneUser($_GET['user_id']);
$follow_users = $follow->getFollowUser($current_user['id']);

// フォロー機能
if(!empty($_POST) && $_POST['action'] === 'follow') {
    $follow->follow($login_user['id'], $_POST['follow_user']);
}
// 退会処理
if(!empty($_GET) && $_GET['action'] === 'withdraw') {
    $user->withdraw($login_user['id']);
}
?>

<?php
$pageTitle = 'フォロー中';
require_once('./template/head.php');
require_once('./template/header.php');

?>

<main class="container mb-5">
    <h1 class="text-center my-5 h4 page-title">▶ <?php echo h($current_user['name']); ?> さんがフォロー中</h1>
    <div class="row">
        <!-- プロフィール -->
        <div class="col-4">
            <?php require('./template/myProfCard.php'); ?>
        </div>

        <!-- タイムライン -->
        <div class="col-8">

            <?php foreach($follow_users as $f_user): ?>
            <?php $user_info = $user->getOneUser($f_user['followed_id']); ?>
            <article class="card my-2 mx-2 p-4 col-5 float-left">
                <!-- サムネイル -->
                <?php
                $img = $user->showThumbnail($f_user['followed_id']);
                if(!empty($img['thumbnail'])) {
                    $path = '../resources/images/' . $img['thumbnail'];
                } else {
                    $path = '../resources/images/user.png';
                }
                ?>
                <p class="mb-0">
                    <img class="thumb" src="<?php echo $path; ?>" alt="">
                </p>

                <!-- フォロー -->
                <form action="" method="post">
                    <input type="hidden" name="action" value="follow">
                    <input type="hidden" name="follow_user" value="<?php echo $user_info['id']; ?>">
                        <?php if($user->checkUserType($login_user['id'], $current_user['id'])): ?>
                            <?php if($follow->checkDuplicateFollow($login_user['id'], $user_info['id'])) : ?>
                                <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
                            <?php else : ?>
                                <button class="btn btn-primary" name="follow" type="submit">フォローする</button>
                            <?php endif; ?>
                        <?php endif; ?>
                </form>

                <p><?php echo h($user_info['name']); ?></p>
            </article>
            <?php endforeach; ?>


        </div>
    </div>
</main>

<?php
require_once('./template/footer.php')
?>
