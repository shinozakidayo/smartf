

<div class="container">

<?php if($registration == '0') { ?>
<div class="row">
<div class="span12"><?php echo $this->Html->link('代理店申込フォーム',array('controller' => 'signup','action' => 'researchgroup'),"代理店申込フォームの項目を選択しました"); ?></div><br>
</div>
<?php } ?>
<?php if($registration == '1') { ?>
<div class="row">
<div class="span12"><?php echo $this->Html->link('入金通知フォーム',array('controller' => 'signup','action' => 'subcommittee'),"入金通知フォームの項目"); ?></div><br>
</div>
<?php } ?>
<?php if($registration == '1') { ?>
<div class="row">
<div class="span12"><?php echo $this->Html->link('お問い合わせフォーム',array('controller' => 'signup','action' => 'contact'),"お問い合わせフォームの項目"); ?></div><br>
</div>
<?php } ?>
<!-- <div class="row">
<div class="span12"><?php echo $this->Html->link('代理店紹介者申込フォーム',array('controller' => 'signup','action' => 'researchgroup'),"代理店紹介者申込フォームの項目"); ?></div><br>
</div> -->
<?php if($registration == '1') { ?>
<div class="row">
<div class="span12"><?php echo $this->Html->link('登録情報変更フォーム',array('controller' => 'signup','action' => 'detail'),"入登録情報変更フォームの項目"); ?></div><br>
</div>
<?php } ?>
</div>
