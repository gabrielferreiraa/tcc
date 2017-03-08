<div class="container wrapper-all">
  <div class="wrapper">
      <section class="content">
      <aside>
        <ul class="contacts">
          <a href="#mark">
            <li>
                <img src="http://ow.ly/ZeTt30697mF" />
                <span>Mark Zuckerberg</span>
                <span>last message 02:48 AM</span>
                <i class="fa fa-circle online"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
          <a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a><a href="#jack">
            <li>
                <img src="http://ow.ly/PIUT30697ij" />
                <span>Jack Dorsey</span>
                <span>last message 06:48 PM</span>
                <i class="fa fa-circle offline"></i>
            </li>
          </a>
        </ul>
      </aside>
      <section id ="mark" class="messages-text">
        <h1>Mark Zuckerberg</h1>
        <div class="row">
          <div class="bubble-left" id="teste">
            :) <3 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse finibus velit sit amet velit ultrices, ultricies venenatis ipsum accumsan. Integer ultricies nisl eget nisi eleifend malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent a est purus. Aenean molestie, mi vel vulputate facilisis, orci massa pulvinar neque, ut imperdiet libero eros fermentum neque
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
      <section id ="jack" class="messages-text">
        <h1>Jack Dorsey</h1>
      </section>
    </section>
    <section class="message">
      <input type="text" id="message" class="new-message" placeholder="Enter your message"/>
      <button id="send" class="send-message">Send</button>
    </section>
  </div>
</div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/messages'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/messages'
]));
?>