<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->request->session()->read('Campaign.name') ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    $this->prepend('css', $this->Html->css([
        'dist/css/bootstrap.min',
        'dist/css/messenger',
        'dist/css/messenger-theme-flat',
        'dist/css/font-awesome.min'
    ]));
    $this->append('css', $this->Html->css([
        'fonts/fonts',
        'front/css/style-default',
        'front/css/background-style-default'
    ]));

    echo $this->fetch('css');
    ?>

</head>
<body>
<?= $this->element('header'); ?>
<div class="container">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<?php
$this->Html->scriptStart(['block' => true]);
echo 'var webroot = "' . $this->request->webroot . '";';
$this->Html->scriptEnd();

echo $this->prepend('script', $this->Html->script([
    'dist/js/jquery-3.1.1.min',
    'dist/js/bootstrap.min',
    'dist/js/messenger.min',
    'dist/js/messenger-theme-flat',
    'front/js-min/default'
]));

echo $this->append('script', $this->Html->script([
//    'front/js/formLogin'
]));

echo $this->fetch('script');
echo $this->fetch('scriptCustom');
?>
</body>
</html>
