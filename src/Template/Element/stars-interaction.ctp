<form>
    <fieldset class="content-stars">
    <span class="star-cb-group">
      <input type="radio" id="rating-5" name="rating" value="5" class="star-input"/><label for="rating-5">5</label>
      <input type="radio" id="rating-4" name="rating" value="4" class="star-input"/><label for="rating-4">4</label>
      <input type="radio" id="rating-3" name="rating" value="3" class="star-input"/><label for="rating-3">3</label>
      <input type="radio" id="rating-2" name="rating" value="2" class="star-input"/><label for="rating-2">2</label>
      <input type="radio" id="rating-1" name="rating" value="1" class="star-input"/><label for="rating-1">1</label>
      <input type="radio" id="rating-0" name="rating" value="0" class="star-input"/>
    </span>
    </fieldset>
</form>

<?php
echo $this->append('script', $this->Html->script([
    'front/js-min/stars-interactions'
]));
echo $this->append('css', $this->Html->css([
    'front/css/stars-interactions'
]));
?>