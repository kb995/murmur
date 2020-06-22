<header class="header bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <span><i class="fa fa-comments" aria-hidden="true"></i></span>
        <span class="navbar-brand mb-0 h1">BBS</span>
        <!-- <h1><a class="navbar-brand" href="#">POSTIT</a></h1> -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php //if(empty($_SESSION['login_flg'])): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">TOP</a></li>
                <li class="nav-item"><a class="nav-link" href="mypage.php">MYPAGE</a></li>
                <li class="nav-item"><a class="nav-link" href="signup.php">SIGNUP</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">LOGIN</a></li>
                <li class="nav-item"><a class="nav-link" href="post.php">POST</a></li>
            </ul>
        <?php //else: ?>
            <!-- <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">TOP</a></li>
                <li class="nav-item"><a class="nav-link" href="post.php">POST</a></li>
                <li class="nav-item"><a class="nav-link" href="mypage.php">MYPAGE</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
            </ul> -->
        <?php //endif; ?>
        </div>
    </nav>
</header>