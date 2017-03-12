$(document).ready(function(){
    $('#skill-ids').select2();

    function populateCities () {
        const url = webroot + 'utils/populate-cities';
        const data = {
            state: $(this).val()
        };

        $.post(url, data, function(response){
            var selectCity = $('#city-id');
            var html = '';

            $.each(response.result.data, function(index, item){
                html += '<option value="'+ index +'">' + item + '</option>';
            });
            selectCity.html(html);
        }, 'json');
    }

    function populateAddress () {
        const cep = $('#cep').val();

        $.get('http://api.postmon.com.br/v1/cep/' + cep, function(e){
            var elState = $('#state-id');
            var elCity = $('#city-id');

            var states = elState.find('option');
            var cities = elCity.find('option');

            states.map(function(index, item){
                if(item.text.toLowerCase() == e.estado_info.nome.toLowerCase()){
                    elState.val(index);
                    elCity.trigger('change');
                }
            });

            cities.map(function(index, item){
                if(item.text.toLowerCase() == e.cidade.toLowerCase()){
                    elCity.val(index);
                    elCity.trigger('change');
                }
            });

            if(typeof e.logradouro !== 'undefined'){
                $('#street').val(e.logradouro);
            }
        });
    }

    function openFile() {
        $('#picture').trigger('click');
    }

    function changeImgUser (e) {
        const img = $('#picture');
        if(img[0].files.length){
            console.log(img[0].files[0]);
            // $('.img-user').attr('src', to64(img[0].files[0]))
        }
    }

    $('#state-id').change(populateCities);
    $('.btn-buscar-cep').click(populateAddress);
    $('.img-user').click(openFile);
    $('#picture').change(changeImgUser);
});