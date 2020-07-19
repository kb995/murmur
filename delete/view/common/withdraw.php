<?php

require_once('../model/User.php');
require_once('../controller/UserController.php');

$user = new UserController;
$login_user = $user->getUser($_SESSION['login_user']['id']);
echo "<pre>"; var_dump($login_user); echo"</pre>";

if(!empty($_POST['withdraw'])) {
    try {
        $dbh =  dbConnect();
        $sql = 'UPDATE users SET delete_flg = 1 WHERE id = :user_id';
        $data = array(':user_id' => $login_user['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        if($stmt) {
            $_SESSION = array();
            session_destroy();
            header('Location: login.php');
        }

    } catch(Exception $e) {
        echo '例外エラー発生 : ' . $e->getMessage();
        $err_msg['etc'] = 'しばらくしてから再度試してください';
    }
}
?>

<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>

<main class="container">
    <h1>退会ページ</h1>
<form method="post" action="">
<p>本当に退会しますか?</p>
<input type="submit" name="withdraw" value="退会する">
</form>
</main>

<?php require('footer.php'); ?>
