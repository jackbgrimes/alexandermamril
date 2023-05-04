<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'chld_thm_cfg_parent' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );




add_action('wp_head', 'myplugin_ajaxurl');



// My functions

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

function get_amount() {
    $amount = $_REQUEST["amount"];
    $modal =  ' <div class="modal-button">
                        <div id="paypal-button-container"></div>
                </div>    
                <div class="modal-button">';

    $modal .= do_shortcode("[accept_stripe_payment name='Cool Script' price='".$amount."' url='http://example.com/downloads/my-script.zip' button_text='Pay with Stripe' class='']");                           
    $modal .=       '</div> 
                    <div class="modal-button">';
    $modal .=  do_shortcode("[wp_paypal button='buynow' name='My product' amount='".$amount."']");                                 
    $modal .=       '</div> 
                    <div class="modal-button">
                        <a href="#" rel="modal:close" style="float: right;">Cancel</a>
                    </div>';         
    echo $modal;
  
 }


add_action( 'wp_ajax_nopriv_get_amount', 'get_amount' );
add_action( 'wp_ajax_get_amount', 'get_amount' );


function script_enqueuer() {
   

    wp_enqueue_script( 'jquery' );
 
}

// add_action("wp_ajax_my_user_like", "my_user_like");


// END ENQUEUE PARENT ACTION
