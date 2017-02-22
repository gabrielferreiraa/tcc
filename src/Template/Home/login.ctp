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