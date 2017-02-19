$(document).ready(function () {
    function validPassword(e) {
        const pass = $('#password');
        const rPass = $('#repeat-password');
        if ((pass.val() !== '') && (rPass.val() !== '')) {
            if (pass.val() == rPass.val()) {
                pass.addClass('required-input-ok');
                rPass.addClass('required-input-ok');
                $('.rule-inputs').text('preencha todos os campos');
                if ($('#name').val() !== '') {
                    $('.rule-inputs').hide();
                    $('.create-account-div').css('opacity', 1);
                }
            }
        } else {
            $('.rule-inputs').text('repita a senha');
        }
    }

    function _isValid() {
        if(($('#password').val() !== '') && $('#repeat-password').val() !== ''){
            return $('#password').val() == $('#repeat-password').val();
        } else {
            return false;
        }
    }

    function signIn(){
        const data = $('#formUsers').serializeArray();
        const url = webroot + 'users/saveUser';

        $.post(url, data, function(e){
            if(e.result.status == 'success'){
                Messenger().post({
                    message: e.result.text,
                    type: 'success',
                    showCloseButton: true
                });
                $('.section-form').addClass('finished-form');
                window.location = webroot + 'projetos';
            } else {
                Messenger().post({
                    message: e.result.text,
                    type: 'error',
                    showCloseButton: true
                });
            }
        }, 'json');
    }

    $(document).on('click', '.next-step', function () {
        window.location = webroot + 'users/add/' + btoa($(this).data('type') + '#' + $('#email').val());
    });

    $(document).on('keyup', '#password', function () {
        if ($(this).val().length >= 4) {
            $('#repeat-password').attr('disabled', false);
        } else {
            $('#repeat-password').attr('disabled', true);
        }
    });

    $(document).on('click', '.create-account', signIn);
    $(document).on('keyup', '#repeat-password', validPassword);
    $(document).on('keyup', '#password', validPassword);
    $(document).on('keyup', '#name', function (e) {
        if ($(this).val() !== '') {
            if (_isValid()) {
                $('.rule-inputs').hide();
                $('.create-account-div').css('opacity', 1);
            }
        }
    });
});
