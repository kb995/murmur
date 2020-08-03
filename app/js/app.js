// スライドメニュー
(function() {
    'use strict';

    var show = document.getElementById('show');
    var hide = document.getElementById('hide');

    show.addEventListener('click', function() {
      document.body.className = 'menu-open';
    });

    hide.addEventListener('click', function() {
      document.body.className = '';
    });
  })();

  // 文字数カウント
  (function() {
    'use strict';

    var comment = document.getElementById('comment');
    var label = document.getElementById('label');

    var LIMIT = 300;
    var WARNING = 30;

    label.innerHTML = LIMIT;

    comment.addEventListener('keyup', function() {
        var remaining = LIMIT - this.value.length;
        label.innerHTML = remaining;
        if (remaining < WARNING) {
            label.className = 'count_warning';
        } else {
            label.className = '';
        }
        if(remaining < 0) {
            label.className = 'count_danger';
        }
    });
  })();
