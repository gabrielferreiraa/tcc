$(document).ready(function(){
    $('.btn-more-skills').click(function(){
        $('#skills').modal('show');
    });
    $('#input-search-skills').keyup(function(){
        var filter = $(this).val().toUpperCase();
        var checks = $('.wrapper').find('.check-type-modal');

        checks.map(function(index, item){
            if(item.querySelector('.input-checkbox').value.toUpperCase().indexOf(filter) > -1){
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});