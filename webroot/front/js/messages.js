$(document).ready(function () {
    $(function () {
        var bsend = document.querySelector('#send');
        var message = document.querySelector('#message');

        moment.locale('pt-br');

        function createNewMessage(messageNew) {
            var div = document.createElement('div');
            var row = document.createElement('div');
            var informations = document.createElement('div');
            var text = document.createElement('p');
            var hour = document.createElement('i');
            var figure = document.createElement('figure');
            var img = document.createElement('img');
            var messagesContent = $('.messages-text:visible');
            div.className = 'bubble-right';
            hour.className = 'italic';
            text.innerHTML = messageNew;
            row.className = 'row';
            hour.innerHTML = moment().format('HH:mm');
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

        bsend.addEventListener('click', function (e) {
            var message = document.querySelector('#message');
            if (message.value) {
                createNewMessage(message.value);
            }
        });

        message.addEventListener('keydown', function (e) {
            if (e.which == 13) {
                if (message.value) {
                    createNewMessage(message.value);
                }
            }
        });
    });
});