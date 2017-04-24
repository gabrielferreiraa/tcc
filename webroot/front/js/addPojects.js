$(document).ready(function() {
    $('#skill-ids').select2({
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
    })