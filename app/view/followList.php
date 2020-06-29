<?php

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;

$login_user = $user->getUser($_SESSION['login_user']['id']);

// ログイン期限
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
$my_post_count = $post->PostCount($login_user['id']);
$my_like_count = $user->LikeCount($login_user['id']);
$my_follow_count = $user->followCount($login_user['id']);
$my_followed_count = $user->followedCount($login_user['id']);

// フォロー機能


// フォロー中のユーザー取得
function followUser($user_id) {
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM follow WHERE follow_id = :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo '例外エラー発生 : ' . $e->getMessage();
        $error_msgs[] = 'しばらくしてから再度試してください';
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if($_GET['location'] === 'mypage') {
    $follows = followUser($login_user['id']);
}else{
    $follows = followUser($_GET['user_id']);
}

// foreach($users as $u) {
    // echo "<pre>"; var_dump($u['followed_id']); echo"</pre>";
    // $aaa = $user->getUser($u['followed_id']);
    // echo "<pre>"; var_dump($aaa); echo"</pre>";
// }
?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h1 class="text-center mb-5">フォロー中</h1>

    <h2 class="text-center h3">プロフィール</h2>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p>ID : <?php echo $login_user['id']; ?></p>
        <p>名前 : <?php echo $login_user['name']; ?></p>
        <p>メールアドレス : <?php echo $login_user['email']; ?></p>
        <p>パスワード : <?php echo $login_user['password']; ?></p>
        <p>プロフィール : <?php echo $login_user['profile']; ?></p>
        <p>作成日 : <?php echo $login_user['created_at']; ?></p>
        <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-secondary">プロフィール編集</a>
        <div class="my-3">
            <span>投稿数 : <a href="myPost.php"><?php echo $my_post_count['COUNT(*)']; ?></a></span>
            <span>いいね : <a href="myLike.php"><?php echo $my_like_count['COUNT(*)']; ?></a></span>
            <span>フォロー : <?php echo $my_follow_count['COUNT(*)']; ?></span>
            <span>フォロワー : <?php echo $my_followed_count['COUNT(*)']; ?></span>
        </div>
    </div>

    <!-- フォロー中 -->
    <?php
        foreach($follows as $follow):
        $data = $user->getUser($follow['followed_id']);
    ?>
    <div class="card p-5 my-5 w-50 mx-auto">
        <p>ID : <?php echo $data['id']; ?></p>
        <p>名前 : <?php echo $data['name']; ?></p>
        <p>プロフィール : <?php echo $data['profile']; ?></p>
    </div>
    <?php endforeach; ?>


<!-- ページング -->
<?php require_once('paging.php'); ?>
</main>

<?php require_once('footer.php'); ?>
