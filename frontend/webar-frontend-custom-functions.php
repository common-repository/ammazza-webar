<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Function to check tryon is available on product or not
 */
function webar_check_tryon_producs($product_id=''){
	$ton_clientid = get_option('theme_options');
	
	if( $product_id != '' ){
		
		$clientid = $ton_clientid['ton_clientid'];
		
		$url = "https://jewellers.ammazza.me/api/v1/tryon/checkTryon?client_id=".$clientid."&product_id=".$product_id;

		$response = wp_remote_get( $url, array('body' => array('timeout'     => 120) ) );

		if ( !is_wp_error( $response ) ) {
			$request_status = $response['response'];
			$request_bodydata = $response['body'];
			$request_data = json_decode($request_bodydata);


			if( $request_status['code'] == 200 && $request_data->status != 404 ){
				$tryon_btn = "https://tryon.ammazza.me/?product_id=".$product_id."&client_id=".$clientid;			
				return $tryon_btn;
			}
		}
		else {
			return '';
		}
	}else{
		$clientid = $ton_clientid['ton_clientid'];
		$tryon_btn = "https://tryon.ammazza.me/?client_id=".$clientid;		
		return $tryon_btn;		
	}
	
}

/**
 * Action to add tryon button in product detail page
 */

add_action( 'woocommerce_after_add_to_cart_button', 'webar_add_custom_button', 10, 0 );
function webar_add_custom_button() {
	$product_id = get_the_ID();		
	$tryon_button = webar_check_tryon_producs($product_id);
	if( $tryon_button != '' ){
?>
		<a href='javascript:void(0)' class='popup-tryon' data-hid='<?php echo esc_attr($tryon_button); ?>'>Try Now</a>
<?php
	}
};

/**
 * Enqueue scripts and styles for the front end.
 */
function webar_public_scripts() {
	
    // Load main jquery
    wp_enqueue_script( 'jquery', array(), NULL );
    
	// Load public script
	wp_enqueue_script( 'webar-public-js', WEBAR_FRONT_URL . '/public-script.js', array(), NULL );       
     
}
//add action load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'webar_public_scripts' );

function webar_add_footer_styles() {
    // Load our public style stylesheet.
	wp_enqueue_style( 'webar-public-css', WEBAR_FRONT_URL . '/public-style.css', array(), NULL );
};
add_action( 'get_footer', 'webar_add_footer_styles', 99 );

//add shortcode to display try now button anywhere in website
function webar_trynow_button_anywhere(){    
    ob_start();

    $tryon_button = webar_check_tryon_producs();
	if( $tryon_button != '' ){
?>
		<a href='javascript:void(0)' class='popup-tryon' data-hid='<?php echo esc_attr($tryon_button); ?>' ><?php esc_html_e('Try Now','ammazza-webar')?> </a>
<?php
	}
    $html = ob_get_clean();
    return $html;
}
add_shortcode( 'webar-trynow-button-anywhere', 'webar_trynow_button_anywhere');

//add try now button in shop page
function webar_trynow_in_shop(){
    global $webar_products;
    if( is_shop() ){
        $ton_clientid = get_option('theme_options');
		
        $clientid = $ton_clientid['ton_clientid'];

        $url = "https://jewellers.ammazza.me/api/v1/tryon/all/?client_id=".$clientid;

        $response = wp_remote_get( $url, array('body' => array('timeout'     => 120) ) );
        $product_ids = array();
        
        if ( !is_wp_error( $response ) ) {
            $request_status = $response['response'];
            $request_bodydata = $response['body'];
            $request_data = json_decode($request_bodydata);
            
            if( $request_status['code'] == 200 && $request_data->status != 404 ){
                $webar_products = $request_data->data;                
            }
        }
	
    }
}
add_action( 'wp', 'webar_trynow_in_shop' );

/**
 * Action to add tryon button in shop page
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'webar_before_after_btn', 10,2 );
function webar_before_after_btn( $add_to_cart_html, $product ){
        global $webar_products;
        $display_btn = '';
        
        $ton_clientid = get_option('theme_options');
        $clientid = $ton_clientid['ton_clientid'];
        
	$product_id = $product->id;
        if( !empty( $webar_products ) ){
            if( in_array( $product_id, $webar_products ) ){
                $tryon_button = "https://tryon.ammazza.me/?product_id=".$product_id."&client_id=".$clientid;
                $display_btn = "<a href='javascript:void(0)' class='popup-tryon' data-hid='".esc_attr($tryon_button)."'>".esc_html__('Try Now','ammazza-webar')."</a>";
                return $add_to_cart_html . $display_btn;
            }
        }
	return $add_to_cart_html . $display_btn;
}