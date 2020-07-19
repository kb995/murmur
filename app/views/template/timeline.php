<section>
    <h2 class="text-center h3 my-3">タイムライン</h2>
    <?php foreach($current_posts as $post): ?>
        <div class="mx-auto card my-3 p-4">
            <!-- サムネイル(仮) -->
            <div class="thumb" style="background: gray; width:50px; height:50px;"></div>
            <p class="pt-2">
                <a href="#"><?php echo $post['name']; ?></a>
            </p>
            <!-- 記事操作ボタン / いいね -->
            <div class="row">
                <!-- ログイン判定 -->
                <!-- いいねボタン -->
                <!-- 編集 -->
                <a class="px-3" href="postEdit.php?post_id=<?php echo $post['id']; ?>">
                    <i class="fas fa-edit "></i>
                    <span class="">編集</span>
                </a>
                <!-- 削除 -->
                <a class="mr-auto" href="#">
                    <i class="fas fa-trash-alt "></i>
                    <span class="">削除</span>
                </a>

                <span class="ml-auto pr-3"><?php echo $post['created_at']; ?></span>
            </div>

            <div style="border: solid 1px gray;" class="my-2"></div>
            <p class="p-3"><?php echo $post['text']; ?></a></p>

        </div>
    <?php endforeach; ?>
</section>