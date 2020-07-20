
<button type="button" class="btn-danger" data-toggle="modal" data-target="#Modal">
    <i class="fas fa-trash-alt "></i>
    <span>削除</span>
</button>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="Modal">この記事を削除しますか?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $post['text']; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        <button form="delete"　type="button" class="btn btn-danger">削除する</button>
      </div>
    </div>
  </div>
</div>

<form action="" method="post" id="delete">

</form>