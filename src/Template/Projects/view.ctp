<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
            <div class="status">
                fechado
            </div>
            <h4 class="panel-title">
                Collapsible Group 1
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse in">
            <section class="content">
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="prazos" class="tab-pane fade">
                            <h3>PRAZOS</h3>
                        </div>
                        <div id="projeto" class="tab-pane fade in active projeto">
                            <div class="top-informations">
                                <span>Orçamento: R$ 5.000,00</span>
                                <button class="btn btn-circle open-partner"><i class="fa fa-user"></i></button>
                                <button class="btn btn-circle open-anexo"><i class="fa fa-paperclip"></i></button>
                            </div>
                            <div class="skills">
                                <span class="normal">Habilidades Necessárias:</span>
                                <ul class="skills-list light">
                                    <li>NodeJS</li>
                                    <li>HTML</li>
                                </ul>
                            </div>
                            <div class="description">
                                <span class="normal">Descrição:</span>
                                <p class="normal">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a condimentum ligula. Donec sapien mi, ullamcorper nec facilisis sit amet, tristique quis velit. Fusce quis lectus imperdiet odio scelerisque tempus. Phasellus a lectus erat. Vivamus erat erat, elementum at ipsum quis, consequat pretium enim. In quis consectetur metus. Aliquam ultrices massa sed leo dignissim semper. Vivamus laoreet elit pretium erat finibus, viverra dictum ligula tristique. Nunc aliquam vehicula neque ut mollis.
                                </p>
                            </div>
                        </div>
                        <div id="avaliacao" class="tab-pane fade">
                            <h3>AVALIAÇÃO</h3>
                        </div>
                        <div id="time-line" class="tab-pane fade">
                            <h3>TIME LINE</h3>
                        </div>
                    </div>
                </div>
                <aside class="bar-right">
                    <div>
                        <nav class="collapse navbar-collapse">
                            <ul class="itens">
                                <li>
                                    <a data-toggle="pill" href="#prazos" class="item-set prazos">Prazos</a>
                                </li>
                                <li class="active">
                                    <a data-toggle="pill" href="#projeto"  class="item-set projeto">Projeto</a>
                                </li>
                                <li>
                                    <a data-toggle="pill" href="#avaliacao" class="item-set avaliacao">Avaliação</a>
                                </li>
                                <li>
                                    <a data-toggle="pill" href="#time-line" class="item-set time-line">Time Line</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>
            </section>
        </div>
    </div>
</div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/my-projects'
]));
?>