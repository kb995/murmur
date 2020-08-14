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
$followed_users = $follow->getFollowedUser($current_user['id']);

// フォロー機能
if(!empty($_POST) && $_POST['action'] === 'follow') {
    $follow->follow($login_user['id'], $_POST['followed_user']);
}
// 退会処理
if(!empty($_GET) && $_GET['action'] === 'withdraw') {
    $user->withdraw($login_user['id']);
}
?>

<?php
$pageTitle = 'フォロワー';
require_once('./template/head.php');
require_once('./template/header.php');

?>

<main class="container mb-5">
    <h1 class="text-center my-5">フォロワー</h1>
    <div class="row">
        <div class="col-4">
        <?php if($user->checkUserType($login_user['id'], $current_user['id'])): ?>
            <?php require('./template/myProfCard.php'); ?>
        <?php else: ?>
            <article class="card p-5 mb-5 mx-auto">
            <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
            <!-- プロフィール -->
            <div class="m-auto" style="width:150px;height:150px;background-color:gray;"></div>
            <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo h($current_user['name']); ?></a></p>
            <p><?php echo h($current_user['profile']); ?></p>

            <!-- フォロー -->
            <?php if(!$user->checkUserType($login_user['id'], $current_user['id'])) : // ログインユーザーと現在のユーザが違えば表示(自分に表示させない) ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="follow">
                    <div class="text-center">
                        <?php if($follow->checkDuplicateFollow($login_user['id'], $current_user['id'])) : ?>
                            <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
                        <?php else : ?>
                            <button class="btn btn-primary" name="follow" type="submit">フォローする</button>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif; ?>

            <!-- カウント表示 -->
            <div class="my-3 row">
                <a class="col-6 block count_btn" href="userDetail.php?user_id=<?php echo $current_user['id']; ?>">
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
                <a href="followList.php?user_id=<?php echo $current_user['id']; ?>" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロー</p>
                    <?php $follow_count = $follow->followCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $follow_count['COUNT(*)']; ?></p>
                </a>
                <a href="followedList.php?user_id=<?php echo $current_user['id']; ?>" class="col-6 block count_btn">
                    <p class="text-center text-muted">フォロワー</p>
                    <?php $followed_count = $follow->followedCount($current_user['id']); ?>
                    <p class="text-center h4"><?php echo $followed_count['COUNT(*)']; ?></p>
                </a>
            </div>
        </article>

        <?php endif; ?>
        </div>
        <div class="col-8">
        <?php foreach($followed_users as $f_user): ?>
        <?php $user_info = $user->getOneUser($f_user['follow_id']); ?>
            <article class="mx-auto card my-3 p-4">
                <div class="row p-2">
                    <div class="col-3">
                        <!-- サムネイル(仮) -->
                        <?php
                        $img = $user->showThumbnail($f_user['follow_id']);
                        if(!empty($img['thumbnail'])) {
                            $path = '../resources/images/' . $img['thumbnail'];
                        } else {
                            $path = '../resources/images/default.png';
                        }
                        ?>
                        <p>
                            <img style="width: 100px;height: 100px;" src="<?php echo $path; ?>" alt="">
                        </p>
                        <p class="pt-2">
                            <a href="userDetail.php?user_id=<?php echo $user_info['user_id']; ?>"><?php echo h($user_info['name']); ?></a>
                        </p>
                    </div>

                    <!-- フォロー -->
                        <form action="" method="post">
                            <input type="hidden" name="action" value="follow">
                            <input type="hidden" name="followed_user" value="<?php echo $user_info['id']; ?>">
                            <div class="text-center">
                                <?php if($user->checkUserType($login_user['id'], $current_user['id'])): ?>
                                    <?php if($follow->checkDuplicateFollow($login_user['id'], $user_info['id'])) : ?>
                                        <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
                                    <?php else : ?>
                                        <button class="btn btn-primary" name="follow" type="submit">フォローする</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </form>

                    <p class="pt-2 px-2"><?php echo h($user_info['profile']); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once('./template/footer.php')
?>
