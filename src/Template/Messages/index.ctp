<div class="wrapper">
  <section class="content">
    <aside>
      <ul class="contacts">
        <li>
          <img src="http://ow.ly/ZeTt30697mF" />
          <span>Mark Zuckerberg</span>
          <span>last message 02:48 AM</span>
          <i class="fa fa-circle online"></i>
        </li>
        <li>
          <img src="http://ow.ly/PIUT30697ij" />
          <span>Jack Dorsey</span>
          <span>last message 06:48 PM</span>
          <i class="fa fa-circle offline"></i>
        </li>
        <li>
          <img src="http://ow.ly/SDht30698M4" />
          <span>Evan Spiegel</span>
          <span>last message 2 Nov</span>
          <i class="fa fa-circle offline"></i>
        </li>
        <li>
          <img src="http://ow.ly/Uaei3069925" />
          <span>Donald Trump</span>
          <span>last message 1 Nov</span>
          <i class="fa fa-circle online"></i>
        </li>
      </ul>
    </aside>
    <section class="messages-text">
      <h1>Mark Zuckerberg</h1>
      <div class="row">
        <div class="bubble-left">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse finibus velit sit amet velit ultrices, ultricies venenatis ipsum accumsan. Integer ultricies nisl eget nisi eleifend malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent a est purus. Aenean molestie, mi vel vulputate facilisis, orci massa pulvinar neque, ut imperdiet libero eros fermentum neque
        </div>
      </div>
      <div class="row">
        <div class="bubble-right">
          Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent a est purus. Aenean molestie
        </div>
      </div>
      <div class="row">
        <div class="bubble-left">
          Pellentesque habitant
        </div>
      </div>
    </section>
  </section>
  <section class="message">
    <input type="text" id="message" placeholder="Enter your message"/>
    <button id="send">Send</button>
  </section>
</div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/messages'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/messages'
]));
?>