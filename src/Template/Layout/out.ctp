<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->request->session()->read('Campaign.name') ?></title>
    <!-- Tell the browser to be responsive to screen width -->
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
        'front/css/login'
    ]));

    echo $this->fetch('css');
    ?>

</head>
<body>
<?= $this->Flash->render() ?>
<div class="container">
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
    'front/js/default'
]));

echo $this->append('script', $this->Html->script([
    'front/js/formLogin'
]));

echo $this->fetch('script');
echo $this->fetch('scriptCustom');
?>
</body>
</html>
