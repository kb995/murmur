<form action="" method="post">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <button type="submit" name="action" value="like" class="like_btn text-danger">
        <?php if (!$like->likeDuplicate($login_user['id'], $post['id'])): ?>
            <i class="far fa-heart"></i>
        <?php else: ?>
            <i class="fas fa-heart"></i>
        <?php endif; ?>
    </button>
    <span class="like_num">
        <?php
        $count = $like->getLikeCountByPost($post['id']);
        echo $count[0];
        ?>
    </span>
</form>
