<?php if (count($skills)): ?>
    <article class="skills">
        <h3 class="title-section">COMPETÊNCIAS</h3>
        <ul class="skills-list light">
            <?php foreach ($skills as $skill): ?>
                <li><?= $skill['skill']['name'] ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
<?php endif; ?>