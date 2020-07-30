<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');

$user = new UserController;

// ユーザー新規登録
if($_POST) {
    $user->new();
}

?>

<?php
require_once('./template/head.php');
require_once('./template/header.php');
$pageTitle = 'サインアップ';

?>

<main class="container">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-4">SIGN UP</h1>
        <!-- エラーメッセージ -->
        <?php require_once('./template/error_msgs.php') ?>

        <div class="form-controll my-4">
            <label class="control-label" for="">ユーザー名</label>
            <input class="form-control" type="text" name="name" value="<?php if(!empty($_POST['name'])) echo h($_POST['name']); ?>">
        </div>
        <div class="form-controll my-4">
            <label class="control-label" for="">メールアドレス<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="email" required name="email" value="<?php if(!empty($_POST['email'])) echo h($_POST['email']); ?>">
        </div>
        <div class="form-controll my-4">
            <label class="control-label" for="">パスワード<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="password" required name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>">
        </div>
        <input type="hidden" name="page" value="signup">
        <!-- <div class="form-controll">
            <label class="control-label" for="">Password:Re<span class="badge badge-danger ml-4">必須</span></label>
            <input class="form-control" type="password" name="password_re" value="<?php  // if(!empty($_POST['password_re'])) echo $_POST['password_re']; ?>">
        </div> -->

        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">送信</button>
        </div>
    </form>
</main>
