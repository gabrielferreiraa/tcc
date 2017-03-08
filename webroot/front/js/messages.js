var bsend = document.querySelector('#send');
var message = document.querySelector('#message');

function createNewMessage(messageNew) {
  var div = document.createElement('div');
  var row = document.createElement('div');
  var messagesContent = document.querySelector('.messages-text');
  div.className = 'bubble-right';
  div.innerHTML = messageNew;
  row.className = 'row';
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
    createNewMessage(message.value);
  }
});
