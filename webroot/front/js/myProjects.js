$(document).ready(function () {
    window.rate = 0;

    const widthContent = $('.panel-heading').width();
    $('.panel-body').css('width', (widthContent - (70 + 25)));

    moment.locale('pt-br');

    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        const textDateEnd = '.date-end';
        const globalFormat = 'DD/MM/YYYY';
        const $target = $($(e.target).attr('href'));

        if ($(e.target).attr('href').match(/prazo/)) {
            const date_end = moment($target.find(textDateEnd).text(), globalFormat);
            const nowMoment = moment(moment().format(globalFormat), globalFormat);
            const diff = nowMoment.diff(date_end, 'days');

            const positiveDiff = diff > 0 ? diff : diff * (-1);

            const action = nowMoment > date_end ? 'subtract' : 'add';
            const time = action == 'add' ? 'será ' : 'foi ';

            $target
                .find(textDateEnd)
                .text(null)
                .append(
                    time +
                    '<b>' + moment()[action](positiveDiff, 'days').calendar().toLowerCase() + '</b>'
                );
        }
    });

    $('.escolho-voce').on('click', function () {
        const url = webroot + '/projects/fixUserProject';
        const data = {
            project: $(this).data('project'),
            user: $(this).data('user'),
            userName: $(this).data('user_name')
        };

        $.post(url, data, function (response) {
            if (response.result.status === 'success') {
                $('#collapse' + data.project).find('.user-' + data.user).addClass('fixed');
                $(this).html('<i class="fa fa-check-circle"></i> ' + data.userName.toUpperCase() + ' FOI ESCOLHIDO').addClass('white');

                Messenger().post({
                    message: response.result.data,
                    type: 'success',
                    showCloseButton: true
                });
            } else {
                Messenger().post({
                    message: response.result.data,
                    type: 'error',
                    showCloseButton: true
                });
            }
        }.bind(this), 'json');
    });

    $('.open-partner').on('click', function () {
        var url = webroot + 'projects/show-partner';
        var windowDiv = $('.project-window-' + $(this).data('project'));

        windowDiv.toggleClass('open');

        var user = $(this).data('dev').split('-');

        var data = {
            id: user[0]
        };

        var typeUser = user[1] == 'contractor' ? 'Contratante' : 'Freelancer';

        $.post(url, data, function (res) {
            if (res.result.status === 'success') {
                if (res.result.data.picture !== null) {
                    windowDiv.find('img').attr('src', res.result.data.picture)
                }
                windowDiv.find('.name').text(res.result.data.name);
                windowDiv.find('.created').text(typeUser + ' desde ' + res.result.data.created);
                windowDiv.find('.finished').html('Projeto finalizados: ' + '<span>' + res.result.data.finished + '</span>');
                var sendMessage = windowDiv.find('button');
                sendMessage.on('click', function () {
                    window.location.href = webroot + 'visualizar-perfil/' + res.result.data.id;
                });
            }
        }, 'json');
    });

    $('.star-input').change(function () {
        var me = $(this);

        const rates = {
            1: 'Péssimo :´(',
            2: 'Ruim :(',
            3: 'Regular :l',
            4: 'Bom :)',
            5: 'Ótimo :D'
        };

        window.rate = me.attr("value");
        $('.rate').text(rates[me.attr("value")]);
    });

    $('.open-modal-reputation').on('click', function (e) {
        $('#reputation-' + $(this).data('project')).modal('show');
    });

    $('.finishProject').on('click', function (e) {
        const url = webroot + 'projects/finish-project';
        const data = {
            project: $(this).data('project'),
            rate: window.rate
        };

        $.post(url, data, function (e) {

        }, 'json');
    });

    $('.open-anexo').click(function () {
        $('#project-file-' + $(this).data('project')).modal('show');
    });
});
