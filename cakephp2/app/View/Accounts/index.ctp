<?php $this->set('title_for_layout', 'TwitterBootstrap Plugin for CakePHP2.0'); ?>

<div class="container">
	<div class="row">
	<section id="alerts">
		<h2>THE EARTHへ登録したメールアドレスとパスワードを入力してsubmitボタンを押してください </h2>
	</section>
	</div> <!-- /row -->
</div>
<?php echo $this->Form->create('Account', array('url' => 'login')); ?>
<div class="container">
	<div class="row">
		<div class="span9">
		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Session->flash('LOGIN_ERR_MSG'); ?>
		</div>
	</div> <!-- /row -->
	<div class="row">
		<div class="span9">
<?php echo $this->Form->input('username', array('label' => 'THE EARTHへ登録したメールアドレス','type'=>'text')); ?>
		</div>
	</div> <!-- /row -->
	<div class="row">
		<div class="span9">
<?php echo $this->Form->input('password', array('label' => 'Password')); ?>
		</div>
	</div> <!-- /row -->
	<div class="row">
		<div class="span9">
		<?php echo $this->Form->end('ログイン'); ?>
		</div>
	</div> <!-- /row -->
</div>
