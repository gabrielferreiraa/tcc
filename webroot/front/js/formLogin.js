$(document).ready(function (e) {
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    };
            
    var logar = function () {
        const url = webroot + 'home/sign-in';
        const data = $('#formLogin').serializeArray();

        $.post(url, data, function (json) {
            if (json.result.status === 'success') {
                Messenger().post({
                    message: json.result.title,
                    type: 'success',
                    showCloseButton: true
                });
                setTimeout(function(){
                    window.location = webroot + 'projetos';
                }, 1000);
            } else {
                Messenger().post({
                    message: json.result.title,
                    type: 'error',
                    showCloseButton: true
                });
            }
        }, 'json');
    };

    $(document).on('click', '.login', logar);
});