<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');

$user = new UserController;

$login_user = $_SESSION['login_user'];
$login_user = $user->getOneUser($_SESSION['login_user']['id']);


// 画像ファイルアップロード
if(!empty($filename)) {
    $ext = substr($filename, -3);
    if($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
        $_SESSION['error_msgs'][] = '画像は「jpg」「png」「gif」がご利用いただけます';
    }
}
// ファイル名作成
$image = date('YmdHis') . $_FILES['image']['name'];
// 一時保存先から指定フォルダにアップロード
move_uploaded_file($_FILES['image']['tmp_name'], '../resources/images/' . $image);
// セッションに残しておく (DB保存の準備)
$_SESSION['image']['name'] = $image;
// $aaa = $user->showThumbnail(27);
// echo "<pre style='color: #fff;'>"; var_dump($aaa); echo"</pre>";



// 記事編集処理
if($_POST) {
    $user->edit($login_user['id']);
}
// 退会処理
if(!empty($_GET) && $_GET['action'] === 'withdraw') {
    $user->withdraw($login_user['id']);
}



?>

<?php
$pageTitle = 'プロフィール編集';
require_once('./template/head.php');
require_once('./template/header.php');
?>

<main class="container my-5">
    <form class="w-50 mx-auto" method="post" action="" enctype="multipart/form-data">
        <h1 class="h3 text-center my-5">プロフ編集</h1>
        <div class="form-controll my-4">
            <!-- エラー表示 -->
            <?php require('./template/error_msgs.php'); ?>

            <div class="form-controll my-4">
                <label class="control-label mt-2" for="">サムネイル</label>
                <?php
                $img = $user->showThumbnail($login_user['id']);
                if(!empty($img['thumbnail'])) {
                    $path = '../resources/images/' . $img['thumbnail'];
                } else {
                    $path = '../resources/images/default.png';
                }
                ?>
                <p>
                    <img style="width: 100px;height: 100px;" src="<?php echo $path; ?>" alt="">
                </p>

                <input type="file" name="image" size="35">
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
