$(document).ready(function () {
    $(document).on('mouseover', '.profile', function(){
        $('.participant-' + $(this).data('id')).addClass('hovered');
    }).on('mouseout', '.profile', function(){
        $('.participant-' + $(this).data('id')).removeClass('hovered');
    });

    $(document).on('mouseover', '.participant-list', function(){
        $('.participant-' + $(this).data('id')).addClass('hovered');
    }).on('mouseout', '.participant-list', function(){
        $('.participant-' + $(this).data('id')).removeClass('hovered');
    });

    $('.input-search').focus();
    window.counter = 0;

    $(function () {
        var bsend = document.querySelector('#send');
        var message = document.querySelector('#message');

        moment.locale('pt-br');

        function save (message, time) {
            const url = webroot + 'messages/save-message';
            const data = {
                message: message,
                id: window.location.hash.substring(1),
                time: time
            };

            $.post(url, data, function(e){
                if(e.result.status === 'success'){
                    $('.number-' + window.counter).find('.fa').removeClass('fa-clock-o').addClass('fa-check green-check');
                } else {
                    $('.number-' + window.counter).find('.fa').removeClass('fa-check').addClass('fa-warning no-send');
                }
            }, 'json');
        }

        function createNewMessage(messageNew, side) {
            save(message.value, moment().format('YYYY-MM-DD HH:MM:SS'));

            window.counter++;

            var div = document.createElement('div');
            var row = document.createElement('div');
            var informations = document.createElement('div');
            var text = document.createElement('p');
            var check = document.createElement('span');
            var hour = document.createElement('i');
            var figure = document.createElement('figure');
            var img = document.createElement('img');
            var messagesContent = $('.messages-text:visible');
            check.className = 'fa fa-clock-o';
            check.style = 'margin-' + side + ': 5px;';
            div.className = 'bubble-' + side + ' number-' + window.counter;
            hour.className = 'italic';
            text.innerHTML = messageNew;
            row.className = 'row';
            hour.innerHTML = moment().format('HH:mm');
            hour.prepend(check);
            informations.appendChild(text);
            informations.appendChild(hour);
            img.src = userPicture;
            figure.appendChild(img);
            div.appendChild(informations);
            div.appendChild(figure);
            row.appendChild(div);
            messagesContent.append(row);
            message.value = '';
            messagesContent.scrollTop(messagesContent.prop('scrollHeight'));
        }

        if(bsend !== null){
            bsend.addEventListener('click', function (e) {
                var message = document.querySelector('#message');
                if (message.value) {
                    createNewMessage(message.value, 'right');
                }
            });
        }

        if(message !== null){
            message.addEventListener('keydown', function (e) {
                if (e.which == 13) {
                    if (message.value) {
                        createNewMessage(message.value, 'right');
                    }
                }
            });
        }
    });
});