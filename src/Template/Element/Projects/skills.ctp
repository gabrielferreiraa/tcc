<?php
    $skillsQuery = !empty($this->request->query('skills')) ? $this->request->query('skills') : [];
?>
<h5 class="title-item">Habilidades</h5>
<div class="wrapper">
    <?php foreach ($skills as $key => $skill): ?>
        <label class="check-type">
            <input type="checkbox" name="skills[]" class="input-checkbox" value="<?= $skill ?>" <?= in_array($skill, $skillsQuery) ? 'checked' : '' ?>/>
            <div class="wrap-check"></div><?= $skill ?>
        </label>
    <?php endforeach; ?>
</div>
<button type="button" class="btn btn-padrao btn-more-skills">mais habilidades</button>

<?= $this->element('Projects/modal-skills', ['skillsQuery' => $skillsQuery]); ?>
