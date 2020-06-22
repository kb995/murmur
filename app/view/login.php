<?php
require_once('../controller/UserController.php');

if($_POST) {
    $controller = new UserController;
    $controller->login();

    if(!empty($_SESSION['error_msgs'])) {
        $error_msgs = $_SESSION['error_msgs'];
        unset($_SESSION['error_msgs']);
    }
}
?>

<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>

<main class="container">
    <form class="w-50 mx-auto" method="post" action="">
        <h1 class="h3 text-center my-4">LOGIN</h1>

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
            <label class="control-label" for="">E-mail<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="email" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
        </div>
        <div class="form-controll my-4">
            <label class="control-label" for="">Password<span class="badge badge-danger ml-2">必須</span></label>
            <input class="form-control" type="password" name="password" value="<?php if(!empty($_POST['password'])) echo $_POST['password']; ?>">
        </div>
        <!-- <div class="form-controll">
            <label class="control-label" for="">Password:Re<span class="badge badge-danger ml-4">必須</span></label>
            <input class="form-control" type="password" name="password_re" value="<?php  // if(!empty($_POST['password_re'])) echo $_POST['password_re']; ?>">
        </div> -->
        <div class="text-right my-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</main>

<?php require_once('footer.php'); ?>