<!-- ???­ -->
<form action="" method="post" style="backgroud-color:black;">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <button type="submit" name="type" value="like" class="like_btn text-danger border border-0 pl-3 pr-0" style="background-color:black;">
        <?php if (!$like->likeDuplicate($login_user['id'], $post['id'])): ?>
            <i class="far fa-heart text-white"></i>
        <?php else: ?>
            <i class="fas fa-heart"></i>
        <?php endif; ?>
    </button>
    <span>
        <?php
        $count = $like->getLikeCount($post['id']);
        echo $count[0];
        ?>
    </span>
</form>