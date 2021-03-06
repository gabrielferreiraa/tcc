$(document).ready(function () {
    $('#skills-ids').select2({
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            switch (markup) {
                case 'Please enter 1 or more characters':
                    return 'Informe 1 ou mais caracteres';
                    break;
                case 'Searching…':
                    return 'Procurando...';
                    break;
                case 'No results found':
                    return 'Nada encontrado';
                    break;
                default :
                    return markup;
                    break;
            }
        },
        language: {
            'noResults': function () {
                return 'Habilidade não encontrada';
            }
        }
    });

    function populateCities() {
        const url = webroot + 'utils/populate-cities';
        const data = {
            state: $(this).val()
        };

        $.post(url, data, function (response) {
            var selectCity = $('#city-id');
            var html = '';

            $.each(response.result.data, function (index, item) {
                html += '<option value="' + index + '">' + item + '</option>';
            });
            selectCity.html(html);
        }, 'json');
    }

    function populateAddress() {
        const cep = $('#cep').val().replace('-', '');

        $.get('http://api.postmon.com.br/v1/cep/' + cep, function (e) {
            var elState = $('#state-id');
            var elCity = $('#city-id');

            var states = elState.find('option');
            var cities = elCity.find('option');

            states.map(function (index, item) {
                if (item.text.toLowerCase() == e.estado_info.nome.toLowerCase()) {
                    elState.val(index);
                    elCity.trigger('change');
                }
            });

            cities.map(function (index, item) {
                if (item.text.toLowerCase() == e.cidade.toLowerCase()) {
                    elCity.val(index);
                    elCity.trigger('change');
                }
            });

            if (typeof e.logradouro !== 'undefined') {
                $('#street').val(e.logradouro);
            }
        });
    }

    function openFile() {
        $('#picture-image').trigger('click');
    }

    function changeImgUser(e) {
        readURL(this.files);
    }

    function readURL(input) {
        if (input && input[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.img-user').attr('src', e.target.result);
                $('#picture').val(e.target.result);
            };
            reader.readAsDataURL(input[0]);
        }
    }

    var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        optionsMask = {
            onKeyPress: function(val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
        };

    $('#cel-phone').mask(maskBehavior, optionsMask);
    $('#cep').mask('00000-000');

    $('#state-id').change(populateCities);
    $('.btn-buscar-cep').click(populateAddress);
    $('.img-user').click(openFile);
    $('#picture-image').change(changeImgUser);
});