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

// カウントデータ取得
$count_data = $user->countData($login_user['id']);

// echo "<pre>"; var_dump($my_follow_count); echo"</pre>";
// $posts = $post->getSomePost($start, 5);
$posts = $post->getPostsById($start, 5, $login_user['id']);

echo "<pre>"; var_dump($_POST); echo"</pre>";

// 投稿
if(!empty($_POST) && $_POST['type'] == 'new') {
    $controller = new PostController;
    $result = $controller->new();
    header("Location: mypage.php");

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}

// いいね
if(!empty($_POST) && $_POST['type'] == 'like') {
    $post_id = $_POST['post_id'];

    if(likes_duplicate($login_user['id'], $post_id)) {
        $sql = 'DELETE FROM likes WHERE :user_id = user_id AND :post_id = post_id';
    }else{
        $sql = 'INSERT INTO likes(user_id, post_id) VALUES(:user_id, :post_id)';
        }
    try{
        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $login_user['id'], PDO::PARAM_STR);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
        $result = $stmt->execute();
    
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
      }
}

//お気に入りの重複チェック
function likes_duplicate($user_id,$post_id){
    $dbh = dbConnect();
    $sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch();
    if($data) {
        return true;
    }else{
        return false;
    }
  }
//記事のライク数表示
  function get_like_count($post_id){
    $dbh = dbConnect();
    $sql = "SELECT COUNT(user_id) FROM likes WHERE post_id = :post_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  // ライクしている記事数取得
  function get_like_post() {

  }
//   $count = get_like_count($_POST['post_id']);
//   echo "<pre>"; var_dump($count); echo"</pre>";
?>

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container my-5">
    <h1 class="text-center mb-5">自分の投稿</h1>

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
    <!-- <a class="text-danger" href="withdraw.php">退会</a> -->

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

            <textarea class="form-control" name="text" cols="10" rows="10"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
        </div>
        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">Post</button>
        </div>
    </form>

    <!-- タイムライン -->
    <article>
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
                        <?php if (!likes_duplicate($login_user['id'], $post['id'])): ?>
                            <i class="far fa-heart"></i>
                        <?php else: ?>
                            <i class="fas fa-heart"></i>
                        <?php endif; ?>
                    </button>
                    <span>
                        <?php
                         $count = get_like_count($post['id']);
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
