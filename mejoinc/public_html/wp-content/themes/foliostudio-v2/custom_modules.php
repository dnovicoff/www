<?php


/* 	Custom Modules
/***************************************************************************/	
	///////////////////////////////////////////
	// Homepage Slider Style
	///////////////////////////////////////////
	
	
	///////////////////////////////////////////
	// Homepage Slider Speed
	///////////////////////////////////////////
	function themify_sliderstyle($data=array()){

	  // This was confusing even for me, it's the very first randition of
	  // getting relevant data passed through to the function. That said,
	  // I don't use this anymore at all so don't think you need to either

	  /**** $data['value'] = $data['value']['value']; *****/

	  //
	  // The get_data() function will get all the data and is a bit better
	  // then using the $data variable passed to the function.
	  // _________________________________________
	  //
	  // Note: get_data() will be themify_get_data() as of 1.1 but there will
	  // be a fallback in place for get_data() to point to the new function.
	  // Unfortunately, this is the only place were we've seen a lot of issues
	  // still with compaitibility. The problem was that we didn't prefix the 
	  // function "get_data" is too general and collides. So as soon as 1.1 is out 
	  // do a find and replace even though we support a fallback
	  //

	  $data = get_data();

	  $options = array('slider', 'gallery');

	  $output = '

	   <p><span class="label">Slider Style:</span>

	   <select name="setting-sliderstyle" id="setting-sliderstyle" />';

	    foreach($options as $option):

	      //
	      // Since $data holds all the framework options you can just grab the variable
	      // you've stored based on the name of the input, which is "setting-sliderstyle".
	      // --------------------------------
	      // Note: You don't have to prefix your names of your options with "setting-" if
	      // you don't want to. Thats a convention we use and it may be beneficial to prefix 
	      // them with your own unqiue prefix like "mojo-" or something. Nothing special is
	      // done with "setting-" prefixed options
	      //

	      if($option == $data['setting-sliderstyle']):

	        $output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';

	     else:

	       $output .= '<option value="'.$option.'">'.$option.'</option>';

	  endif;

	 endforeach;

	    $output .= '</select></p>';

	 return $output;

	 }
	
	///////////////////////////////////////////
	// Homepage - Boxes
	///////////////////////////////////////////
	function themify_homeboxes($data=array()){
		
		$data = get_data();
		
		if($data['homebox_checked']){
			$homebox_checked = "checked ='checked'";
		}
		
		return '
		
			<p>
			
			<span class="label">Enable Sub-Features:</span>
			<input type="checkbox" id="option-enabled" name="homebox_checked" '.$homebox_checked.' /><br />
			
			<div id="box-1" class="home-page-box">
					
				<label for="home-page-box-1"></label>
					
				<p>Area 1</p>
					
				<textarea class="widthfull" rows="4" name="setting-homebox_one">'.$data['setting-homebox_one'].'</textarea>
				
			</div>
				
				
			<div id="box-2" class="home-page-box">
					
				<label for="home-page-box-2"></label>
				
				<p>Area 2</p>
					
				<textarea class="widthfull" rows="4" name="setting-homebox_two">'.$data['setting-homebox_two'].'</textarea>
				
			</div>
				
				
			<div id="box-3" class="home-page-box">
					
				<label for="home-page-box-3"></label>
					
				<p>Area 3</p>
					
				<textarea class="widthfull" rows="4" name="setting-homebox_three">'.$data['setting-homebox_three'].'</textarea>
				
			</div>
			
			
			</p>
			
			';
	}
	
	///////////////////////////////////////////
	// Homepage - CTA Text Module
	///////////////////////////////////////////	
	function themify_homeaction($data=array()){
		$data = get_data();
		if($data['setting-cta']){
			$cta_checked = "checked ='checked'";
		}
			
		return '<span class="label">Enable Call to Action</span>
		<input type="checkbox" id="option-enabled" name="setting-cta" '.$cta_checked.' /><br />
		
		<div id="cta-enabled" class="cta-box">
		<p><span class="label">Text:</span>
		<input type="text" class="width10" name="homeaction_text" value="'.$data['homeaction_text'].'" /><br />
		<span class="pushlabel"><small>e.g. Do you still need more reasons to get started?</small></span></p><br />
		
		<p><span class="label">Button Text:</span>
		<input type="text" class="width10" name="homeaction_button" value="'.$data['homeaction_button'].'" /><br />
		<span class="pushlabel"><small>e.g. Get Started</small></span></p>
		
		<p><span class="label">Button Link Destination:</span>
		<input type="text" class="width10" name="homeaction_button_link" value="'.$data['homeaction_button_link'].'" /><br />
		<span class="pushlabel"><small>e.g. http://www.mojo-themes.com</small></span></p>
		</div>
		
		';
		}

	
	///////////////////////////////////////////
	// Homepage - From the Blog
	///////////////////////////////////////////
	function themify_fromblog($data=array()){
		$data = get_data();
		
		return '
		
		<p><span class="label">Title:</span>
		
		<input type="text" class="width10" name="fromtheblog" value="'.$data['fromtheblog'].'" /><br />
		
		<span class="pushlabel"><small>e.g. From The Blog. This is the title of the blog area on the homepage.</small></span></p>
		
		<p><span class="label">Button Text:</span>
		
		<input type="text" class="width10" name="fromtheblog_button" value="'.$data['fromtheblog_button'].'" /><br />
		
		<span class="pushlabel"><small>e.g. visit the blog</small></span></p>
		
		';
	}
	
	///////////////////////////////////////////
	// Homepage - Featured Area
	///////////////////////////////////////////	
	function themify_featured_area($data=array()){
		$data = get_data();	
	
	return '<p><span class="label">Title:</span>
		<input type="text" class="width10" name="featured_text" value="'.$data['featured_text'].'" /><br />
		<span class="pushlabel"><small>e.g. Featured Projects</small></span></p><br />
		
		<p><span class="label">Button Text:</span>
		<input type="text" class="width10" name="featured_button" value="'.$data['featured_button'].'" /><br />
		<span class="pushlabel"><small>e.g. view project</small></span></p>
		';
	
	}

	
	///////////////////////////////////////////
	// Comments in Pages Function
	///////////////////////////////////////////
	function themify_comments_in_pages($data=array()){
		$data = get_data();
		if($data['setting-comments_pages']){
			$pages_checked = "checked='checked'";	
		}
		return '<p><input type="checkbox" name="setting-comments_pages" '.$pages_checked.' /> Disable comments in Pages</p>';	
	}
	
	///////////////////////////////////////////
	// Post Image Function
	///////////////////////////////////////////
	function themify_post_image($data=array()){
		$data = get_data();
		$options = array("left","right");
		
		if($data['setting-post_image_single_disabled']){
			$checked = 'checked="checked"';
		}
		
		$output .= '<p>
						<span class="label">List post image size</span>  
						<input type="text" class="width2" name="setting-image_post_width" value="'.$data['setting-image_post_width'].'" /> width <small>(px)</small>  
						<input type="text" class="width2" name="setting-image_post_height" value="'.$data['setting-image_post_height'].'" /> height <small>(px)</small>
					</p>
					
					<hr />
					<p>
						<span class="label">Single post image size</span>  
						<input type="text" class="width2" name="setting-image_post_single_width" value="'.$data['setting-image_post_single_width'].'" /> width <small>(px)</small>  
						<input type="text" class="width2" name="setting-image_post_single_height" value="'.$data['setting-image_post_single_height'].'" /> height <small>(px)</small>
					</p>
					
					<p>
						<span class="pushlabel">
							<input type="checkbox" name="setting-post_image_single_disabled" '.$checked.' >
							Exclude post image in single post
						</span>
					</p>';
		return $output;
	}
	
	///////////////////////////////////////////
	// Footer Text Left Function
	///////////////////////////////////////////
	function themify_footer_text_left($data=array()){
		$data = get_data();
		return '<p><textarea class="widthfull" rows="4" name="setting-footer_text_left">'.$data['setting-footer_text_left'].'</textarea></p>';	
	}
	
	///////////////////////////////////////////
	// Footer Text Right Function
	///////////////////////////////////////////
	function themify_footer_text_right($data=array()){
		$data = get_data();
		return '<p><textarea class="widthfull" rows="4" name="setting-footer_text_right">'.$data['setting-footer_text_right'].'</textarea></p>';	
	}
	
	///////////////////////////////////////////
	// Homepage Header Slider Function
	///////////////////////////////////////////
	function themify_header_slider($data=array()){
		$data = get_data();
		
		if($data['setting-header_slider_enabled']){
			$enabled_checked = "checked='checked'";	
		} else {
			$enabled_display = "style='display:none;'";	
		}
		if($data['setting-header_slider_visible'] == "" ||!isset($data['setting-header_slider_visible'])){
			$data['setting-header_slider_visible'] = "5";	
		}
		
		if($data['setting-header_slider_display'] == 'images'){
			$display_images = "checked='checked'";
			$display_posts_display = "style='display:none;'";
		} else {
			$display_posts = "checked='checked'";	
			$display_images_display = "style='display:none;'";
		}
		$speed_options = array("Fast"=>200,"Normal"=>1000,"Slow"=>2000);
		$wrap_options = array("yes","no");
		$image_options = array("one","two","three","four","five","six","seven","eight","nine","ten");
		
		$output .= '<p><span class="label">Header Slider</span> <input type="checkbox" name="setting-header_slider_enabled" class="feature_box_enabled_check" '.$enabled_checked.' />  Enable</p>
					<div class="feature_box_enabled_display" '.$enabled_display.'>
					
					<p><span class="label">Display</span> <input type="radio" class="feature-box-display" name="setting-header_slider_display" value="posts" '.$display_posts.' /> Posts <input type="radio" class="feature-box-display" name="setting-header_slider_display" value="images" '.$display_images.' /> Images</p>
					
					<p class="pushlabel feature_box_posts" '.$display_posts_display.'>';
							$output .= wp_dropdown_categories(array("show_option_all"=>"All Categories","show_option_all"=>"All Categories","hide_empty"=>0,"echo"=>0,"name"=>"setting-header_slider_posts_category","selected"=>$data['setting-header_slider_posts_category']));
		$output .=	'	<input type="text" name="setting-header_slider_posts_slides" value="'.$data['setting-header_slider_posts_slides'].'" class="width2" /> number of slides 
					</p>
					
					<div class="feature_box_images" '.$display_images_display.'>';
					
					$x = 0;
					foreach($image_options as $option){
						$x++;
						$output .= '
						<p>
							<span class="label">Link '.$x.'</span>
							<input type="text" class="width10" name="setting-header_slider_images_'.$option.'_link" value="'.$data['setting-header_slider_images_'.$option.'_link'].'" />
							<span class="label">Image '.$x.'</span>
							<input type="text" class="width10 feature_box_img" name="setting-header_slider_images_'.$option.'_image" value="'.$data['setting-header_slider_images_'.$option.'_image'].'" /> 
							<span class="pushlabel" style="display:block;"><a href="#" class="upload-btn upload-image simple" id="header_slider_image_'.$option.'">+ Upload</a></span>
						</p>';
					}
		
		$output .= '</div>
					<hr />
					<p>
						<span class="label">Visible</span> 
						<select name="setting-header_slider_visible">';
						for($x=1;$x<=7;$x++){
							if($data['setting-header_slider_visible'] == $x){
								$output .= '<option value="'.$x.'" selected="selected">'.$x.'</option>';	
							} else {
								$output .= '<option value="'.$x.'">'.$x.'</option>';	
							}
						}
			$output .=	'</select> <small>(# of slides visible at the same time)</small>
					</p>
					<p>
						<span class="label">Speed</span> 
						<select name="setting-header_slider_speed">';
						foreach($speed_options as $name => $val){
							if($data['setting-header_slider_speed'] == $val){
								$output .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$val.'">'.$name.'</option>';	
							}	
						}
			$output .= '</select>
					</p>
					<p>
						<span class="label">Wrap Slides</span> 
						<select name="setting-header_slider_wrap">';
						foreach($wrap_options as $name){
							if($data['setting-header_slider_wrap'] == $name){
								$output .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$name.'">'.$name.'</option>';	
							}
						}
			$output .=	'</select>
					</p>
					<hr />
					<p>
						<span class="label">Feature Image Size</span>
						<input type="text" name="setting-header_slider_width" class="width2" value="'.$data['setting-header_slider_width'].'" /> width <small>(in px)</small>
						<input type="text" name="setting-header_slider_height" class="width2" value="'.$data['setting-header_slider_height'].'" /> height <small>(in px)</small>
					</p>
					</div>';		
		return $output;
	}
	
	///////////////////////////////////////////
	// Homepage Header Slider Function - Action
	///////////////////////////////////////////
	function themify_header_slider_action($data=array()){
		$data = get_data();
		if($data['setting-header_slider_wrap'] == 'yes'){
			$wrap = "wrap: 'circular',";	
		}
		if($data['setting-header_slider_visible'] == ""){
			$visible = "5";	
		} else {
			$visible = $data['setting-header_slider_visible'];	
		}
		if($data['setting-header_slider_speed'] == ""){
			$speed = "slow";	
		} else {
			$speed = $data['setting-header_slider_speed'];	
		}
		?>
		<script type='text/javascript'>
			!window.jQuery && document.write('<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/themify/js/jquery.js"><\/script>')
        </script>
		<script type='text/javascript'>
		jQuery(function($) {
			jQuery('#header-slider .slides').jcarousel({
				<?php echo $wrap; ?>
				visible: <?php echo $visible; ?>,
				scroll: 1,
				animation: "<?php echo $speed; ?>",
				initCallback: carousel_callback
			});
		});
		</script>
        <?php
	}
	add_action('wp_footer', 'themify_header_slider_action');
	
	///////////////////////////////////////////
	// Footer Slider Function
	///////////////////////////////////////////
	function themify_footer_slider($data=array()){
		$data = get_data();
		
		if($data['setting-footer_slider_enabled']){
			$enabled_checked = "checked='checked'";	
		} else {
			$enabled_display = "style='display:none;'";	
		}
		if($data['setting-footer_slider_visible'] == "" ||!isset($data['setting-footer_slider_visible'])){
			$data['setting-footer_slider_visible'] = "5";	
		}
		if($data['setting-footer_slider_display'] == 'images'){
			$display_images = "checked='checked'";
			$display_posts_display = "style='display:none;'";
		} else {
			$display_posts = "checked='checked'";	
			$display_images_display = "style='display:none;'";
		}
		$speed_options = array("Fast"=>200,"Normal"=>1000,"Slow"=>2000);
		$wrap_options = array("yes","no");
		$image_options = array("one","two","three","four","five","six","seven","eight","nine","ten");
		
		$output .= '<p><span class="label">Footer Slider</span> <input type="checkbox" name="setting-footer_slider_enabled" class="feature_box_enabled_check" '.$enabled_checked.' />  Enable</p>
					<div class="feature_box_enabled_display" '.$enabled_display.'>
					
					<p><span class="label">Display</span> <input type="radio" class="feature-box-display" name="setting-footer_slider_display" value="posts" '.$display_posts.' /> Posts <input type="radio" class="feature-box-display" name="setting-footer_slider_display" value="images" '.$display_images.' /> Images</p>
					
					<p class="pushlabel feature_box_posts" '.$display_posts_display.'>';
							$output .= wp_dropdown_categories(array("show_option_all"=>"All Categories","hide_empty"=>0,"echo"=>0,"name"=>"setting-footer_slider_posts_category","selected"=>$data['setting-footer_slider_posts_category']));
		$output .=	'	<input type="text" name="setting-footer_slider_posts_slides" value="'.$data['setting-footer_slider_posts_slides'].'" class="width2" /> number of slides 
					</p>
					
					<div class="feature_box_images" '.$display_images_display.'>';
					
					$x = 0;
					foreach($image_options as $option){
						$x++;
						$output .= '
						<p>
							<span class="label">Link '.$x.'</span>
							<input type="text" class="width10" name="setting-footer_slider_images_'.$option.'_link" value="'.$data['setting-footer_slider_images_'.$option.'_link'].'" />
							<span class="label">Image '.$x.'</span>
							<input type="text" class="width10 feature_box_img" name="setting-footer_slider_images_'.$option.'_image" value="'.$data['setting-footer_slider_images_'.$option.'_image'].'" /> 
							<span class="pushlabel" style="display:block;"><a href="#" class="upload-btn upload-image simple" id="footer_slider_image_'.$option.'">+ Upload</a></span>
						</p>';
					}
		
		$output .= '</div>
					<hr />
					<p>
						<span class="label">Visible</span> 
						<select name="setting-footer_slider_visible">';
						for($x=1;$x<=7;$x++){
							if($data['setting-footer_slider_visible'] == $x){
								$output .= '<option value="'.$x.'" selected="selected">'.$x.'</option>';	
							} else {
								$output .= '<option value="'.$x.'">'.$x.'</option>';	
							}
						}
			$output .=	'</select> <small>(# of slides visible at the same time)</small>
					</p>
					<p>
						<span class="label">Speed</span> 
						<select name="setting-footer_slider_speed">';
						foreach($speed_options as $name => $val){
							if($data['setting-footer_slider_speed'] == $val){
								$output .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$val.'">'.$name.'</option>';	
							}	
						}
			$output .= '</select>
					</p>
					<p>
						<span class="label">Wrap Slides</span> 
						<select name="setting-footer_slider_wrap">';
						foreach($wrap_options as $name){
							if($data['setting-footer_slider_wrap'] == $name){
								$output .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$name.'">'.$name.'</option>';	
							}
						}
			$output .=	'</select>
					</p>
					<hr />
					<p>
						<span class="label">Feature Image Size</span>
						<input type="text" name="setting-footer_slider_width" class="width2" value="'.$data['setting-footer_slider_width'].'" /> Height <small>(in px)</small>
						<input type="text" name="setting-footer_slider_height" class="width2" value="'.$data['setting-footer_slider_height'].'" /> Width <small>(in px)</small>
					</p>
					</div>';		
		return $output;
	}
	
	///////////////////////////////////////////
	// Homepage Footer Slider Function - Action
	///////////////////////////////////////////
	function themify_footer_slider_action($data=array()){
		$data = get_data();
		if($data['setting-footer_slider_wrap'] == 'yes'){
			$wrap = "wrap: 'circular',";	
		}
		if($data['setting-footer_slider_visible'] == ""){
			$visible = "5";	
		} else {
			$visible = $data['setting-footer_slider_visible'];	
		}
		if($data['setting-footer_slider_speed'] == ""){
			$speed = "slow";	
		} else {
			$speed = $data['setting-footer_slider_speed'];	
		}
		?>
        <script type='text/javascript'>
			!window.jQuery && document.write('<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/themify/js/jquery.js"><\/script>')
        </script>
		<script type='text/javascript'>
		jQuery(function($) {
			jQuery('#footer-slider .slides').jcarousel({
				<?php echo $wrap; ?>
				visible: <?php echo $visible; ?>,
				scroll: 1,
				animation: '<?php echo $speed; ?>',
				initCallback: carousel_callback
			});
		});
		</script>
        <?php
	}
	add_action('wp_footer', 'themify_footer_slider_action');
	
	///////////////////////////////////////////
	// Footer Widgets Function
	///////////////////////////////////////////
	function themify_footer_widgets($data=array()){
		$data = get_data();
		$options = array(
						 array("value" => "footerwidget-4col", 			"img" => "images/layout-icons/footerwidget-4col.png"),
						 array("value" => "footerwidget-3col", 			"img" => "images/layout-icons/footerwidget-3col.png", "selected" => true),
						 array("value" => "footerwidget-2col", 			"img" => "images/layout-icons/footerwidget-2col.png"),
						 array("value" => "footerwidget-1col",			"img" => "images/layout-icons/footerwidget-1col.png"),
						 array("value" => "",							"img" => "images/layout-icons/none.png")
						 );
		$val = $data['setting-footer_widgets'];
		$output = "";
		foreach($options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		
		$output .= '<input type="hidden" name="setting-footer_widgets" class="val" value="'.$val.'" />';
		
		return $output;
	}

	///////////////////////////////////////////
	// Exclude RSS
	///////////////////////////////////////////
	function themify_exclude_rss($data=array()){
		$data = get_data();
		if($data['setting-exclude_rss']){
			$pages_checked = "checked='checked'";	
		}
		return '<p><input type="checkbox" name="setting-exclude_rss" '.$pages_checked.'/> Exclude RSS icon in header</p>';	
	}

	///////////////////////////////////////////
	// Exclude Search Form
	///////////////////////////////////////////
	function themify_exclude_search_form($data=array()){
		$data = get_data();
		if($data['setting-exclude_search_form']){
			$pages_checked = "checked='checked'";	
		}
		return '<p><input type="checkbox" name="setting-exclude_search_form" '.$pages_checked.'/> Exclude search form in header</p>';	
	}

?>