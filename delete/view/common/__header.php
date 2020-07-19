<header class="header">
    <nav class="navbar navbar-expand-lg container">
        <h1 class="logo">
            <a class="navbar-brand" href="mypage.php">
                <i class="fa fa-comments pl-2" aria-hidden="true"></i>
                MURMUR
            </a>
        </h1>
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
                    <li class="nav-item"><a class="nav-link" href="common/logout.php">ログアウト</a></li>
                    <!-- メニュー ログアウト / プロフィール編集 / 退会 -->
                </ul>
            <?php endif; ?>
        </div>
    </nav>
</header>