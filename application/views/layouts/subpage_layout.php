<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
<head>
	<?php echo $head; ?>
</head>
<body class="subpage <?php echo $body_class; ?>">

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
						<?php if ($this->github->get_access_token()) : ?>
						<li><?php echo anchor('secure/logout', '<i class="icon-lock"></i>Logout'); ?></li>
						<?php endif; ?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row top">
	<?php echo $this->session->flashdata('message'); ?>
	<div class="span3">
		<div class="profile-pic">
			<a href="http://github.com/<?php echo $login; ?>"><img src="<?php echo $avatar_url; ?>" class="img-polaroid"></a>
		</div>
		<h4 class="v-card">
			<span itemprop="name">Nicholas Cerminara</span>
			<em itemprop="additionalName">ncerminara</em>
		</h4>
		<div class="details">
			<span><?php echo $company; ?></span>
			<span><?php echo $location; ?></span>
			<span><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span>
			<span><?php echo $bio; ?></span>
			<span><strong>Hirable:</strong> <?php echo $hireable; ?></span>
		</div>
	</div>
	<div class="span6 welcome-text">
		<div class="welcome-text">
			<h1>Well hello, <?php echo $name; ?>!</h1>
			<p>You have successfully logged in with your GitHub account!</p>
		</div>
		<?php echo $content; ?>
</div>
	<div class="span3">
		<h3>Other Stuff</h3>
		
		<h4><a href="http://github.com/scotch-io/stencil"><i class="icon-pencil icon-spin"></i> Stencil Templating Engine</a></h4>
		<p>This demo uses <?php echo anchor('http://github.com/scotch-io/stencil', 'Stencil'); ?>. Stencil is an ultra developer friendly templating engine for Codeigniter. The GitHub library does not require it though, although it is recommended by us ;) that you use Stencil for all of your projects.</p>
		<p>

		<h4>By: <?php echo anchor('http://scotch.io', 'scotch.io'); ?></h4>

	</div>	
</div>
		<hr>

		<footer>
			<p>&copy; <?php echo anchor('http://scotch.io', 'scotch.io'); ?> 2013</p>
		</footer>
	</div>

</body>
</html>