<nav aria-label="Page navigation">
    <ul class="pagination">
        <!-- 前へ -->
        <?php if($paging->page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $paging->pre_path; ?>?page=<?php echo $paging->page-1; ?>">前へ</a>
            </li>
        <?php endif; ?>

        <!-- ページ数ループ -->
        <?php for($i = 1; $i <= $paging->total_pages; $i++): ?>
            <?php if($paging->page == $i): ?>
                <li class="page-item active">
                    <strong><a class="page-link" href="<?php echo $paging->pre_path; ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></strong>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $paging->pre_path; ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- 次へ -->
        <?php if($paging->page < $paging->total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $paging->pre_path; ?>?page=<?php echo $paging->page+1; ?>">次へ</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>


<?php
 $from = $paging->offset + 1; // 〇〇件中
 $to = ($paging->offset + $paging->per_page_post) < $paging->total_posts ? ($paging->offset + $paging->per_page_post) : $paging->total_posts; // 〇〇件まで表示
?>
<!-- // 件数表示 -->
<p>全<?php echo $paging->total_posts; ?>件中、<?php echo $from; ?>件~<?php echo $to; ?>件を表示中</p>
