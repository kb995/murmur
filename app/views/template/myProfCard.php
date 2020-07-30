<article class="card p-5 mb-5 mx-auto">
    <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
    <!-- プロフィール -->
    <div class="m-auto" style="width:150px;height:150px;background-color:gray;"></div>
    <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo h($login_user['name']); ?></a></p>
    <p><?php echo h($login_user['profile']); ?></p>
    <a href="profEdit.php" type="button" class="btn mb-4 btn-l">プロフィール編集</a>

    <!-- カウント表示 -->
    <div class="my-3 row">
        <a class="col-6 block count_btn" href="userDetail.php?user_id=<?php echo $login_user['id']; ?>">
            <p class="text-center text-muted count_title">投稿数</p>
            <?php $post_count = $post->postCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo h($post_count['COUNT(*)']); ?></p>
        </a>
        <a href="likeList.php?page=likelist&user_id=<?php echo $login_user['id']; ?>" class="col-6 block count_btn">
            <p class="text-center text-muted count_title">いいね</p>
            <?php $like_count = $like->getLikeCountByUser($login_user['id']); ?>
            <p class="text-center h4"><?php echo h($like_count['COUNT(*)']); ?></p>
        </a>
    </div>
    <div class="my-3 row">
        <a href="followList.php?user_id=<?php echo $login_user['id']; ?>" class="col-6 block count_btn">
            <p class="text-center text-muted count_title">フォロー</p>
            <?php $follow_count = $follow->followCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo h($follow_count['COUNT(*)']); ?></p>
        </a>
        <a href="followedList.php?user_id=<?php echo $login_user['id']; ?>" class="col-6 block count_btn">
            <p class="text-center text-muted count_title">フォロワー</p>
            <?php $followed_count = $follow->followedCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo h($followed_count['COUNT(*)']); ?></p>
        </a>

    </div>
</article>
