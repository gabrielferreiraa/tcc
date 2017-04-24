$(document).ready(function(){
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    };

    $(document).on('click', '.btn-toggle', openDrawer);
    $(document).on('click', '.send-message', sendMessage);
    $(document).on('keyup', '.message', enableBtn);

    var heightAside = $('.profile-informations').height();
    $('.content-wrapper').css('minHeight', heightAside + 'px');

    function sendMessage () {
        $('#message').modal('hide');

        const url = webroot + 'messages/new-messeger';
        var data = {
            message: $('.message').val(),
            id: $(this).data('id')
        };

        $.post(url, data, function(e){
            if(e.result.status === 'success'){
                Messenger().post({
                    message: 'Hey, você pode acompanhar suas mensagens na aba "Mensagens"',
                    type: 'info',
                    showCloseButton: true
                });
            } else {
                Messenger().post({
                    message: 'Não foi possível enviar sua mensagem',
                    type: 'error',
                    showCloseButton: true
                });
            }
        }, 'json');
    }

    function enableBtn () {
        if($(this).val() != ''){
            $('.modal-footer').find('button').attr('disabled', false);
        } else {
            $('.modal-footer').find('button').attr('disabled', true);
        }
    }

    function openDrawer(){
        $(this).toggleClass('open-drawer');
        $('.profile-informations').toggleClass('open-drawer');
    }
});