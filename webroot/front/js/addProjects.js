$(document).ready(function () {
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    };
    moment.locale('pt-br');


    $('#date-end').mask('00/00/0000', {
        onComplete: function (budget) {
            var currentData = moment().format('DD/MM/YYYY');
            var diffDays = moment(budget,"DD/MM/YYYY").diff(moment(currentData,"DD/MM/YYYY"), 'days');

            if(diffDays >= 0) {
                openToast(budget, diffDays * 8);
            } else {
                Messenger().post('A data de entrega escolhida é inválida');
            }
        }
    });

    $('#budget').mask("#.##0,00", {
        reverse: true
    });

    var openToast = function(text, hours) {
        var msg;
        msg = Messenger().post({
            message: 'Você escolheu como data de entrega para este projeto, o dia <b>' + text + '</b>, sendo equivalente a <b>' + hours + ' horas</b> de trabalho',
            type: 'info',
            actions: {
                cancel: {
                    label: 'Confirmar',
                    action: function() {
                        return msg.update({
                            message: 'Data de entrega definida com sucesso',
                            type: 'success',
                            actions: false
                        });
                    }
                }
            }
        });
    };


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
                list += '<li>' + files[i].name + '<a href="#" class="delete-file" onclick="deleteFile(' + i + ')"><i class="fa fa-trash-o"></i></a></li>';
            }
        }

        $('.files-list').html(list);
    });
});