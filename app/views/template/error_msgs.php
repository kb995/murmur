    <?php
    if($_POST) {
        if(!empty($_SESSION['error_msgs'])) {
            $error_msgs = $_SESSION['error_msgs'];
            // echo "<pre style='color: #fff;'>"; var_dump($error_msgs); echo"</pre>";
            // exit;
            unset($_SESSION['error_msgs']);
        }
    }
    ?>

    <?php if(!empty($error_msgs)): ?>
        <div class="card p-3">
            <ul>
                <?php foreach($error_msgs as $error_msg): ?>
                    <li class="text-danger"><?php echo $error_msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
