<form class="mx-auto" method="post" action="">
    <h1 class="h3 text-center my-4">投稿</h1>
    <div class="form-controll my-4">
        <!-- エラーメッセージ -->
        <?php require_once('../view/common/errorMessage.php'); ?>
        <input type="hidden" name="type" value="new">
        <textarea class="form-control" name="text" cols="5" rows="5"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
    </div>
    
    <div class="text-right my-3">
        <button type="submit" class="btn_white p-2">送信</button>
    </div>
</form>