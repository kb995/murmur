<?php


require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;

// データ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);
$user_detail = $user->getUser($_GET['user_id']);

$post_count = $post->PostCount($_GET['user_id']);
$user_like_count = $user->LikeCount($user_detail['id']);
$user_follow_count = $user->followCount($user_detail['id']);
$user_followed_count = $user->followedCount($user_detail['id']);
echo "<pre>"; var_dump($user_like_count); echo"</pre>";
echo "<pre>"; var_dump($user_follow_count); echo"</pre>";
echo "<pre>"; var_dump($user_followed_count); echo"</pre>";

// echo "<pre>"; var_dump($_SESSION); echo"</pre>";
// echo "<pre>"; var_dump($login_user); echo"</pre>";

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
// echo "<pre>"; var_dump($user_detail); echo"</pre>";
// echo "<pre>"; var_dump($_SESSION); echo"</pre>";


// フォロー機能
function check_follow($follow_user, $followed_user) {
    try {
        $dbh = dbConnect();
        $sql = 'SELECT follow_id,followed_id FROM follow WHERE follow_id = :follow_id AND followed_id = :followed_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':follow_id', $follow_user, PDO::PARAM_INT);
        $stmt->bindValue(':followed_id', $followed_user, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
        
    } catch (PDOException $e) {
        echo 'DB接続エラー発生 : ' . $e->getMessage();
        $this->error_msgs[] = 'しばらくしてから再度試してください';
    }
}

if(!empty($_POST) && $_POST['type'] === 'follow') {
    if(check_follow($login_user['id'], $user_detail['id'])) {
        $sql ='DELETE FROM follow WHERE :follow_id = follow_id AND :followed_id = followed_id';
    }else{
        $sql ='INSERT INTO follow(follow_id,followed_id) VALUES(:follow_id,:followed_id)';
    }
    try {
        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':follow_id', $login_user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':followed_id', $user_detail['id'], PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'DB接続エラー発生 : ' . $e->getMessage();
        $this->error_msgs[] = 'しばらくしてから再度試してください';
    }
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
    <div class="card p-5 my-5">
        <p><?php echo $user_detail['id'] ?></p>
        <p><?php echo $user_detail['email'] ?></p>
        <p><?php echo $user_detail['password'] ?></p>
        <p><?php echo $user_detail['created_at'] ?></p>
        
        <!-- フォローボタン -->
        <form action="" method="post">
            <input type="hidden" name="type" value="follow">
            <?php if(check_follow($login_user['id'], $user_detail['id'])) : ?>
                <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
            <?php else : ?>
               <button class="btn btn-primary" name="follow" type="submit">フォロー</button>
            <?php endif; ?>
        </form>
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
        <span>投稿数 : <?php echo $post_count['COUNT(*)']; ?></span>
        <span>いいね : <?php echo $user_like_count['COUNT(*)']; ?></span>
        <span>フォロー : <?php echo $user_follow_count['COUNT(*)']; ?></span>
        <span>フォロワー : <?php echo $user_followed_count['COUNT(*)']; ?></span>

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
