<?php
require_once('../config/app.php');

class PagingController {
    public $per_page_post = 5; // 1ページ毎の表示件数
    public $page; // 現在のページ
    public $total_posts; // 投稿総数
    public $offset; // 表示開始位置
    public $total_pages; // ページ総数
    public $pre_path;

    function __construct() {
        // 投稿総数セット
        $dbh = dbConnect();
        $this->total_posts = $dbh->query('SELECT COUNT(*) FROM posts')->fetchColumn(); // 投稿総数

        // 現在のページ位置セット
        if( isset($_GET['page'])) {
            $this->page = (int)$_GET['page']; // 現在のページ
        } else {
            $this->page = 1;
        }

        // 投稿の取得開始位置
        $this->offset = $this->per_page_post * ( $this->page - 1 );

        // ページ総数セット
        $this->total_pages = ceil($this->total_posts / $this->per_page_post); // ページ総数

        // ページ種類判別
        // $aaa = basename($_SERVER['PHP_SELF']);
        // echo "<pre>"; var_dump($aaa); echo"</pre>";

        switch(basename($_SERVER['PHP_SELF'])) {
            case 'mypage.php':
                $this->pre_path = 'mypage.php';
            break;
            // case '.php':
            //     $this->pre_path = '.php';
            // break;
            // case 'mypage.php':
            //     $this->pre_path = '.php';
            // break;
        }
    }

}
