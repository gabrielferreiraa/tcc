<div class="wrapper">
    <h5 class="title-item">Orçamento</h5>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio"/>
        <div class="wrap-radio"></div>A combinar
    </label>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio" value="budget < 1000" <?= isset($this->request->query['budget'])  && $this->request->query['budget'] == 'budget < 1000' ? 'checked' : ''  ?> />
        <div class="wrap-radio"></div>Até R$ 1,000.00
    </label>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio" value="budget >= 1001 AND budget < 2000" <?= isset($this->request->query['budget'])  && $this->request->query['budget'] == 'budget >= 1001 AND budget < 2000' ? 'checked' : ''  ?> />
        <div class="wrap-radio"></div>Entre R$ 1,000.01 e R$ 2,000.00
    </label>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio" value="budget >= 2001 AND budget < 3500" <?= isset($this->request->query['budget'])  && $this->request->query['budget'] == 'budget >= 2001 AND budget < 3500' ? 'checked' : ''  ?> />
        <div class="wrap-radio"></div>Entre R$ 2,000.01 e R$ 3,500.00
    </label>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio" value="budget >= 3501 AND budget < 5000" <?= isset($this->request->query['budget'])  && $this->request->query['budget'] == 'budget >= 3501 AND budget < 5000' ? 'checked' : ''  ?> />
        <div class="wrap-radio"></div>Entre R$ 3,500.01 e R$ 5,000.00
    </label>
    <label class="check-type">
        <input type="radio" name="budget" class="input-radio" value="budget > 5001" <?= isset($this->request->query['budget'])  && $this->request->query['budget'] == 'budget > 5001' ? 'checked' : ''  ?> />
        <div class="wrap-radio"></div>Acima de R$ 5,000.01
    </label>
</div>