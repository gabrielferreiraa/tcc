$(document).ready(function(){
  $(function(){
    var bsend = document.querySelector('#send');
    var message = document.querySelector('#message');

    function createNewMessage(messageNew) {
      var div = document.createElement('div');
      var row = document.createElement('div');
      var text = document.createElement('span');
      var figure = document.createElement('figure');
      var img = document.createElement('img');
      var messagesContent = document.querySelector('.messages-text');
      div.className = 'bubble-right';
      text.innerHTML = messageNew;
      row.className = 'row';
      div.appendChild(text);
      img.src = userPicture;
      figure.appendChild(img);
      div.appendChild(figure);
      row.appendChild(div);
      messagesContent.appendChild(row);
      message.value = '';
      messagesContent.scrollTop = messagesContent.scrollHeight;
    }

    bsend.addEventListener('click', function(e) {
      var message = document.querySelector('#message');
      if (message.value) {
        createNewMessage(message.value);
      }
    });

    message.addEventListener('keydown', function(e) {
      if (e.which == 13) {
        if(message.value){
          createNewMessage(message.value);
        }
      }
    });
  });
});