<div class="modal fade" id="skills" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">HABILIDADES</h4>
            </div>
            <div class="modal-body">
                <input type="text" id="input-search-skills" placeholder="Procure por habilidades..." class="input-search-skills">

                <div class="wrapper">
                    <?php foreach($skills as $key => $skill): ?>
                        <label class="check-type check-type-modal">
                            <input type="checkbox" name="skills[]" class="input-checkbox" value="<?= $skill ?>" <?= in_array($skill, $skillsQuery) ? 'checked' : '' ?>/>
                            <div class="wrap-check"></div><?= $skill ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-padrao">FILTRAR</button>
            </div>
        </div>
    </div>
</div>