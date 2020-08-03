<?php
if(!empty($_POST['withdraw'])) {
    try {
        $dbh =  dbConnect();
        $sql = 'UPDATE users SET delete_flg = 1 WHERE id = :user_id';
        $data = array(':id' => $_SESSION['user_id']);
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
