					</div>
					<div id="footer">
						<div id="footer-inner">
							<ul>
								<?php dynamic_sidebar('Footer Sidebar') ?>
							</ul>
							<div class="cl">&nbsp;</div>
						</div>
						<div id="footer-bottom">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
		<div id="page-bottom">&nbsp;</div>
		<div id="copyright"><?php echo get_option('footer_text', ''); ?></div>
	</div>
	<?php wp_footer(); ?>
	<script type="text/javascript" charset="utf-8">
		var transition_speed = <?php echo get_option('transition_speed'); ?>;	
		var rotation_interval = <?php echo get_option('rotation_interval'); ?>;
	</script>
	<script src="http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.pngFix.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-1.3.0.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js" type="text/javascript"></script>
	
	<?php $enable_cufon = get_option('enable_cufon'); ?>
	<?php if ($enable_cufon == 'yes'): ?>
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/cufon-yui.js" type="text/javascript"></script>
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/Arial_400-Arial_700-Arial_italic_400-Arial_italic_700.font.js" type="text/javascript"></script>
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
		<script type="text/javascript">Cufon.now();</script>
	<?php endif; ?>
</body>
</html>