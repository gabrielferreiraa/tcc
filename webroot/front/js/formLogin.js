$(document).ready(function (e) {
    var logar = function () {
        const url = webroot + 'home/sign-in';
        const data = $('#formLogin').serializeArray();
        console.log(url);

        $.post(url, data, function (json) {
            if (json.result.status === 'success') {
                Messenger().post({
                    message: json.result.title,
                    type: 'success',
                    showCloseButton: true
                });
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