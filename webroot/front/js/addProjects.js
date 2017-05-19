$(document).ready(function () {

    const options = {
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
    };

    $('#skills-ids').select2(options);

    $('.btn-anexos').click(function (e) {
        e.preventDefault();
        $('#project_files').trigger('click');
    });

    $('#project_files').change(function () {
        var list = '';

        const files = $('#project_files')[0].files;

        for (var i in files) {
            if (typeof files[i].name !== 'undefined' && files[i].name !== 'item') {
                list += '<li>' + files[i].name + '<a href="#" class="delete-file" onclick="deleteFile('+ i +')"><i class="fa fa-trash-o"></i></a></li>';
            }
        }

        $('.files-list').html(list);
    });
});