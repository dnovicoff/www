					</div>
					
					<div id="footer">
						<div id="footer-inner">
							<?php $data = get_data(); ?>
		<?php if($data['setting-footer_widgets'] != ""){ ?>
					  <?php
					  $columns = array('footerwidget-4col' 	=> array('col col4-1','col col4-1','col col4-1','col col4-1'),
										 'footerwidget-3col'	=> array('col col3-1','col col3-1','col col3-1'),
										 'footerwidget-2col' 	=> array('col col4-2','col col4-2'),
										 'footerwidget-1col' 	=> array('') );
					  $x=0;
					  ?>
				<?php foreach($columns[$data['setting-footer_widgets']] as $col): ?>
							<?php 
								 $x++;
								 if($x == 1){ 
									  $class = "first"; 
								 } else {
									  $class = "";	
								 }
							?>
							<div class="<?php echo $col;?> <?php echo $class; ?>">
								 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer_Widget_'.$x) ) ?>
							</div>
					  <?php endforeach; ?>
		<?php } ?>
							<div class="cl">&nbsp;</div>
						</div>
						<div id="footer-bottom">&nbsp;</div>
					</div>
					
				</div>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
		<div id="page-bottom">&nbsp;</div>
		<div id="copyright">
			<div id="copyright-left">
				
			
				<?php if($data['setting-footer_text_left'] != ""){ echo $data['setting-footer_text_left']; } else { echo 'Copyright &copy; <a href="'.get_option('home').'">'.get_bloginfo('name').'</a> '.date('Y'); } ?>
			</div>
			
			<div id="copyright-right">
				<?php if($data['setting-footer_text_right'] != ""){ echo $data['setting-footer_text_right']; } else { echo ''; } ?>
			</div>
		</div>
		<div class="cl">&nbsp;</div>
	</div>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
	    $("a[rel^='prettyPhoto']").prettyPhoto();
	  });
	</script>
	<script type="text/javascript"> Cufon.now(); </script>
	<?php wp_footer(); ?>

	

</body>



</html>


<?php dynamic_sidebar('Footer Sidebar') ?>