<!-- robot speak -->	
<meta charset="utf-8">
<title><?php if (!empty($title)) echo $title.' | '; ?>GitHub API Library for CodeIgniter</title>
<?php echo chrome_frame(); ?>
<?php echo view_port(); ?>
<?php echo apple_mobile('black-translucent'); ?>
<?php echo $meta; ?>

<!-- icons and icons and icons and icons and icons and a tile -->
<?php echo windows_tile(array('name' => 'GitHub API Library for CodeIgniter', 'image' => base_url().'/assets/img/icons/tile.png', 'color' => '#4eb4e5')); ?>
<?php echo favicons(); ?>

<!-- crayons and paint -->	
<?php echo add_css(array('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css', '//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css')); ?>
<?php echo add_css('style'); ?>
<?php echo $css; ?>

<!-- magical wizardry -->
<?php echo jquery('1.9.1'); ?>
<?php echo shiv(); ?>
<?php echo add_js(array('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js', 'scripts')); ?>
<?php echo $js; ?>