<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<style>
	body {
		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	}
	</style>
	<?php echo $this->Html->css('bootstrap-responsive.min'); ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<!--
	<link rel="shortcut icon" href="/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	-->
	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>	

<?php $this->params['models'][0] ?>
	
	
<div class="container">
	<div class="row">
		<div class="span9">	
			THE EAETH ID:<?php echo $this->Session->read('the_earth_id'); ?>
		</div>
	</div> <!-- /row -->
</div>
	
	
<?php if($this->Session->read('the_earth_id')!=null){ ?>
<div class="container">
	<div class="row">
		<div class="span9">
		<h1>
			THE EAETH ID:<?php echo $this->Session->read('the_earth_id'); ?><br>
		</h1>
		<h2>
			氏名：<?php echo $this->Session->read('entry_sei') ?> <?php echo $this->Session->read('entry_mei') ?>
			EMAIL:<?php echo $this->Session->read('email') ?>
			TEL:<?php echo $this->Session->read('phone') ?>
		</h2>
	</div>
</div>
<?php } ?>
	
	<?php echo $this->fetch('content'); ?>

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->fetch('script'); ?>

</body>
</html>
