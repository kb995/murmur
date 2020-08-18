<section class="timeline">
    <?php foreach($current_posts as $post): ?>
        <div class="mx-auto card card mb-3 p-4">
        <?php
        $img = $user->showThumbnail($post['user_id']);
        if(!empty($img['thumbnail'])) {
            $path = '../resources/images/' . $img['thumbnail'];
        } else {
            $path = '../resources/images/user.png';
        }
    ?>
    <p class="mb-0">
        <img class="thumb" src="<?php echo $path; ?>" alt="">
    </p>
    <p class="pt-2 pl-2">
        <a class="user_name" href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo h($post['name']); ?></a>
    </p>

    <!-- 記事操作ボタン / いいね -->
    <div class="row ml-auto">

        <?php if($user->checkUserType($login_user['id'], $post['user_id'])) : ?>
        <!-- 編集 -->
        <a class="mx-2" href="postEdit.php?post_id=<?php echo $post['id']; ?>">
            <button class="edit_btn">
                <i class="fas fa-edit "></i> 編集
            </button>
        </a>
        <!-- 削除 -->
        <?php require('delete_modal.php'); ?>
        <?php else: ?>
        <!-- いいねボタン -->
        <?php require('like.php'); ?>
        <?php endif; ?>

        <span class="ml-auto pr-3"><?php echo h($post['created_at']); ?></span>
    </div>

    <div class="my-2 line"></div>
        <p class="post_text" class="p-3"><?php echo h($post['text']); ?></a></p>
    </div>
    <?php endforeach; ?>
</section>
