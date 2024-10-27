<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//add action to add custom admin menu
add_action( 'admin_menu', 'webar_add_custom_admin_menu' );

/**
 * Add Custom admin menu
 */
function webar_add_custom_admin_menu(){
	add_menu_page( __( 'AMMAZZA Settings', 'ammazza-webar' ), __( 'AMMAZZA Settings', 'ammazza-webar' ), 'manage_options', 'webar-option', 'webar_manage_settings' );
}

/**
 * Register theme options action
 */
add_action( 'admin_init', 'webar_register_settings' );

/**
 * Register theme option function
 */
function webar_register_settings() {
	register_setting( 'theme_options', 'theme_options', 'webar_sanitize' );
}

/**
 * sanitize input values
 */
function webar_sanitize( $options ) {

	// If we have options lets sanitize them
	if ( $options ) {		

		// Input
		if ( ! empty( $options['ton_clientid'] ) ) {
			$options['ton_clientid'] = sanitize_text_field( $options['ton_clientid'] );
		} else {
			unset( $options['ton_clientid'] ); // Remove from options if empty
		}

	}

	// Return sanitized options
	return $options;

}

/*
 * call back function settings
 */
function webar_manage_settings(){
?>
	<div class="wrap">
		<h2><?php _e( 'AMMAZZA Virtual Try-On for Jewellery Setting Page', 'ammazza-webar' ) ?></h2>
	    <div class="webar-content">
	    	<form method="post" action="options.php">
		    	<?php settings_fields( 'theme_options' ); ?>
		        <table class="form-table webar-form-table">
		            <tr valign="top">
		                <td scope="row" style="width: 20px;">
		                    <label><strong><?php _e( 'Client Id', 'ammazza-webar' ); ?></strong></label>
		                </td>
		                <td scope="row" >
		                	<?php
		                		$ton_clientid = get_option('theme_options');
		                		$saved_clientid = !empty($ton_clientid['ton_clientid']) ? esc_attr( $ton_clientid['ton_clientid'] ) : '';
	                		?>
		                    <label><input type="text" name="theme_options[ton_clientid]" value="<?php echo esc_attr($saved_clientid); ?>" style="width: 200px;"></label>
		                </td>
		            </tr>
		            <tr valign="top">
		                <td scope="row" style="width: 20px;">
		                    <label><strong><?php _e( 'Try Now button shortcode to use in any pages except product pages.', 'ammazza-webar' ); ?></strong></label>
		                </td>
		                <td scope="row" style="width: 80px;">
		                	<code>[webar-trynow-button-anywhere]</code>
		                </td>
		            </tr>
		        </table>
		        <?php submit_button(); ?>
		    </form>
	    </div>
	</div>
<?php
}