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

<?php require('head.php'); ?>
<?php require('header.php'); ?>

<main class="container mb-5">
    <h1 class="text-center my-5">mypage</h1>
    <div class="row">
        <div class="col-4">
            <!-- プロフカード -->
            <div class="card p-5 mb-5 mx-auto">
                <h3 class="pb-2 text-center h4 text-muted">プロフィール</h3>
                <div class="m-auto" style="width:150px;height:150px;background-color:white;"></div>
                <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo $login_user['name']; ?></a></p>
                <p><?php echo $login_user['profile']; ?></p>

                <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-white mb-4">プロフィール編集</a>

                <div class="my-3 row">
                    <a class="col-6 block count_btn" href="myPost.php">
                        <p class="text-center text-muted">投稿数</p>
                        <p class="text-center h3"><?php echo $count_data['post']['COUNT(*)']; ?></p>
                    </a>
                    <a href="likeList.php?location=mypage" class="col-6 block count_btn">
                        <p class="text-center text-muted">いいね</p>
                        <p class="text-center h3"><?php echo $count_data['like']['COUNT(*)']; ?></p>
                    </a>
                </div>
                <div class="my-3 row">
                    <a href="followList.php?location=mypage" class="col-6 block count_btn">
                        <p class="text-center text-muted">フォロー</p>
                        <p class="text-center h3"><?php echo $count_data['follow']['COUNT(*)']; ?></p>
                    </a>
                    <a href="#" class="col-6 block count_btn">
                        <p class="text-center text-muted">フォロワー</p>
                        <p class="text-center h3"><?php echo $count_data['followed']['COUNT(*)']; ?></p>
                    </a>
                </div>
            </div>

             <!-- 投稿フォーム -->
            <form class="mx-auto" method="post" action="">
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
                    <textarea class="form-control" name="text" cols="5" rows="5"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
                </div>
                <div class="text-right my-3">
                    <button type="submit" class="btn_white p-2">送信</button>
                </div>
            </form>
        </div>

    <div class="col-8">
        <!-- タイムライン -->
        <section class="border-w p-2">
            <h2 class="text-center h3 my-3">全体タイムライン</h2>
                <?php foreach($posts as $post): ?>
                    <div class="mx-auto card my-3 p-4">
                        <div class="thumb" style="background:white; width:50px; height:50px;"></div>
                        <p class="pt-2"><a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></p>
                        <div class="row">
                            <!-- いいね -->
                            <form action="" method="post" style="backgroud-color:black;">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="type" value="like" class="like_btn text-danger border border-0 pl-3 pr-0" style="background-color:black;">
                                    <?php if (!$like->likeDuplicate($login_user['id'], $post['id'])): ?>
                                        <i class="far fa-heart"></i>
                                    <?php else: ?>
                                        <i class="fas fa-heart"></i>
                                    <?php endif; ?>
                                </button>
                                <span>
                                    <?php
                                    $count = $like->getLikeCount($post['id']);
                                    echo $count[0];
                                    ?>
                                </span>
                            </form>
                            <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
                        </div>
                        <div style="border: solid 1px white;" class="my-2"></div>
                        <p class="p-3"><?php echo $post['text']; ?></a></p>
                    </div>
                <?php endforeach; ?>
            </section>

        </div>
    </div>

<!-- ページング -->
<?php require_once('paging.php'); ?>

</main>

<?php require_once('footer.php'); ?>
