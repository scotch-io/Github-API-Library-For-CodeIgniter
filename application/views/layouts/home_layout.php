<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
<head>
	<?php echo $head; ?>
</head>
<body class="<?php echo $body_class; ?>">

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php echo base_url(); ?>"><i class="icon-github-sign"></i> GitHub API Library for CodeIgniter</a>
				<div class="nav-collapse pull-right">
					<ul class="nav">
						<li><?php echo anchor(base_url(), 'Home'); ?></li>
						<li><?php echo anchor('https://github.com/scotch-io/Github-API-Library-For-CodeIgniter', 'GitHub'); ?></li>
						<li><?php echo anchor('https://github.com/scotch-io/Github-API-Library-For-CodeIgniter', 'Docs'); ?></li>
						<li><?php echo anchor('license', 'License'); ?></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<?php echo $content; ?>

		<hr>

		<footer>
			<p>&copy; <?php echo anchor('http://scotch.io', 'scotch.io'); ?> 2013</p>
		</footer>
	</div>
</body>
</html>


