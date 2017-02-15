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
        'AQUI BOOTSTRAP'
    ]));
    $this->append('css', $this->Html->css([
        'fonts/fonts',
        'front/css/login'
    ]));

    echo $this->fetch('css');
    ?>

</head>
<body>

<div class="container">
    <section>
        <div class="logo">
            <img src="https://www.childrenslearninginstitute.org/assets/aoes/aoe-logo.png" width="220" />
        </div>
        <div class="inputs">
            <div class="email">
                <input type="text" id="email" autocomplete="off" required/>
                <label for="email">Email</label>
            </div>
            <div class="password">
                <input type="password" id="password" autocomplete="off" required/>
                <label for="password">Password</label>
            </div>
        </div>
        <div class="buttons">
            <button>login</button>
            <a href="javascript:void(0)">esqueci minha senha</a>
        </div>
    </section>
</div>

<?php
$this->Html->scriptStart(['block' => true]);
echo 'var webroot = "' . $this->request->webroot . '";';
$this->Html->scriptEnd();

echo $this->prepend('script', $this->Html->script([
    'JQUERY E BOOTSTRAP'
]));

echo $this->append('script', $this->Html->script([

]));

echo $this->fetch('script');
echo $this->fetch('scriptCustom');
?>
</body>
</html>
