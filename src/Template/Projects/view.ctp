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
                        <div id="prazos" class="tab-pane fade in active">
                            <h3>PRAZOS</h3>
                        </div>
                        <div id="projetos" class="tab-pane fade">
                            <h3>PROJETOS</h3>
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
                                <li>
                                    <a data-toggle="pill" href="#projetos"  class="item-set projeto">Projeto</a>
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