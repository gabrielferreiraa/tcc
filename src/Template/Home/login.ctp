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
        'front/css/login'
    ]));

    echo $this->fetch('css');
    ?>

</head>
<body>

<?= $this->Flash->render() ?>
<?= $this->Form->create(null, ['id' => 'formLogin', 'autocomplete' => 'off']) ?>
<div class="container wrapper">
    <div class="row btn-voltar-section hidden-xs">
        <a href="<?= $this->Url->build('/', true); ?>" class="btn-padrao btn-voltar">VOLTAR</a>
    </div>
    <section>
        <div class="logo">
            <img src="https://www.childrenslearninginstitute.org/assets/aoes/aoe-logo.png" width="220"/>
        </div>
        <div class="inputs">
            <div class="email">
                <input type="text" id="email" autocomplete="off" name="email" required/>
                <label for="email">e-mail</label>
            </div>
            <div class="password">
                <input type="password" id="password" autocomplete="off" name="password" required/>
                <label for="password">senha</label>
            </div>
        </div>
        <a href="javascript:void(0)" class="login">entrar</a>
        <a href="javascript:void(0)" class="esqueci">esqueci minha senha</a>
    </section>
</div>
<?= $this->Form->end(); ?>
</body>
<?= $this->element('footer'); ?>
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
</html>
