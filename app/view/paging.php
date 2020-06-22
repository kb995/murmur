
 <?php
 // ページング
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
?>

<div class="text-center">
    <?php if($page >= 2): ?>
        <a class="pl-5 paging" href="<?php if(basename(__FILE__) == 'index') { echo 'index'; } elseif(basename(__FILE__) == 'mypage') { echo 'mypage';  } ?>?page=<?php echo $page - 1; ?>">&lt;<?php echo $page - 1; ?>ページ目</a>
    <?php endif; ?>
    <?php
        $dbh = dbConnect();
        $stmt = $dbh->query('SELECT COUNT(*) FROM posts WHERE delete_flg = 0');
        $page_count = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_page = ceil($page_count['COUNT(*)'] / 5);
        if($page < $max_page):
    ?>
    <a class="pl-5 paging" 
    href="<?php if(basename(__FILE__) == 'index') {echo 'index';} elseif(basename(__FILE__) == 'mypage') {echo 'mypage';  } ?>?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目&gt;</a>
    <?php endif; ?>
</div>