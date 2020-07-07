<!-- プロフカード -->
<div class="card p-5 mb-5 mx-auto">
    <h3 class="pb-3 text-center h5 text-muted">プロフィール</h3>
    <div class="m-auto" style="width:150px;height:150px;background-color:white;"></div>
    <p class="text-center pt-2 h4"><a href="mypage.php"><?php echo $login_user['name']; ?></a></p>
    <p><?php echo $login_user['profile']; ?></p>

    <a href="editProf.php?login_id=<?php echo $login_user['id']; ?>" type="button" class="btn btn-white mb-4">プロフィール編集</a>

    <div class="my-3 row">
        <a class="col-6 block count_btn" href="myPost.php">
            <p class="text-center text-muted">投稿数</p>
            <p class="text-center h4"><?php echo $count_data['post']['COUNT(*)']; ?></p>
        </a>
        <a href="likeList.php?location=mypage" class="col-6 block count_btn">
            <p class="text-center text-muted">いいね</p>
            <p class="text-center h4"><?php echo $count_data['like']['COUNT(*)']; ?></p>
        </a>
    </div>
    <div class="my-3 row">
        <a href="followList.php?location=mypage" class="col-6 block count_btn">
            <p class="text-center text-muted">フォロー</p>
            <p class="text-center h4"><?php echo $count_data['follow']['COUNT(*)']; ?></p>
        </a>
        <a href="#" class="col-6 block count_btn">
            <p class="text-center text-muted">フォロワー</p>
            <p class="text-center h4"><?php echo $count_data['followed']['COUNT(*)']; ?></p>
        </a>
    </div>
</div>