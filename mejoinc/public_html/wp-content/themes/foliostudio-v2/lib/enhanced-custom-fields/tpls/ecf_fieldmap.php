
<?php if(!empty($this->value)) : ?>
    <input type="hidden" name="<?=$this->name?>" value="<?=$this->value?>" id="<?=$this->name?>" />
<?php else: ?>
    <input type="hidden" name="<?=$this->name?>" value="" id="<?=$this->name?>" />
<?php endif ?>
<div class="cl">&nbsp;</div>

