<article class="card p-5 mb-5 mx-auto">
    <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
    <!-- プロフィール -->
    <div class="m-auto" style="width:150px;height:150px;background-color:gray;"></div>
    <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo $login_user['name']; ?></a></p>
    <p><?php echo $login_user['profile']; ?></p>
    <a href="profEdit.php" type="button" class="btn btn-white mb-4">プロフィール編集</a>

    <!-- カウント表示 -->
    <div class="my-3 row">
        <a class="col-6 block count_btn" href="userDetail.php?user_id=<?php echo $login_user['id']; ?>">
            <p class="text-center text-muted">投稿数</p>
            <?php $post_count = $post->postCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo $post_count['COUNT(*)']; ?></p>
        </a>
        <a href="likeList.php?page=likelist&user_id=<?php echo $login_user['id']; ?>" class="col-6 block count_btn">
            <p class="text-center text-muted">いいね</p>
            <?php $like_count = $like->getLikeCountByUser($login_user['id']); ?>
            <p class="text-center h4"><?php echo $like_count['COUNT(*)']; ?></p>
        </a>
    </div>
    <div class="my-3 row">
        <a href="#" class="col-6 block count_btn">
            <p class="text-center text-muted">フォロー</p>
            <?php $follow_count = $follow->followCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo $follow_count['COUNT(*)']; ?></p>
        </a>
        <a href="#" class="col-6 block count_btn">
            <p class="text-center text-muted">フォロワー</p>
            <?php $followed_count = $follow->followedCount($login_user['id']); ?>
            <p class="text-center h4"><?php echo $followed_count['COUNT(*)']; ?></p>
        </a>

    </div>
</article>
