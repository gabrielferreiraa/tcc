<h3>
    <?php if (!isset($display)): ?>
        Reputação
    <?php endif; ?>

    <div class="stars">
        <?= str_repeat('<i class="fa fa-star"></i>', $reputation) ?>
        <?= str_repeat('<i class="fa fa-star-o"></i>', 5 - $reputation) ?>
    </div>
</h3>