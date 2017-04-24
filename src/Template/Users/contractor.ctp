<div class="container">
    <div class="row control-page-div">
        <div>
            <a href="<?= $this->Url->build('/', true); ?>" class="control-page">
                página inicial
            </a>
            / contratante
        </div>
    </div>
    <div class="row">
        <div class="input-group input-group-lg big-input-div">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input
                type="text"
                id="email"
                class="big-input"
                autocomplete="off"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                placeholder="digite seu e-mail...">
        </div>
    </div>
    <div class="row next-step-div">
        <a href="javascript:void(0)" class="next-step" data-type="contractor">
            PRÓXIMO <i class="fa fa-arrow-circle-o-right"></i>
        </a>
    </div>
    <div class="row">
        <h1 class="register-contractor">Cadastre-se como contratante</h1>
    </div>
</div>
<?= $this->element('footer'); ?>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/users-contractor'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/formUsers'
]));
?>
