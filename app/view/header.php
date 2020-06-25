<header class="header bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <span><i class="fa fa-comments" aria-hidden="true"></i></span>
        <span class="navbar-brand mb-0 h1">BBS</span>
        <!-- <h1><a class="navbar-brand" href="#">POSTIT</a></h1> -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if(empty($_SESSION['login_flg'])): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="signup.php">サインアップ</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">ログイン</a></li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="mypage.php">マイページ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">メニュー</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>

                <!-- メニュー ログアウト / プロフィール編集 / 退会 -->
            </ul>
        <?php endif; ?>
        </div>
    </nav>
</header>