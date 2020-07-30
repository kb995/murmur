<form class="mx-auto" method="post" action="">
    <!-- エラーメッセージ -->
    <?php require('error_msgs.php'); ?>

    <div class="form-controll my-4">
        <textarea class="form-control input_text" name="text" cols="5" rows="5" placeholder="投稿する"><?php if(!empty($_POST['text'])) echo h($_POST['text']); ?></textarea>
        <input type="hidden" name="action" value="new">
    </div>

    <div class="text-right my-3">
        <button type="submit" class="post_btn">投稿</button>
    </div>
</form>
