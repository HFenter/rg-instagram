<?php
// Code Functions for RG-Instagram

// plugin activation
function rg_ig_activate() {
    $opts = get_option('rg_ig_opts');
    update_option( 'rg_ig_opts', $opts );
}
//Uninstall
function rg_ig_uninstall()
{
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    // kill settings in the db
    delete_option( 'rg_ig_opts' );
}



// style and script queues
function rg_ig_enqueue_top() {
    wp_register_style( 'rg_ig_styles', plugins_url('css/rg-ig.css', __FILE__), array(), RGINSTV );
    wp_enqueue_style( 'rg_ig_styles' );  
    //Register the script to make it available
    wp_register_script( 'rg_ig_scripts', plugins_url( '/js/rg-instagram.js' , __FILE__ ), array('jquery'), RGINSTV, true );

    //Options to pass to JS file
    $opts = get_option('rg_ig_opts');

    //Access token
    isset($opts[ 'rg_ig_token' ]) ? $rg_ig_token = trim($rg_ig_opts['rg_ig_token']) : $rg_ig_token = '';

    $data = array(
        'rg_ig_token' => $rg_ig_token
    );

    wp_enqueue_script('rg_ig_scripts');

    //Pass option to JS file
    wp_localize_script('rg_ig_scripts', 'rg_ig_js_options', $data);
}

// custom header & footer code
function rg_ig_header_stuff() {
    // we can add any custom header stuff here.  
	//$opts = get_option('rg_ig_opts');
  	
}
function rg_ig_footer_stuff() {
    // we can add any custom footer stuff here.  
  	//$opts = get_option('rg_ig_opts');
  	
}




/********************* Display Code ************************/

function show_ig($atts, $content = null) {


    /******  SHORTCODE OPTIONS ********************/

    $opts = get_option('rg_ig_opts');
    
    //Shortcode Attrbs
    $atts = shortcode_atts(
    array(
        'id' => isset($opts[ 'rg_ig_userid' ]) ? $opts[ 'rg_ig_userid' ] : '',
        'hash' => isset($opts[ 'rg_ig_show_hash' ]) ? $opts[ 'rg_ig_show_hash' ] : ''
    ), $atts);


    
    
    $userid	 = trim($atts['id']);
	$token	 = trim($opts['rg_ig_token']);
	$hash	 = trim($atts['hash']);


    
    $rg_ig_content = '<div id="rg_ig" class=" " data-id="' . $userid . '" data-num="' . trim($atts['num']) . '" data-res="' . trim($atts['imageres']) . '" data-cols="' . trim($atts['cols']) . '" data-options=\'{&quot;get&quot;: &quot;tagged&quot;,&quot;hashtag&quot;: &quot;blog&quot;,&quot;sortby&quot;: &quot;'.$atts['sortby'].'&quot;}\'>';

    
    //Images container
    $rg_ig_content .= '<div id="rg_ig_images" style="">';

    //Error messages
    $rg_ig_error = false;
    if( $userid=='' ){
        $rg_ig_content .= '<div class="rg_ig_warn"><p>No User ID set in Plugin Settings</p></div>';
        $rg_ig_error = true;
    }
    if( $token == '' ){
        $rg_ig_content .= '<div class="rg_ig_warn"><p>No Access Token set in Plugin Settings</p></div>';
        $rg_ig_error = true;
    }

    //Loader
    if( !$rg_ig_error ) $rg_ig_content .= '<div class="rg_id_loading fa-spin"></div>';

    //Load section
    $rg_ig_content .= '</div><div id="rg_ig_load_more">';

    //Load More
    if(!$rg_inst_error) $rg_ig_content .= '<a class="rg_ig_load_btn" href="javascript:void(0);" '.$rg_ig_button_styles.'>'.$atts['buttontext'].'</a>';


    $rg_ig_content .= '
		</div>
	</div>';

    //Return our feed HTML to display
    return $rg_ig_content;

}
