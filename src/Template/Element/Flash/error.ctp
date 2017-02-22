<?php $this->start('errorScripts'); ?>
<script>
    $(document).ready(function () {
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'flat'
        };
        Messenger().post({
            message: '<?= $message ?>',
            type: 'error',
            showCloseButton: true
        });
    });
</script>
<?php
$this->end();
$this->append('scriptCustom', $this->fetch('errorScripts'));
?>
