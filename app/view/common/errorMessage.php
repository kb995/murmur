<!-- エラー表示 -->
<?php if(!empty($error_msgs)): ?>
    <div class="card p-3">
        <ul>
            <?php foreach($error_msgs as $error_msg): ?>
                <li class="text-danger"><?php echo $error_msg; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>