<?php $onlineUser = $this->request->session()->read('Auth.User.id'); ?>
<div class="container wrapper-all">
    <div class="wrapper">
        <section class="content">
            <aside>
                <ul class="contacts">
                    <?php foreach ($messages as $indicators): ?>
                        <?php
                            $userType = $onlineUser == $indicators->users_to->id ? 'users_from' : 'users_to';
                            $imageUserMessage = !empty($indicators->{$userType}->picture) ? $this->Url->build($indicators->{$userType}->picture, true) : $this->Url->build('/front/img/user-default.png', true);
                        ?>
                        <a href="#<?= $indicators->id ?>">
                            <li>
                                <img src="<?= $imageUserMessage ?>"/>
                                <span>
                                    <?= $indicators->{$userType}->name ?>
                                </span>
                                <?php
                                    if(date('Y-m-d') == $indicators->date->i18nFormat('YYYY-MM-dd')) {
                                        ?>
                                        <span>última mensagem as <?= $indicators->date->i18nFormat('H:mm'); ?></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span>última mensagem dia <?= $indicators->date->i18nFormat('dd/MM'); ?></span>
                                        <?php
                                    }
                                ?>
                                <i class="fa fa-circle online"></i>
                            </li>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </aside>
            <?php foreach ($messages as $message): ?>
                <?php
                    $imageUserMessage = !empty($message->{$userType}->picture) ? $this->Url->build($message->{$userType}->picture, true) : $this->Url->build('/front/img/user-default.png', true);
                ?>
                <section id="<?= $message->id ?>" data-message="<?= $message->id ?>" class="messages-text">
                    <div class="user-informations">
                        <img src="<?= $imageUserMessage ?>" class="img-responsive img-user-message hidden-md hidden-lg hidden-sm">
                        <h1><?= $message->{$userType}->name ?></h1>
                    </div>
                    <?php foreach ($message->message_records as $record) { ?>
                        <?php if ($record->user_id == $onlineUser): ?>
                            <div class="row">
                                <div class="bubble-right">
                                    <div class="informations">
                                        <span>
                                            <?= $record->text ?>
                                        </span>
                                        <i class="italic">19:32</i>
                                    </div>
                                    <figure>
                                        <img src="<?= $userPicture ?>" />
                                    </figure>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="row">
                                <div class="bubble-left">
                                    <figure>
                                        <img src="<?= $imageUserMessage ?>" />
                                    </figure>
                                    <div class="informations">
                                        <span>
                                            <?= $record->text ?>
                                        </span>
                                        <i class="italic">19:32</i>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </section>
            <?php endforeach; ?>
        </section>
        <section class="message">
            <input type="text" id="message" class="new-message" placeholder="Escreva sua mensagem..."/>
            <button id="send" class="send-message">Enviar</button>
        </section>
    </div>
</div>
<script>
    var userPicture = '<?= $userPicture ?>';
</script>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/messages'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/messages'
]));
?>