<?php


require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;

$pageTitle = '投稿一覧';

// 認証
$user->loginLimit();


// ユーザーデータ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);
$user_detail = $user->getUser($_GET['user_id']);

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);

// ページ遷移元で条件分岐
if(!empty($_GET['page']) && $_GET['page'] === 'self') {
    $posts = $post->getPostsById($start, 5, $login_user['id']);
    $count_data = $user->countData($login_user['id']);

} elseif (!empty($_GET['page']) && $_GET['page'] === 'other') {
    // カウントデータ取得
    $count_data = $user->countData($user_detail['id']);
    $posts = $post->getPostsById($start, 5, $user_detail['id']);
}


// ログイン有効期限チェック
$user->loginLimit();

// フォロー処理
if(!empty($_POST) && $_POST['type'] === 'follow') {
    $user->follow($login_user['id'], $user_detail['id']);
}

?>

<?php require('../view/common/head.php'); ?>
<?php require('../view/common/header.php'); ?>

<main class="container my-5">
    <h2 class="text-center h3 my-5">
        <?php
        if(!empty($_GET['page']) && $_GET['page'] === 'self') {
            echo $login_user['name'];
        } elseif (!empty($_GET['page']) && $_GET['page'] === 'other') {
            echo $user_detail['name'];
        } else {
            echo '名無し';
        }
        ?>
        さんの投稿一覧
    </h2>
    <!-- プロフカード -->
    <div class="w-50 card p-5 mb-5 mx-auto">
        <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
        <div class="m-auto" style="width:150px;height:150px;background-color:white;"></div>

        <?php if(!empty($_GET['page']) && $_GET['page'] === 'self') : ?>
            <p class="text-center my-4 h4"><a href="postList.php?page=self"><?php echo $login_user['name']; ?></a></p>
        <?php elseif (!empty($_GET['page']) && $_GET['page'] === 'other') : ?>
            <p class="text-center my-4 h4"><a href="postList.php?page=other"><?php echo $user_detail['name']; ?></a></p>
        <?php endif; ?>
        <!-- フォローボタン -->
        <form action="" method="post">
            <input type="hidden" name="type" value="follow">
            <div class="text-center">
                <?php if($user->check_follow($login_user['id'], $user_detail['id'])) : ?>
                    <button class="btn btn-secondary" name="follow" type="submit">フォロー済み</button>
                <?php else : ?>
                <button class="btn btn-primary" name="follow" type="submit">フォローする</button>
                <?php endif; ?>
            </div>
        </form>
        <!-- プロフィール -->
        <?php if(!empty($_GET['page']) && $_GET['page'] === 'self') : ?>
            <p class="my-4"><?php echo $login_user['profile']; ?></p>
        <?php elseif (!empty($_GET['page']) && $_GET['page'] === 'other') : ?>
            <p class="my-4"><?php echo $user_detail['profile']; ?></p>
        <?php endif; ?>

        <!-- カウント表示 -->
        <div class="my-3 row">
            <a class="col-6 block count_btn" href="myPost.php">
                <p class="text-center text-muted">投稿数</p>
                <p class="text-center h4"><?php echo $count_data['post']['COUNT(*)']; ?></p>
            </a>
            <a href="likeList.php?location=mypage" class="col-6 block count_btn">
                <p class="text-center text-muted">いいね</p>
                <p class="text-center h4"><?php echo $count_data['like']['COUNT(*)']; ?></p>
            </a>
        </div>
        <div class="my-3 row">
            <a href="followList.php?location=mypage" class="col-6 block count_btn">
                <p class="text-center text-muted">フォロー</p>
                <p class="text-center h4"><?php echo $count_data['follow']['COUNT(*)']; ?></p>
            </a>
            <a href="#" class="col-6 block count_btn">
                <p class="text-center text-muted">フォロワー</p>
                <p class="text-center h4"><?php echo $count_data['followed']['COUNT(*)']; ?></p>
            </a>
        </div>
    </div>
</div>

<!-- 投稿一覧 -->
<section class="w-50 mx-auto">
    <article class="border-w p-2">
        <h2 class="text-center h3">
            <?php
            if(!empty($_GET['page']) && $_GET['page'] === 'self') {
                echo $login_user['name'];
            }elseif($_GET['page'] === 'other') {
                echo $user_detail['name'];
            }
            ?>
        </h2>
        <?php foreach($posts as $post): ?>
            <div class="mx-auto card my-3 p-4">
                <div class="thumb" style="background:white; width:50px; height:50px;"></div>
                <p class="pt-2"><a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></p>
                <div class="row">

                <?php if(!empty($_GET['page']) && $_GET['page'] === 'self') : ?>
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
                <?php elseif (!empty($_GET['page']) && $_GET['page'] === 'other') : ?>
                    <!-- いいね -->
                    <?php require('../view/common/like.php'); ?>
                <?php endif; ?>
                    <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
                </div>
                <div style="border: solid 1px white;" class="my-2"></div>
                <p class="p-3"><?php echo $post['text']; ?></a></p>
            </div>
        <?php endforeach; ?>
    </article>

    <!-- ページング -->
    <?php require_once('../view/common/paging.php'); ?>
    
</section>

</main>

<?php require_once('../view/common/footer.php'); ?>
