<?php
ini_set('display_errors', 1);

require_once('../controller/UserController.php');
require_once('../controller/PostController.php');

$user = new UserController;
$post = new PostController;
$login_user = $user->getUser($_SESSION['login_user']['id']);

if($_POST) {
    $user->edit($login_user['id']);

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}
?>

<?php require('../view/common/head.php'); ?>
<?php require('../view/common/header.php'); ?>

<main class="container my-5">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-5">プロフ編集</h1>
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

            <div class="form-controll my-4">
                <div style="width:150px;height:200px;background-color:gray;"></div>
                <label class="control-label mt-2" for="">サムネイル</label>
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">名前</label>
                <input class="form-control" type="text" name="name" value="<?php echo $login_user['name']; ?>">
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">メールアドレス</label>
                <input class="form-control" type="email" name="email" value="<?php echo $login_user['email']; ?>">
            </div>
            <div class="form-controll my-4">
                <label class="control-label" for="">プロフィール文</label>
                <textarea class="form-control" name="profile" cols="5" rows="5"><?php echo $login_user['profile']; ?></textarea>
            </div>
            <div class="text-right my-3">
                <button type="submit" class="btn btn-primary">編集</button>
            </div>
        </div>
    </form></main>

<?php require_once('../view/common/footer.php'); ?>
