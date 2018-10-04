<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="google-site-verification" content="HL9WzjmaE9ddY1_tAZqNG-lGrqlhGQfQpA6nZiRGNZ8" />
	<meta name="y_key" content="2f1a4f25b3195626" />
	<meta name="msvalidate.01" content="A23EA92E3CC3F1BD96923760D4483F09" />
	<link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/apple-touch-icon.png" /> 
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" /> 
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/color-schemes/<?php echo get_option('color_scheme'); ?>/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-1.3.0.css" type="text/css" media="screen" />
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="shell">
		<div id="page-top">&nbsp;</div>
		<div id="page-middle">
			<div id="page-inner">
				<div id="page-content">

					<div id="header">
						<div id="branding">
							<?php $use_logo = (get_option('show_logo_or_title') == 'use-logo') ? true : false; 
							if($use_logo) {
								$logo_img = get_option('logo_image');
								if (get_option('color_scheme') == 'dark' && $logo_img == get_bloginfo('stylesheet_directory') . '/images/logo.png' ) {
									$logo_img = get_bloginfo('stylesheet_directory') . '/color-schemes/dark/images/logo.jpg';
								}
							}
							?>
							<h1 id="logo" <?php echo (!$use_logo) ? 'class="text-logo cufon-plain"' : ''; ?>>
								<a href="<?php echo get_option('home'); ?>" style="background: <?php echo ($use_logo) ? 'url(' . $logo_img . ')' : 'transparent'; ?> no-repeat 0 0;"><?php bloginfo('title'); ?></a>
							</h1>
							<div class="cl">&nbsp;</div>
							<?php if ( get_option('enable_intro_text') != 'n' ): ?>
								<h2 id="slogan" class="cufon-default"><?php echo f_get_tagline(); ?></h2>	
							<?php endif ?>						
						</div>
						<div id="nav-section">
							<div id="navigation">
								<?php f_print_navigation() ?>
							</div>
							<div class="cl">&nbsp;</div>
							<div id="header-search">
								<form action="<?php echo get_option('home'); ?>" method="get">
									<div class="form-holder">
										<div class="search-field">
											<input type="text" class="field" value="" name="s" />
										</div>
										<input type="submit" class="search-button" value="Search" />
									</div>
								</form>
							</div>							
						</div>
						<div class="cl">&nbsp;</div>
					</div>
					
					<div id="main">