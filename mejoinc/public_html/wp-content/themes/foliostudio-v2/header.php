<?php $data = get_data(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/color-schemes/<?= $theme ?>/style.css" type="text/css" media="all" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-1.3.0.css" type="text/css" media="screen" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
	<script type="text/javascript" charset="utf-8">
		var transition_speed = 	<?php echo $data['setting-transition_speed']; ?>;
		var rotation_interval = <?php echo $data['setting-rotation_interval']; ?>;
	</script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.pngFix.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/Arial_400-Arial_700-Arial_italic_400-Arial_italic_700.font.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-1.3.0.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js" type="text/javascript"></script>
	<?php $enable_cufon = get_option('enable_cufon'); ?>
	<?php if ($enable_cufon == 'yes'): ?>
		<script type="text/javascript" charset="utf-8">
			Cufon.replace('.cufon-default', {
			<?php if ( get_option('color_scheme') != 'dark' ): ?>
				textShadow: '0 1px 0 #fff'
			<?php else: ?>
				textShadow: '0 1px 0 #000'
			<?php endif ?>
			});
			
			Cufon.replace('.slider h1', {
				textShadow: '0 2px 4px rgba(0, 0, 0, 0.4)'
			});
			
			Cufon.replace('.cufon-plain, h2');
			
			Cufon.replace('#footer h3', {
				textShadow: ' 0 -2px 1px rgba(0, 0, 0, 0.85)'
			}); 
		</script>
		<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	<?php endif; ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-15490280-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="shell">
		<div id="page-top">&nbsp;</div>
		<div id="page-middle">
			<div id="page-inner">
				<div id="page-content">

					<div id="header">
						<div id="branding"><div id="site-logo">
							<?php if($data['setting-site_logo'] == 'image' && $data['setting-site_logo_image_value'] != ''){ ?>
							
							<?php themify_image("src=".$data['setting-site_logo_image_value']."&w=".$data['setting-site_logo_width']."&h=".$data['setting-site_logo_height']."&alt=".get_bloginfo('name')."&before=<a href='".get_option('home')."'>&after=</a>"); ?>
							
							<?php } else { ?>
				 			
				 			<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
							
							<?php } ?>	
							<!--<div id="site-description"><?php bloginfo('description'); ?></div>-->		
						</div>
						</div>
						<div id="nav-section">
							<div id="navigation">
								<?php f_print_navigation() ?>
							</div>
							<div class="cl">&nbsp;</div>
							<div id="header-search">
								<?php if(!$data['setting-exclude_search_form']){ ?>
								<form action="<?php echo get_option('home'); ?>" method="get">
									<div class="form-holder">
										<div class="search-field">
											<input type="text" class="field" value="" name="s" />
										</div>
										<input type="submit" class="search-button" value="Search" />
									</div>
								</form>
								<?php } ?>
							</div>
														
						</div>
						<div class="cl">&nbsp;</div>
					</div>
					
					<div id="main">