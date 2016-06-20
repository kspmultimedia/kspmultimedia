<?php

/*
 Plugin Name: Responsive Background Image
 Plugin URI: https://wordpress.org/plugins/responsive-full-background-image
 Description: Easy to add fixed resposive full background image to your website.
 Version: 1.0
 Author: Web Shouter             
 Author URI: http://www.webshouter.net/   
 License: GPLv2 or later           
 */                                  
                                                                                         
if (!class_exists('WS_RESPOSNIVE_BG_IMAGE')) {                             
	       
	class WS_RESPOSNIVE_BG_IMAGE {           
		/**                    
		 *   Construct the plugin object       
		 */                   
		public function __construct() {                      
			          
			add_action('admin_print_scripts', array(&$this, 'ws_admin_scripts'));
			
            add_action('admin_print_styles', array(&$this, 'ws_admin_styles'));
			  
			add_action('admin_menu', array(&$this, 'wp_add_menu'));
			
			add_action( 'wp_head', array(&$this,'ws_responsive_full_background_image') );
			
			define(PLUGIN_PATH, WP_PLUGIN_URL.'/responsive-full-background-image/');
			
		}     
                     
		public function ws_admin_scripts() { 
			
			wp_enqueue_script('media-upload');
			
			wp_enqueue_script('thickbox');
			
			wp_register_script('wp_upload', PLUGIN_PATH.'js/uploader.js', array('jquery','media-upload','thickbox'));
			
			wp_enqueue_script('wp_upload');
		}
		
		public function ws_admin_styles() {
			wp_enqueue_style('thickbox');
			wp_enqueue_style('admin_settings_style',PLUGIN_PATH.'styles/style.css');
		}
		
		public function ws_register_wp_settings(){
			register_setting( 'ws_responsive_bg_group', 'image_url' );
			register_setting( 'ws_responsive_bg_group', 'bg_upload_image' );
			register_setting( 'ws_responsive_bg_group', 'check_upload_image' );
		}

		public function ws_admin_settings_page() {

?>
<div id="wp_wrap_responsive_bg">
	<div id="icon-tools" class="icon32"></div>
	<h2> WS Responsive Full Background Image Settings</h2>
	<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){
	?>
	<div id="setting-error-settings_updated" class="updated settings-error">
		<p>
			<strong>Settings saved.</strong>
		</p>
	</div>
	<?php } ?>

	<form method="post" action="options.php">
		<?php settings_fields( 'ws_responsive_bg_group' ); ?>
		<?php $image_url=get_option('image_url'); 
		if(empty($image_url)){
			$image_url=PLUGIN_PATH.'images/background.jpg';
		}
		
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="image_url">Background Image URL:</label></th>
					<td>
					<input class="regular-text" name="image_url" type="text" id="image_url" placeholder="Enter Background Image URL." value="<?php echo $image_url; ?>">
					</td>
				</tr>
				<tr valign="top" >
					<th scope="row">Upload Image:</th>
					<td><label for="bg_upload_image">
						<input id="bg_upload_image" class="regular-text" type="text" size="36" name="bg_upload_image" value="<?php echo get_option('bg_upload_image'); ?>" />
						<input id="upload_image_button" type="button" value="Upload Image" />
						<br />
						<span class="label">Enter an URL or upload an image for the background image.</span> </label></td>
				</tr>
				<tr valign="top">
					<th><label for="image_url"> Checked Option :</label></th>
					<td>
					<input  name="check_upload_image" type="checkbox" id="check_upload_image" <?php print(checked(1, get_option('check_upload_image'), false)); ?> value="1"> <label for="check_upload_image">Show upload image for the background image</label> 
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2"><?php submit_button(); ?></td>
				</tr>
				
			</tbody>
		</table>
	</form>
	<div class="clear"></div>
</div>
<?php

}

public function ws_responsive_full_background_image(){
	
	$check_upload_image=get_option('check_upload_image');
	
	?>
			<style type="text/css">
				/* WS Responsive Full Background Image */
				html{
					background-image:none !important;
					background:none !important;
				}
				body{
					  /* Location of the image */
					  background-image: url(<?php if($check_upload_image){ echo get_option('bg_upload_image'); } else{ echo get_option('image_url'); } ?> )!important;
					  /* Image is centered vertically and horizontally at all times */
					  background-position: center center!important;
					  /* Image doesn't repeat */
					  background-repeat: no-repeat!important;
					  /* Makes the image fixed in the viewport so that it doesn't move when 
					     the content height is greater than the image height */
					  background-attachment: fixed!important;
					  /* This is what makes the background image rescale based on its container's size */
					  background-size: cover!important;
					  /* Pick a solid background color that will be displayed while the background image is loading */
					  background-color:#464646!important;
				}
			</style>
	<?php
	
}

public function wp_add_menu() {

add_submenu_page('themes.php', 'Responsive Full Background Image', 'Responsive Full Background Image', 'edit_theme_options', 'responsive-full-background-image',  array( $this, 'ws_admin_settings_page' ));

add_action( 'admin_init',array($this,'ws_register_wp_settings'));

}


}

$ws_responsive_bg_image = new WS_RESPOSNIVE_BG_IMAGE();

}
