<form class="mx-auto" method="post" action="">
    <h1 class="h3 text-center my-4">投稿</h1>
    <!-- エラーメッセージ -->
    <div class="card"><?php require('error_msgs.php'); ?></div>
    
    <div class="form-controll my-4">
        <textarea class="form-control" name="text" cols="5" rows="5"><?php if(!empty($_POST['text'])) echo $_POST['text']; ?></textarea>
        <input type="hidden" name="type" value="new">
    </div>
    
    <div class="text-right my-3">
        <button type="submit" class="btn_white p-2">送信</button>
    </div>
</form>