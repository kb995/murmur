<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');

$user = new UserController;

$login_user = $_SESSION['login_user'];
$login_user = $user->getOneUser($_SESSION['login_user']['id']);

// 記事編集処理
if($_POST) {
    $user->edit($login_user['id']);
}
?>

<?php
$pageTitle = 'プロフィール編集';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container my-5">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-5">プロフ編集</h1>
        <div class="form-controll my-4">
            <!-- エラー表示 -->
            <?php require('./template/error_msgs.php'); ?>

            <div class="form-controll my-4">
                <label class="control-label mt-2" for="">サムネイル</label>
                <div style="width:150px;height:200px;background-color:gray;"></div>
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">名前</label>
                <input class="form-control" type="text" name="name" value="<?php echo h($login_user['name']); ?>">
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">メールアドレス</label>
                <input class="form-control" type="email" name="email" value="<?php echo h($login_user['email']); ?>">
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">プロフィール文</label>
                <textarea id="comment" class="form-control" name="profile" cols="5" rows="5"><?php echo h($login_user['profile']); ?></textarea>
            </div>
            <span class="post_count">残り文字数 <span id="label">0</span>/300</span>
            <div class="text-right my-3">
                <button type="submit" class="post_btn">編集</button>
            </div>
        </div>
    </form>
</main>
<?php
require_once('./template/footer.php')
?>
