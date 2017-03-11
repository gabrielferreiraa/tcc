$(document).ready(function () {
    $(function () {
        var bsend = document.querySelector('#send');
        var message = document.querySelector('#message');

        moment.locale('pt-br');

        function save (message) {
            const url = webroot + 'messages/save-message';
            const data = {
                message: message,
                id: window.location.hash.substring(1)
            };

            $.post(url, data, function(e){
                console.log(e);
            }, 'json');
        }

        function createNewMessage(messageNew) {
            save(message.value);

            var div = document.createElement('div');
            var row = document.createElement('div');
            var informations = document.createElement('div');
            var text = document.createElement('p');
            var check = document.createElement('span');
            var hour = document.createElement('i');
            var figure = document.createElement('figure');
            var img = document.createElement('img');
            var messagesContent = $('.messages-text:visible');
            check.className = 'fa fa-check';
            check.style = 'margin-right: 5px;';
            div.className = 'bubble-right';
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