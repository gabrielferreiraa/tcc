$(document).ready(function (e) {
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    };

    var logar = function (e) {
        const self = $(this);

        $(this).html('entrando');
        $(this).attr('disabled', true);

        const url = webroot + 'home/sign-in';
        const data = $('#formLogin').serializeArray();

        $.post(url, data, function (json) {
            self.html('validando usuário');

            if (json.result.status === 'success') {
                self.html('usuário encontrado');
                Messenger().post({
                    message: json.result.title,
                    type: 'success',
                    showCloseButton: true
                });
                setTimeout(function () {
                    window.location = webroot + 'projetos';
                }, 1000);
            } else {
                Messenger().post({
                    message: json.result.title,
                    type: 'error',
                    showCloseButton: true
                });
                self.html('entrar');
                self.attr('disabled', false);
            }
        }, 'json');
    };

    $(document).on('keyup', function (e) {
        e.keyCode == 13 ? logar(e) : false;
    });
    $(document).on('click', '.login', logar);
});