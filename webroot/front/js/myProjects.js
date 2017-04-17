$(document).ready(function () {
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
    })
});
