<div class="modal fade" id="<?= isset($id) ? $id : 'id-padrao-modal' ?>" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $titleHead ?></h4>
            </div>
            <div class="modal-body">
                <?= isset($content) ? $content : '' ?>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-padrao <?= isset($btnClass) ? $btnClass : '' ?>"
                    <?php foreach ($attrs as $k => $v): ?>
                        <?= $k . "='" . $v . "'" ?>
                    <?php endforeach; ?>
                >
                    <?= isset($textBtn) ? $textBtn : 'OK' ?>
                </button>
            </div>
        </div>
    </div>
</div>