<?php
require_once('../controller/UserController.php');
require_once('../controller/PostController.php');
require_once('../controller/LikeController.php');
require_once('../config/app.php');

$user = new UserController;
$post = new PostController;
$like = new LikeController;

$pageTitle = 'ユーザー詳細';

// 認証
$user->loginLimit();

// ユーザーデータ取得
$login_user = $user->getUser($_SESSION['login_user']['id']);

// カウントデータ取得
$count_data = $user->countData($login_user['id']);

// ログイン有効期限チェック
$user->loginLimit();

// ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$start = 5 * ($page - 1);
$posts = $post->getPostsById($start, 5, $login_user['id']);


?>

<?php require('../view/common/head.php'); ?>
<?php require('../view/common/header.php'); ?>

<main class="container my-5">
    <h2 class="text-center h3 my-5">
        自分の投稿
    </h2>
    <!-- プロフカード -->
    <div class="w-50 card p-5 mb-5 mx-auto">
        <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
        <div class="m-auto" style="width:150px;height:150px;background-color:white;"></div>
        <p class="text-center my-4 h4"><a href="mypage.php"><?php echo $login_user['name']; ?></a></p>
        
        <p class="my-4"><?php echo $login_user['profile']; ?></p>

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
    
    <!-- 投稿 -->
    <section class="w-50 mx-auto">
        <article class="border-w p-2">
            <h2 class="text-center h3">
                <?php if(empty($login_user['name'])) { echo '名無し'; } else { echo $login_user['name']; } ?> さんの投稿
            </h2>
            <?php foreach($posts as $post): ?>
                    <div class="mx-auto card my-3 p-4">
                        <div class="thumb" style="background:white; width:50px; height:50px;"></div>
                        <p class="pt-2"><a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></p>
                        <div class="row">
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
                            <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
                        </div>
                        <div style="border: solid 1px white;" class="my-2"></div>
                        <p class="p-3"><?php echo $post['text']; ?></a></p>
                    </div>
                <?php endforeach; ?>
        </article>

        <!-- ページング -->
        <p class="text-center py-4">
            <?php if($page >= 2): ?>
                <div class="text-left">
                    <a class="pl-5 paging" href="myPost.php?page=<?php echo $page - 1; ?>">
                    &lt; <?php echo $page - 1; ?> ページ目
                    </a>
                </div>
            <?php endif; ?>
            <?php
                $dbh = dbConnect();
                $stmt = $dbh->query('SELECT COUNT(*)
                                    FROM posts 
                                    WHERE delete_flg = 0'
                                    );
                $page_count = $stmt->fetch(PDO::FETCH_ASSOC);
                $max_page = ceil($page_count['COUNT(*)'] / 5);
                if($page < $max_page):
            ?>
            <div class="text-right">
                <a class="pl-5 paging" href="myPost.php?page=<?php echo $page + 1; ?>">
                    <?php echo $page + 1; ?> ページ目 &gt;
                </a>
            </div>
            <?php endif; ?>
        </p>
    </section>

</main>

<?php require_once('../view/common/footer.php'); ?>

