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
});
