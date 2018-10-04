<?php	
	
/* 	Custom Write Panels
/***************************************************************************/

	///////////////////////////////////////
	// Setup Write Panel Options
	///////////////////////////////////////
	
	// Post Meta Box Options
	$post_meta_box_options = array(
								   	// Post Image
									array(
										  "name" 		=> "post_image",
										  "title" 		=> "Post Image",
										  "description" => "Post image used in the loop",
										  "type" 		=> "image",
										  "meta"		=> array()
										),
								   	// Feature Image
									array(
										  "name" 		=> "feature_image",
										  "title" 		=> "Feature Image",
										  "description" => "Feature image used in feature post widget", 
										  "type" 		=> "image",
										  "meta"		=> array()	
										),
									// Image Width
									array(
										  "name" 		=> "image_width",	
										  "title" 		=> "Image Width", 
										  "description" => "", 				
										  "type" 		=> "textbox",			
										  "meta"		=> array("size"=>"small")			
										),
									// Image Height
									array(
										  "name" 		=> "image_height",	
										  "title" 		=> "Image Height", 
										  "description" => "", 				
										  "type" 		=> "textbox",			
										  "meta"		=> array("size"=>"small")			
										),
									// External Link
									array(
										  "name" 		=> "external_link",	
										  "title" 		=> "External Link", 	
										  "description" => "This link will apply to the post image", 				
										  "type" 		=> "textbox",			
										  "meta"		=> array()			
										),
									
								);
	
	// Page Meta Box Options
	$page_meta_box_options = array(
								  	// Page Layout
									array(
										  "name" 		=> "page_layout",
										  "title"		=> "Page Layout",
										  "description"	=> "",
										  "type"		=> "layout",
										  "meta"		=> array(
																 array("value" => "", "img" => "images/layout-icons/single-default.png", "selected" => true),
																 array("value" => "one-sidebar", 	"img" => "images/layout-icons/single-one-sidebar.png"),
																 array("value" => "fullwidth", "img" => "images/layout-icons/single-fullwidth.png"),
																 array("value" => "content-only", "img" => "images/layout-icons/single-content-only.png")
																 )
										),
								   );
									
	// Query Post Meta Box Options
	$query_meta_box_options = array(
								   	// Query Category
									array(
										  "name" 		=> "query_category",
										  "title"		=> "Query Category",
										  "description"	=> "Select a category or enter multiple category IDs (eg. 2,5,6). Enter 0 to display all category.",
										  "type"		=> "query_category",
										  "meta"		=> array()
										),
									// Posts Per Page
									array(
										  "name" 		=> "posts_per_page",
										  "title"		=> "Posts per page",
										  "description"	=> "",
										  "type"		=> "textbox",
										  "meta"		=> array("size" => "small")
										),
									// Post Layout
									array(
										  "name" 		=> "layout",
										  "title"		=> "Layout",
										  "description"	=> "",
										  "type"		=> "layout",
										  "meta"		=> array(
																 array("value" => "", "img" => "images/layout-icons/query-default-two-sidebar.png", "selected" => true),
																 array("value" => "grid2-post col2-1 sidebar2", "img" => "images/layout-icons/query-grid2-two-sidebar.png"),
																 array("value" => "list-post sidebar2", "img" => "images/layout-icons/query-list-post-two-sidebar.png"),
																 array("value" => "default-post sidebar1", "img" => "images/layout-icons/query-default-one-sidebar.png"),
																 array("value" => "grid2-post col2-1 sidebar1", "img" => "images/layout-icons/query-grid2-one-sidebar.png"),
																 array("value" => "grid3-post col3-1 sidebar1", "img" => "images/layout-icons/query-grid3-one-sidebar.png"),
																 array("value" => "list-post sidebar1", "img" => "images/layout-icons/query-list-post-one-sidebar.png"),
																 array("value" => "grid4-post col4-1", "img" => "images/layout-icons/query-4col.png"),
																 array("value" => "grid3-post col3-1", "img" => "images/layout-icons/query-3col.png"),
																 array("value" => "grid2-post col2-1", "img" => "images/layout-icons/query-2col.png"),
																 array("value" => "list-post", "img" => "images/layout-icons/query-list-post.png"),
																 )
										),
									// Display Content
									array(
										  "name" 		=> "display_content",
										  "title"		=> "Display",
										  "description"	=> "",
										  "type"		=> "dropdown",
										  "meta"		=> array(
																 array("name"=>"Excerpt","value"=>"excerpt","selected"=>true),
																 array("name"=>"Content","value"=>"content"),
																 array("name"=>"None","value"=>"none")
																 )
										),
									// Hide Title
									array(
										  "name" 		=> "hide_title",
										  "title"		=> "Post Title",
										  "description"	=> "Hide post title",
										  "type"		=> "checkbox",
										  "meta"		=> array()
										),
									// Hide Post Date
									array(
										  "name" 		=> "hide_date",
										  "title"		=> "Post Date",
										  "description"	=> "Hide post date",
										  "type"		=> "checkbox",
										  "meta"		=> array()
										),
									// Hide Post Meta
									array(
										  "name" 		=> "hide_meta",
										  "title"		=> "Post Meta",
										  "description"	=> "Hide post meta (categories, tags, etc.)",
										  "type"		=> "checkbox",
										  "meta"		=> array()
										),
									// Image Width
									array(
										  "name" 		=> "image_width",	
										  "title" 		=> "Image Width", 
										  "description" => "", 				
										  "type" 		=> "textbox",			
										  "meta"		=> array("size"=>"small")			
										),
									// Image Height
									array(
										  "name" 		=> "image_height",	
										  "title" 		=> "Image Height", 
										  "description" => "", 				
										  "type" 		=> "textbox",			
										  "meta"		=> array("size"=>"small")			
										),
									// Page Navigation Visibility
									array(
										  "name" 		=> "hide_navigation",
										  "title"		=> "Page Navigation",
										  "description"	=> "Hide page navigation",
										  "type"		=> "checkbox",
										  "meta"		=> array()
										),
									// Hide page title
									array(
										  "name" 		=> "hide_page_title",
										  "title"		=> "Page Title",
										  "description"	=> "Hide page title",
										  "type"		=> "checkbox",
										  "meta"		=> array()
										)
									);
	
			
	
	///////////////////////////////////////
	// Build Write Panels
	///////////////////////////////////////
	themify_build_write_panels(array(
									array(
										 "name"		=> "Post Options",			// Name displayed in box
										 "options"	=> $post_meta_box_options, 	// Field options
										 "pages"	=> "post"					// Pages to show write panel
										 ),
									array(
										 "name"		=> "Page Options",	
										 "options"	=> $page_meta_box_options, 		
										 "pages"	=> "page"
										 ),
									array(
										 "name"		=> "Query Posts Template Options",	
										 "options"	=> $query_meta_box_options, 		
										 "pages"	=> "page"
										 ),
									)
								);
	
