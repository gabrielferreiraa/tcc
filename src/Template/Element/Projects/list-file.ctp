<?php foreach ($files as $file): ?>
    <li>
        <div class="type" title="<?= 'Arquivo .' . $file->ext ?>"><?= \App\Lib\Utils::getIconFile($file->ext) ?></div>
        <?php
        list($path, $path2, $fileName) = explode('/', $file->file);
        ?>
        <p class="normal" title="<?= $fileName ?>">
            <?php if (!isset($showAll)): ?>
                <?= strlen($fileName) > 20 ? substr($fileName, 0, 13) . ' ...' : substr($fileName, 0, 13); ?>
            <?php else: ?>
                <?= $fileName ?>
            <?php endif; ?>
        </p>
        <a href="<?= $this->Url->build('/' . $file->file, true); ?>" title="Clique para download    "
           download>
            <i class="fa fa-cloud-download"></i>
        </a>
    </li>
<?php endforeach; ?>