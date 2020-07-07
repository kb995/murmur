<p class="text-center py-4">
    <?php if($page >= 2): ?>
        <div class="text-left">
            <a class="pl-5 paging" href="mypage?page=<?php echo $page - 1; ?>">
             &lt; <?php echo $page - 1; ?> ページ目
            </a>
        </div>
    <?php endif; ?>
    <?php
        $dbh = dbConnect();
        $stmt = $dbh->query('SELECT COUNT(*)
                             FROM posts 
                             WHERE delete_flg = 0'
                             );
        $page_count = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_page = ceil($page_count['COUNT(*)'] / 5);
        if($page < $max_page):
    ?>
    <div class="text-right">
        <a class="pl-5 paging" href="mypage?page=<?php echo $page + 1; ?>">
            <?php echo $page + 1; ?> ページ目 &gt;
        </a>
    </div>
    <?php endif; ?>
</p>