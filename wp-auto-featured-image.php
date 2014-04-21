<?php
/**
 * Plugin Name: Wordpress Auto Featured Image
 * Plugin URI: http://www.royalsoftwareservices.com/plugins/
 * Description: This plugin provides you an easy way to set a default thumbnail image for your posts, pages or custom post types. You can select an image from your local machine or media library.
 * Author: Sanny Srivastava
 * Author URI: http://www.royalsoftwareservices.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.0
 
	Copyright (c) 2014 by Sanny Srivastava (sannysrivastava@gmail.com)
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/
 
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );


# Define Constants and Version
define( 'WP_Auto_FI_Version', '1.0' );
define( 'WP_Auto_FI_DIR', WP_PLUGIN_DIR . '/wp-auto-featured-image' );
define( 'WP_Auto_FI_URL', WP_PLUGIN_URL . '/wp-auto-featured-image' );


# Add the admin options page
add_action('admin_menu', 'wpafi_admin_add_page');
function wpafi_admin_add_page() {
	add_menu_page('Wordpress Auto Featured Image', 'WP AFI', 'manage_options', 'wp_auto_featured_image', 'wpafi_start');
}

# Menu Callback and backend design
function wpafi_start() { ?>
<div class="wrap wp_afi">
<h2>Wordpress Auto Featured Image</h2>
<div class="content_area">
<div class="wp_afi_left_area">
<form action="options.php" method="post">
<div class="metabox-holder">
    <div class="postbox-container postbox" style="width: 99%;">
				<?php settings_fields('wpafi_options'); ?>
                <?php do_settings_sections('wp_auto_featured_image'); ?>
           </div>         
      </div>
   <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>   
</div>

</div><!-- wp_afi LEFT AREA -->
<div class="wp_afi_right_area">
	<div class="metabox-holder">
		<div class="postbox-container postbox" style="width: 99%;">  
				<h3 class="hndle"><span>Support</span></h3>
                <div class="inside">
                <p class="multi-option">Have you encountered any problem with our plugin and need our help? Do you need to ask us any question? <br />You can post your question or issues at WordPress <a target="_blank" href="http://wordpress.org/support/plugin/wp-auto-featured-image">Support</a> or can directly mail me <a href="mailto:sannysrivastava@gmail.com">sannysrivastava@gmail.com</a>.</p>
              </div>
		</div>
	</div> 
    
    <div class="metabox-holder">
		<div class="postbox-container postbox" style="width: 99%;">  
				<h3 class="hndle"><span>Help</span></h3>
                <div class="inside">
                <p class="multi-option">We need your support to make this and other plugins more smarter and helpful for you, if this plugin saved few minutes of your effort, kindly get some time for a favor to us and<br />1) <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/wp-auto-featured-image">Rate this plugin.</a><br />2) Make a small <a href="http://www.royalsoftwareservices.com/donate/" target="_blank"> donation</a> for us. <br />Any help would be very appreciated. Thanks for using this plugin.<br />Have a good day!!</p>
              </div>
		</div>
	</div>   
</div><!-- wp_afi RIGHT AREA -->  
</div>
<?php
}

# Add settings option at the admin form
add_action('admin_init', 'wpafi_admin_init');
function wpafi_admin_init(){
	register_setting('wpafi_options', 'wpafi_options', 'wpafi_options_validate');
	add_settings_section('wpafi_main', 'General Settings', 'wpafi_desp', 'wp_auto_featured_image');
	add_settings_field('wpafi_post_type', 'Include Post Types:', 'wpafi_post_types', 'wp_auto_featured_image', 'wpafi_main');
	add_settings_field('wpafi_default_thumb', 'Set Default Thumbnail:', 'wpafi_default_thumb', 'wp_auto_featured_image', 'wpafi_main');
	add_settings_field('wpafi_default_thumb_id', '', 'wpafi_default_thumb_id', 'wp_auto_featured_image', 'wpafi_main');
}


function wpafi_desp() {
echo '
<div class="inside">
	<p>Main description of this section here.</p>';
} 


function wpafi_post_types() {
$options = get_option('wpafi_options');
$post_types = get_post_types( array('public' => true), 'names' ); 

	foreach ( $post_types as $post_type ) {
		if($post_type != 'attachment') {
		$selected = '';
		if($options['wpafi_post_type']) { 
			if(in_array($post_type,$options['wpafi_post_type'])) { $selected = " checked='checked'"; }
		}
		echo '
		<input type="checkbox"'.$selected.' name="wpafi_options[wpafi_post_type][]" id="wpafi_text_string-'.$post_type.'" value="'.$post_type.'" />
		<label class="post-type" for="wpafi_text_string-'.$post_type.'">'.preg_replace('/[-_]/',' ',$post_type).'</label>';
		}
	}
} 

function wpafi_default_thumb() {
$options = get_option('wpafi_options');
	if(empty($options['wpafi_default_thumb'])) {
		echo '<input type="text" id="default_thumb_url" name="wpafi_options[wpafi_default_thumb]" value="" />                          
		  	  <input id="upload_default_thumb" class="button" type="button" value="Upload Image" />';
	} else { 
		echo '
		<input id="upload_default_thumb" class="button" type="button" value="Update Image" />
		<input type="hidden" id="default_thumb_url" name="wpafi_options[wpafi_default_thumb]" value="'.$options["wpafi_default_thumb"].'" /> 
		<input id="delete_thumb" name="delete_thumb" type="button" class="button" value="Delete Thumbnail" />
		<div id="uploaded_thumb_preview">
			<img src="'.$options["wpafi_default_thumb"].'" style="max-width:100%;">
		</div>';				
	}
}

function wpafi_default_thumb_id() {
	$options = get_option('wpafi_options');
	if(empty($options['wpafi_default_thumb_id'])) {
		echo '<input type="hidden" id="default_thumb_id" class="s1" name="wpafi_options[wpafi_default_thumb_id]" value="" />';		
	} else {
		echo '<input type="hidden" id="default_thumb_id" class="s2" name="wpafi_options[wpafi_default_thumb_id]" value="'.$options["wpafi_default_thumb_id"].'" />';
	}
}


function wpafi_options_validate($input) {
	$newinput['text_string'] = trim($input['text_string']);

	if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
		$newinput['text_string'] = false;
	}
return $input;
}

# Enque scripts to WordPress
add_action('admin_enqueue_scripts', 'wp_afi_enqueue_scripts');
function wp_afi_enqueue_scripts(){
	wp_enqueue_style('wafi-style',WP_Auto_FI_URL.'/css/wafi-style.css');						
	wp_register_script('wafi-script', WP_Auto_FI_URL.'/js/wafi-script.js', array('jquery','media-upload','thickbox') );		
	if('toplevel_page_wp_auto_featured_image' == get_current_screen()->id) {
		wp_enqueue_script('jquery');		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('wafi-script');
	}
}


# Set Post thumbnail when a post is going to be pubslihed.

add_action('save_post', 'wpfi_set_thumbnail' ); 
function wpfi_set_thumbnail( $post_id ) {
global $wpdb;
extract($_POST);
$options = get_option('wpafi_options');

	# Check if this suppose to be set thumbnail
	if((in_array($post_type, $options['wpafi_post_type']) == 0) || has_post_thumbnail( $post_id ) || empty($options['wpafi_default_thumb_id'])) {
		return;
	}
	
	# Set thumbnail here
	set_post_thumbnail( $post_id, $options['wpafi_default_thumb_id']); 	
}
