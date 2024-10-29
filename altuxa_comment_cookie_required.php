<?php

/* 
 * Plugin Name: Altuxa Comment Cookie Required
 * Version: 1.0
 * Plugin URI: https://wordpress.org/plugins/altuxa-comment-cookie-required
 * Description: Force user to accept cookies when posting a comment.
 * Author: Mikel Gonzalez
 * Author URI: https://altuxa.net/
 * License: AGPLv3 or later
 * Text Domain: altuxa-comment-cookie-required 
 */

//load tranlations
function altuxa_ccr_translations() {
    load_plugin_textdomain( 'altuxa-comment-cookie-required', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action('plugins_loaded', 'altuxa_ccr_translations');

//Check if cookies where accepted and die if not
function altuxa_ccr_checkpost( $commentdata ) {
    if ( (get_option( 'show_comments_cookies_opt_in' ) == 1) && (! ( $_POST['wp-comment-cookies-consent'] == "yes" ) )){
        wp_die( __('You must to allow us to save your name, email, and website in this browser.', 'altuxa-comment-cookie-required') );
    }
    else {return $commentdata;}
}
add_filter( 'preprocess_comment', 'altuxa_ccr_checkpost' );

//add required to input and * to label
function altuxa_ccr_form($fields) {
	if (get_option( 'show_comments_cookies_opt_in' ) == 1){
		$fields['cookies'] = str_replace('type="checkbox"', 'required="required" type="checkbox"', $fields['cookies']);
		$fields['cookies'] = str_replace('</label>', ' <span class="required">*</span></label>', $fields['cookies']);
	return $fields;
	}
	else {return $fields;}
}

add_filter( 'comment_form_default_fields', 'altuxa_ccr_form' )

?>
