<?php
$this->Paginator->templates([
    'ellipsis' => '<li class="disabled"><a>...</a></li>'
]);
?>
<ul class="pagination pagination-sm no-margin pull-left">
    <?= $this->Paginator->prev('<i class="fa fa-angle-left"></i>', array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a')) ?>
    <?= $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'last' => 1, 'modulus' => 6)) ?>
    <?= $this->Paginator->next('<i class="fa fa-angle-right"></i>', array('escape' => false, 'tag' => 'li', 'currentClass' => 'disabled'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a')) ?>
</ul>