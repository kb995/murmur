
<header class="header">
    <nav class="navbar navbar-expand-lg container">
        <h1 class="logo">
            <a class="navbar-brand" href="mypage.php">
            <a href="/"><img src="https://fontmeme.com/permalink/200814/5b2c524e722487b20ff9f6e220076a3f.png" alt="sharp-core-font" border="0"></a>        </h1>
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
                    <li class="nav-item"><a class="nav-link" id="show">メニュー</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>
                </ul>
                <?php endif; ?>
            </div>

            <!-- スライドメニュー -->
            <ul id="menu">
                <!-- ✗ ボタン -->
                <i class="fas fa-times text-secondary h2" id="hide"></i>
                <li><a href="mypage.php">マイページ</a></li>
                <li><a href="profEdit.php">プロフィール編集</a></li>
                <li><a href="logout.php">ログアウト</a></li>
                <li><a id="withdraw_btn">退会</a></li>
            </ul>
            <section class="card hidden" id="withdraw_modal">
                <p class="text-center text-danger">本当に退会しますか？</p>
                <p class="mb-2"><a href="mypage.php?action=withdraw">退会する</a></p>
                <button id="close">閉じる</button>
            </section>

    </nav>
</header>
<!-- カバー -->
<div class="hidden" id="cover"></div>
