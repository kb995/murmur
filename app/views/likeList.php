<?php
require_once('../config/app.php');
require_once('../controllers/PostController.php');
require_once('../controllers/UserController.php');
require_once('../controllers/LikeController.php');
require_once('../controllers/FollowController.php');

$post = new PostController;
$user = new UserController;
$like = new LikeController;
$follow = new FollowController;

$login_user = $_SESSION['login_user'];
$current_user = $user->getOneUser($_GET['user_id']);
$current_posts = $post->getLikePost($current_user['id'], 0, 4);

// いいね機能
if(!empty($_POST) && $_POST['action'] == 'like') {
    $like->like($login_user['id'], $_POST['post_id']);
}

// フォロー機能
if(!empty($_POST) && $_POST['action'] === 'follow') {
    $follow->follow($login_user['id'], $current_user['id']);
}

?>

<?php
$pageTitle = 'ユーザー投稿詳細';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container mb-5">
    <h1 class="text-center my-5"><?php echo $current_user['name']; ?> のいいね一覧</h1>
    <div class="w-50 mx-auto">
        <article class="card p-5 mb-5 mx-auto">
            <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
            <!-- プロフィール -->
            <div class="m-auto" style="width:150px;height:150px;background-color:gray;"></div>
            <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo $current_user['name']; ?></a></p>
            <p><?php echo $current_user['profile']; ?></p>

            <!-- フォロー -->
            <?php if(!$user->checkUserType($login_user['id'], $current_user['id'])) : ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="follow">
                    <div class="text-center">
                        <?php if(!$user->checkUserType($login_user['id'], $current_user['id'])): ?>
                            <?php if($follow->check_follow($login_user['id'], $current_user['id'])) : ?>
                                <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
                            <?php else : ?>
                                <button class="btn btn-primary" name="follow" type="submit">フォローする</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif; ?>

            <!-- カウント表示 -->
            <div class="my-3 row">
                <a class="col-6 block count_btn" href="userDetail.php?user_id=<?php echo $login_user['id']; ?>">
                    <p class="text-center text-muted">投稿数</p>
                    <?php $post_count = $post->postCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $post_count['COUNT(*)']; ?></p>
                </a>
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">いいね</p>
                    <?php $like_count = $like->getLikeCountByUser($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $like_count['COUNT(*)']; ?></p>
                </a>
            </div>
            <div class="my-3 row">
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロー</p>
                    <?php $follow_count = $follow->followCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $follow_count['COUNT(*)']; ?></p>
                </a>
                <a href="#" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロワー</p>
                    <?php $followed_count = $follow->followedCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $followed_count['COUNT(*)']; ?></p>
                </a>
            </div>
        </article>

        <h2 class="text-center h3 my-3">いいね一覧</h2>
        <?php require('./template/timeline.php'); ?>
    </div>
</main>
