
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
                    <!-- openボタン -->
                    <li class="nav-item"><a class="nav-link" href="#" id="show">メニュー</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>
                </ul>
                <?php endif; ?>
            </div>

            <!-- スライドメニュー -->
            <ul id="menu">
                <!-- ✗ ボタン -->
                <i class="fas fa-times text-secondary h2" id="hide"></i>
                <li><a href="">マイページ</a></li>
                <li><a href="">プロフィール編集</a></li>
                <li><a href="">ログアウト</a></li>
                <li><a href="">退会</a></li>
            </ul>

    </nav>
</header>
<!-- グレーカバー -->
<div id="cover"></div>
