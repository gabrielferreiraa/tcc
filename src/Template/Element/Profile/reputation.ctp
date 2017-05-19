<h3>
    <?php if (!isset($display)): ?>
        Reputação
    <?php endif; ?>

    <?php
    if (isset($reputation['qtd'])) {
        if ($reputation['qtd'] == 0) {
            $textTooltip = 'Nenhuma avaliação';
        } else if ($reputation['qtd'] == 1) {
            $textTooltip = 'Avaliado por 1 pessoa';
        } else {
            $textTooltip = 'Avaliado por ' . $reputation['qtd'] . ' pessoas';
        }
    } else {
        $textTooltip = '';
    }
    ?>

    <div class="stars-reputation" title="<?= $textTooltip ?>">
        <?= str_repeat('<i class="fa fa-star"></i>', isset($reputation['grade']) ? $reputation['grade'] : 0) ?>
        <?= str_repeat('<i class="fa fa-star-o"></i>', 5 - $reputation['grade']) ?>
    </div>
</h3>