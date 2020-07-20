<section>
    <h2 class="text-center h3 my-3">タイムライン</h2>
    <?php foreach($current_posts as $post): ?>
        <div class="mx-auto card my-3 p-4">
            <!-- サムネイル(仮) -->
            <div class="thumb" style="background: gray; width:50px; height:50px;"></div>
            <p class="pt-2">
                <a href="userDetail.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a>
            </p>
            <!-- 記事操作ボタン / いいね -->
            <div class="row">
                <?php if($user->checkUserType($login_user['id'], $post['user_id'])) : ?>
                <!-- 編集 -->
                <a class="px-3" href="postEdit.php?post_id=<?php echo $post['id']; ?>">
                    <i class="fas fa-edit "></i>
                    <span class="">編集</span>
                </a>
                <!-- 削除 -->
                <?php require('delete_modal.php'); ?>
                <?php else: ?>
                <!-- いいねボタン -->
                <?php require('like.php'); ?>

                <?php endif; ?>

                <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
            </div>

            <div style="border: solid 1px gray;" class="my-2"></div>
            <p class="p-3"><?php echo $post['text']; ?></a></p>

        </div>
    <?php endforeach; ?>
</section>