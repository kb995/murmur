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

// 退会処理
if(!empty($_GET) && $_GET['action'] === 'withdraw') {
    $user->withdraw($login_user['id']);
}

?>

<?php
$pageTitle = 'いいねリスト';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container mb-5">
    <h1 class="text-center my-5 h4 page-title">▶ <?php echo h($current_user['name']); ?> さんのいいね一覧</h1>
    <div class="w-50 mx-auto">
        <article class="card p-5 mb-5 mx-auto">
            <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
            <!-- プロフィール -->
            <?php
                $img = $user->showThumbnail($current_user['id']);
                if(!empty($img['thumbnail'])) {
                    $path = '../resources/images/' . $img['thumbnail'];
                } else {
                    $path = '../resources/images/user.png';
                }
            ?>
            <p class="text-center">
                <img class="thumb" src="<?php echo $path; ?>" alt="">
            </p>
            <p class="text-center pt-2 h4"><a class="prof-name" href="mypage.php"><?php echo h($current_user['name']); ?></a></p>
            <p><?php echo h($current_user['profile']); ?></p>

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
                <a href="likeList.php?user_id=<?php echo h($current_user['id']); ?>" class="col-6 block count_btn">
                    <p class="text-center text-muted">いいね</p>
                    <?php $like_count = $like->getLikeCountByUser($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $like_count['COUNT(*)']; ?></p>
                </a>
            </div>
            <div class="my-3 row">
                <a href="followList.php?user_id=<?php echo h($current_user['id']); ?>" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロー</p>
                    <?php $follow_count = $follow->followCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $follow_count['COUNT(*)']; ?></p>
                </a>
                <a href="followedList.php?user_id=<?php echo h($current_user['id']); ?>" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロワー</p>
                    <?php $followed_count = $follow->followedCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $followed_count['COUNT(*)']; ?></p>
                </a>
            </div>
        </article>
        <?php require('./template/timeline.php'); ?>
    </div>
</main>
