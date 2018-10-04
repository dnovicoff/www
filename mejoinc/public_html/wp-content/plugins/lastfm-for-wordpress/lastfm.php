<?php

/*
Plugin Name: Last.fm for Wordpress
Version: 1.3.3
Plugin URI: http://rick.jinlabs.com/code/lastfm
Description: Displays your recently listened tracks. Based on <a href="http://cavemonkey50.com/code/pownce/">Pownce for Wordpress</a> by <a href="http://cavemonkey50.com/">Cavemonkey50</a>. 
Author: Ricardo Gonz&aacute;lez
Author URI: http://rick.jinlabs.com/
*/

/*  Copyright 2007  Ricardo Gonz�lez Castro (rick[in]jinlabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//define('MAGPIE_CACHE_AGE', 120);
define('MAGPIE_CACHE_ON', 0); //2.7 Cache Bug
define('MAGPIE_INPUT_ENCODING', 'UTF-8');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

$lastfm_options['widget_fields']['title'] = array('label'=>'Title:', 'type'=>'text', 'default'=>'');
$lastfm_options['widget_fields']['username'] = array('label'=>'Username:', 'type'=>'text', 'default'=>'');
$lastfm_options['widget_fields']['num'] = array('label'=>'Number of links:', 'type'=>'text', 'default'=>'');
$lastfm_options['widget_fields']['update'] = array('label'=>'Show timestamps:', 'type'=>'checkbox', 'default'=>false);
$lastfm_options['widget_fields']['linked'] = array('label'=>'Linked tracks:', 'type'=>'checkbox', 'default'=>false);
$lastfm_options['widget_fields']['encode_utf8'] = array('label'=>'UTF8 Encode:', 'type'=>'checkbox', 'default'=>false);

$lastfm_options['prefix'] = 'lastfm';


// Display Last.fm recently listened tracks.

function lastfm_tracks($username = '', $num = 5, $list = true, $update = true, $linked  = true, $encode_utf8 = false) {
	global $lastfm_options;
	include_once(ABSPATH . WPINC . '/rss.php');

	$songs = fetch_rss('http://ws.audioscrobbler.com/1.0/user/'.$username.'/recenttracks.rss');

	if ($num <=0) $num = 1;
	if ($num >10) $num = 10;
	
	if ($list) echo '<ul class="lastfm">';
	
	if ($username == '') {
		if ($list) echo '<li>';
		echo 'Username not configured';
		if ($list) echo '</li>';
	} else {
			if ( empty($songs->items) ) {
				if ($list) echo '<li>';
				echo 'No recently listened tracks.';
				if ($list) echo '</li>';
			} else {
				foreach ( $songs->items as $song ) {
					$msg = htmlspecialchars($song['title']);
					if($encode_utf8) $msg = utf8_encode($msg);
					$link = $song['link'];
				
					if ($list) echo '<li class="lastfm-item">'; elseif ($num != 1) echo '<p class="lastfm-track">';
					if ($linked) { 
            echo '<a href="'.$link.'" class="lastfm-link">'.$msg.'</a>'; // Puts a link to the song.
          } else {
            echo $msg; // Only the song, no link.
          }
          if($update) {				
            $time = strtotime($song['pubdate']);
            
            if ( ( abs( time() - $time) ) < 86400 )
              $h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
            else
              $h_time = date(__('Y/m/d'), $time);

            echo sprintf( '%s' ,' <span class="lastfm-timestamp"><abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $h_time . '</abbr></span>' );
           }   
           
           if ($list) echo '</li>'; elseif ($num != 1) echo '</p>';
				
					$i++;
					if ( $i >= $num ) break;
				}
			}	
		}
    if ($list) echo '</ul>';
	}

// lastfm widget stuff
function widget_lastfm_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
	
	$check_options = get_option('widget_lastfm');
  if ($check_options['number']=='') {
    $check_options['number'] = 1;
    update_option('widget_lastfm', $check_options);
  }
	function widget_lastfm($args, $number = 1) {
	
	global $lastfm_options;
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		include_once(ABSPATH . WPINC . '/rss.php');
		$options = get_option('widget_lastfm');
		
		// fill options with default values if value is not set
		$item = $options[$number];
		foreach($lastfm_options['widget_fields'] as $key => $field) {
			if (! isset($item[$key])) {
				$item[$key] = $field['default'];
			}
		}
		
		$songs = fetch_rss('http://ws.audioscrobbler.com/1.0/user/'.$username.'/recenttracks.rss');

		// These lines generate our output.
echo $before_widget . $before_title . $item['title'] . '<a href="http://last.fm/user/' . $username . '"></a>' . $after_title;
		lastfm_tracks($item['username'], $item['num'], true, $item['update'], $item['linked'], $item['encode_utf8']);
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_lastfm_control($number) {

		global $lastfm_options;

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_lastfm');
		
		if ( isset($_POST['lastfm-submit']) ) {

			foreach($lastfm_options['widget_fields'] as $key => $field) {
				$options[$number][$key] = $field['default'];
				$field_name = sprintf('%s_%s_%s', $lastfm_options['prefix'], $key, $number);

				if ($field['type'] == 'text') {
					$options[$number][$key] = strip_tags(stripslashes($_POST[$field_name]));
				} elseif ($field['type'] == 'checkbox') {
					$options[$number][$key] = isset($_POST[$field_name]);
				}
			}

			update_option('widget_lastfm', $options);
		}

		foreach($lastfm_options['widget_fields'] as $key => $field) {
			
			$field_name = sprintf('%s_%s_%s', $lastfm_options['prefix'], $key, $number);
			$field_checked = '';
			if ($field['type'] == 'text') {
				$field_value = htmlspecialchars($options[$number][$key], ENT_QUOTES);
			} elseif ($field['type'] == 'checkbox') {
				$field_value = 1;
				if (! empty($options[$number][$key])) {
					$field_checked = 'checked="checked"';
				}
			}
			
			printf('<p style="text-align:right;" class="lastfm_field"><label for="%s">%s <input id="%s" name="%s" type="%s" value="%s" class="%s" %s /></label></p>',
				$field_name, __($field['label']), $field_name, $field_name, $field['type'], $field_value, $field['type'], $field_checked);
		}
		echo '<input type="hidden" id="lastfm-submit" name="lastfm-submit" value="1" />';
	}
	
	function widget_lastfm_setup() {
		$options = $newoptions = get_option('widget_lastfm');
		
		if ( isset($_POST['lastfm-number-submit']) ) {
			$number = (int) $_POST['lastfm-number'];
			$newoptions['number'] = $number;
		}
		
		if ( $options != $newoptions ) {
			update_option('widget_lastfm', $newoptions);
			widget_lastfm_register();
		}
	}
	
	
	function widget_lastfm_page() {
		$options = $newoptions = get_option('widget_lastfm');
	?>
		<div class="wrap">
			<form method="POST">
				<h2><?php _e('last.fm Widgets'); ?></h2>
				<p style="line-height: 30px;"><?php _e('How many last.fm widgets would you like?'); ?>
				<select id="lastfm-number" name="lastfm-number" value="<?php echo $options['number']; ?>">
	<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
				<span class="submit"><input type="submit" name="lastfm-number-submit" id="lastfm-number-submit" value="<?php echo attribute_escape(__('Save')); ?>" /></span></p>
			</form>
		</div>
	<?php
	}
	
	
	function widget_lastfm_register() {
		
		$options = get_option('widget_lastfm');
		$dims = array('width' => 300, 'height' => 300);
		$class = array('classname' => 'widget_lastfm');

		for ($i = 1; $i <= 9; $i++) {
			$name = sprintf(__('last.fm #%d'), $i);
			$id = "lastfm-$i"; // Never never never translate an id
			wp_register_sidebar_widget($id, $name, $i <= $options['number'] ? 'widget_lastfm' : /* unregister */ '', $class, $i);
			wp_register_widget_control($id, $name, $i <= $options['number'] ? 'widget_lastfm_control' : /* unregister */ '', $dims, $i);
		}
		
		add_action('sidebar_admin_setup', 'widget_lastfm_setup');
		add_action('sidebar_admin_page', 'widget_lastfm_page');
	}

	widget_lastfm_register();
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_lastfm_init');



?>