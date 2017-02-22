<h5 class="title-item">Habilidades</h5>
<div class="wrapper">
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox" value="scss"/>
        <div class="wrap-check"></div>SCSS
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox" value="foundation"/>
        <div class="wrap-check"></div>Foundation
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox" value="html"/>
        <div class="wrap-check"></div>HTML
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox" value="css"/>
        <div class="wrap-check"></div>CSS
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox"/>
        <div class="wrap-check"></div>JavaScript
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox"/>
        <div class="wrap-check"></div>jQuery
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox"/>
        <div class="wrap-check"></div>SASS
    </label>
    <label class="check-type">
        <input type="checkbox" name="skills[]" class="input-checkbox"/>
        <div class="wrap-check"></div>Bulma.io
    </label>
</div>
<button type="button" class="btn btn-padrao btn-more-skills">mais habilidades</button>

<?= $this->element('Projects/modal-skills'); ?>
