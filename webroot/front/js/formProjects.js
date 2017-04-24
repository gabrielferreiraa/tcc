$(document).ready(function () {
    const heightProjects = $('.content-wrapper').height();
    $('.left-bar').css('height', heightProjects + 'px');

    $('.btn-more-skills').click(function () {
        $('#skills').modal('show');
    });
    $('#input-search-skills').keyup(function () {
        var filter = $(this).val().toUpperCase();
        var checks = $('.wrapper').find('.check-type-modal');

        checks.map(function (index, item) {
            if (item.querySelector('.input-checkbox').value.toUpperCase().indexOf(filter) > -1) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    $('.mostrar-interesse').click(function (e) {
        if (!$(this).hasClass('interested')) {
            $(this).addClass('interested').html('<i class="fa fa-check-circle"></i> Você mostrou interesse');

            const url = webroot + 'projects/registerInterested';
            const data = {
                id: $(this).data('id')
            };

            $.post(url, data, function (response) {

            }, 'json');
        } else {
            e.preventDefault();
        }
    });
});