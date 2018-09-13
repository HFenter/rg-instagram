<?php
if ( ! defined( 'ABSPATH' ) ) exit; // bail out, this isn't legit

function rg_ig_menu() {
    add_menu_page(
        'RG Instagram Admin',
        'RG Instagram',
        'manage_options',
        'rg-instagram',
        'rg_ig_settings',
		'dashicons-palmtree'
    );
    
}
add_action('admin_menu', 'rg_ig_menu');

function rg_ig_settings() {
	//Defaults
    $rg_ig_defaults = array(
		'rg_ig_userid'      		=> '',
		'rg_ig_token'      		=> '',
        'rg_ig_show_hash'      	=> ''
    );
    
	//make an array out of options
    $opts = wp_parse_args(get_option('rg_ig_opts'), $rg_ig_defaults);
	update_option( 'rg_ig_opts', $opts );
	


    //Check valid
    if ( ! isset( $_POST['rg_ig_opts_nonce'] ) || ! wp_verify_nonce( $_POST['rg_ig_opts_nonce'], 'rg_ig_opts_save' ) ) {
        //Nonce failed, don't do anything else
    } else {
        // is the hidden field set to save?
        if($_POST['rg-ig-do-save'] == '1' ) {
			
			// clean the options
			$opts[ 'rg_ig_userid' ]		 = sanitize_text_field( $_POST[ 'rg_ig_userid' ] );
			$opts[ 'rg_ig_token' ]		 = sanitize_text_field( $_POST[ 'rg_ig_token' ] );
			$opts[ 'rg_ig_show_hash' ]	 = sanitize_text_field( $_POST[ 'rg_ig_show_hash' ] );
			
            //Save the settings to the settings array
            update_option( 'rg_ig_opts', $opts );

        ?>
		<div class="updated notice is-dismissible"><p><strong><?php _e('Settings saved..', 'rg-instagram' ); ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>


    <?php 
		}
	}	// end save opts loop
	
	 ?>


    <div id="rg_admin" class="wrap">

        <div id="header">
            <h1><?php _e('Instagram Feed', 'rg-instagram'); ?></h1>
        </div>
    
        <form name="rg-ig-opts" method="post" action="">
            <input type="hidden" name="rg-ig-do-save" value="1">
            <?php wp_nonce_field( 'rg_ig_opts_save', 'rg_ig_opts_nonce' ); ?>

            

            
            <table class="form-table">
                <tbody>
                    <h3><?php _e('Basic Setup','rg-instagram'); ?></h3>

                    <div id="rg_ig_get_token">
                        <?php
						if($_REQUEST['error']==1 && $_REQUEST['error_description']!=''){
							// had an error requesting their token
							echo '<strong>There was an error Requesting your Access Token: <em>"'.$_REQUEST['error_description'].'"</em></strong><br>Please Try Again, and if it continues to fail, contact support.';
						}
						?>
                        
                        <a href="https://instagram.com/oauth/authorize/?client_id=c8b73947315f4f4e93a904e5ec7c8883&response_type=code&scope=basic+public_content&redirect_uri=http://therovegroup.com/rg-ig/rgfeedredir.php?rt=<?php echo admin_url('admin.php?page=rg-instagram'); ?>" class="btn"><?php _e('Go to Instagram for my Access Token and User ID','rg-instagram'); ?></a>
                    </div>
                    
                    <tr valign="top">
                        <th scope="row"><label><?php _e('Access Token','rg-instagram'); ?></label></th>
                        <td>
                            <input name="rg_ig_token" id="rg_ig_token" type="text" value="<?php esc_attr_e( $opts['rg_ig_token'],'rg-instagram' ); ?>" size="60" maxlength="60" placeholder="Look Above to Get A Token" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label><?php _e('Show Photos From:','rg-instagram'); ?></label></th>
                        <td>
                            
                                <label for="rg_ig_userid">User ID(s):</label>
                                <input name="rg_ig_userid" id="rg_ig_userid" type="text" value="<?php esc_attr_e( $opts['rg_ig_userid'],'rg-instagram' ); ?>" size="25" />
                                
                           
                        </td>
                    </tr>
                     <tr valign="top">
                        <th scope="row"><label><?php _e('Show Images with Hashtag:','rg-instagram'); ?></label></th>
                        <td>
                            
                                <label for="rg_ig_show_hash">Hashtag(s):</label>
                                <input name="rg_ig_show_hash" id="rg_ig_show_hash" type="text" value="<?php esc_attr_e( $opts['rg_ig_show_hash'],'rg-instagram' ); ?>" size="25" />
                                <br /><small>Don't include the # hash sysmbo</small>
                           
                        </td>
                    </tr>

                    
                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>
      

   




   

</div> <!-- end #rg_ig_admin -->

<?php } //End Settings page

function rg_ig_admin_header() {
        wp_register_style( 'rg_ig_admin_css', plugins_url('css/rg-ig-admin.css', __FILE__), array(), RGINSTV );
        wp_enqueue_style( 'rg_ig_admin_css' );
		wp_register_script( 'rg_ig_admin_scripts', plugins_url( '/js/rg-instagram-admin.js' , __FILE__ ), array('jquery'), RGINSTV, true );
		wp_enqueue_script('rg_ig_admin_scripts');

}
add_action( 'admin_enqueue_scripts', 'rg_ig_admin_header' );


// Add a Settings link to the plugin on the Plugins page
$plugin_file = 'rg-instagram/rg-instagram.php';
add_filter( "plugin_action_links_{$plugin_file}", 'rg_add_opts_link', 10, 2 );
 
//modify the link by unshifting the array
function rg_add_opts_link( $links, $file ) {
    $rg_settings_link = '<a href="' . admin_url( 'admin.php?page=rg-instagram' ) . '">' . __( 'Settings', 'rg-instagram','rg-instagram' ) . '</a>';
    array_unshift( $links, $rg_settings_link );
 
    return $links;
}




?>