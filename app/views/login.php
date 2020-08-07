<?php
require_once('../config/app.php');
require_once('../controllers/UserController.php');

$user = new UserController;

if($_POST) {
    $user->login();
}
?>

<?php
require_once('./template/head.php');
require_once('./template/header.php');
$pageTitle = 'ログイン';

?>

<main class="container">
    <form class="w-50 mx-auto" method="post" novalidate>
        <h1 class="h3 text-center my-5">LOGIN</h1>
        <!-- エラーメッセージ -->
        <?php require_once('./template/error_msgs.php') ?>

        <div class="form-controll my-4">
            <label class="control-label" for="">メールアドレス<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="email" required name="email" value="<?php if(!empty($_POST['email'])) echo h($_POST['email']); ?>">
        </div>
        <div class="form-controll my-4">
            <label class="control-label" for="">パスワード<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="password" required name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>">
        </div>

        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">送信</button>
        </div>
    </form>
</main>