/* 	Custom Functions
/***************************************************************************/

	// Add shortcode support to text widget
	add_filter('widget_text', 'do_shortcode');	

	// Adds a rel="prettyPhoto" tag to all linked image files
	add_filter('the_content', 'addlightboxrel_replace', 12);
	add_filter('get_comment_text', 'addlightboxrel_replace');
	function addlightboxrel_replace ($content)
	{   global $post;
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto['.$post->ID.']"$6>$7</a>';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}

	// Page navigation
	function pagenav($before = '', $after = '') {
		global $wpdb, $wp_query;
	
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
	
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 8;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
	
		if ($max_page > 1) {
			echo $before.'<div class="pagenav clearfix">';
			if ($start_page >= 2 && $pages_to_show < $max_page) {
				$first_page_text = "&laquo;";
				echo '<a href="'.get_pagenum_link().'" title="'.$first_page_text.'" class="number">'.$first_page_text.'</a>';
			}
			//previous_posts_link('&lt;');
			for($i = $start_page; $i  <= $end_page; $i++) {
				if($i == $paged) {
					echo ' <span class="number current">'.$i.'</span> ';
				} else {
					echo ' <a href="'.get_pagenum_link($i).'" class="number">'.$i.'</a> ';
				}
			}
			//next_posts_link('&gt;');
			if ($end_page < $max_page) {
				$last_page_text = "&raquo;";
				echo '<a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'" class="number">'.$last_page_text.'</a>';
			}
			echo '</div>'.$after;
		}
	}
	
	// Title Tag Function
	function title_tag() {
		if (is_home() || is_front_page()) {
			echo bloginfo('name');
		} elseif (is_404()) {
			_e('404 Not Found','themify');
		} elseif (is_category()) {
			_e('Category:','themify'); wp_title('');
		} elseif (is_tag()) {
			_e('Tag:','themify'); wp_title('');
		} elseif (is_search()) {
			_e('Search Results','themify');
		} elseif ( is_day() || is_month() || is_year() ) {
			_e('Archives:','themify'); wp_title('');
		} else {
			echo wp_title('');
		}
	}
	
	// Register Custom Menu Function
	function register_custom_nav() {
		if (function_exists('register_nav_menus')) {
			register_nav_menus( array(
				'main-nav' => __( 'Main Navigation', 'themify' ),
			) );
		}
	}
	
	// Register Custom Menu Function - Action
	add_action('init', 'register_custom_nav');
	
	// Default Main Nav Function
	function default_main_nav() {
		echo '<ul id="main-nav" class="clearfix">';
		wp_list_pages('title_li=');
		echo '</ul>';
	}

	// Register Widgets
	if ( function_exists('register_sidebar') ) {
		
		register_sidebar(array(
			'name' => 'Sidebar',
			'before_widget' => '<div class="widgetwrap"><div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));

	}

	// Footer Widgets
	if ( function_exists('register_sidebar') ) {
		$data = get_data();
		$columns = array(	 'footerwidget-4col' 			=> 4,
							 'footerwidget-3col'			=> 3,
							 'footerwidget-2col' 			=> 2,
							 'footerwidget-1col' 			=> 1 );
		$option = ($data['setting-footer_widgets'] == "" || !isset($data['setting-footer_widgets'])) ?  "footerwidget-3col" : $data['setting-footer_widgets'];
		for($x=1;$x<=$columns[$option];$x++){
			register_sidebar(array(
				'name' => 'Footer_Widget_'.$x,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			));			
		}
	}
	
	// Check if paged > 1
	function show_posts_nav() {
		global $wp_query;
		return ($wp_query->max_num_pages > 1);
	}

	// Custom Theme Comment
	function custom_theme_comment($comment, $args, $depth) {
	   $GLOBALS['comment'] = $comment; 
	   ?>
		<li id="comment-<?php comment_ID() ?>">
			<p class="comment-author">
				<?php echo get_avatar($comment,$size='36'); ?>
				<?php printf(__('<cite>%s</cite>'), get_comment_author_link()) ?><br />
				<small class="comment-time"><strong><?php comment_date('M d, Y'); ?></strong> @ <?php comment_time('H:i:s'); ?><?php edit_comment_link('Edit',' [',']') ?></small>
			</p>
			<div class="commententry">
				<?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php _e('Your comment is awaiting moderation.') ?></em></p>
				<?php endif; ?>
			
				<?php comment_text() ?>
			</div>
			<p class="reply"><?php comment_reply_link(array_merge( $args, array('add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
		<?php
	}

?>