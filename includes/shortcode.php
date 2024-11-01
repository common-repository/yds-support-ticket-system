<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}

final class YDSSupportTicketSystemFrontEnd{
	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'loadScripts') );
		add_shortcode('yds_support_ticket_system', array($this, 'yds_support_ticket_shortcode'));
		add_filter('the_content', array($this, 'yds_support_ticket_page'));
	}

	function loadScripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-tabs'); //load tabs
	}

	function yds_support_ticket_shortcode(){
		wp_enqueue_style('yds_font_awesome_min',YDSTS_PLUGIN_URL.'asset/css/font-awesome.min.css', false, '4.6.3', 'all' );
		wp_enqueue_style('yds_frontend_css',YDSTS_PLUGIN_URL.'asset/css/yds_frontend_css.css', false, '1.0.0', 'all' );
		wp_enqueue_script('yds_frontend_settings', YDSTS_PLUGIN_URL.'asset/js/ydsts_front_end.js', array(), '1.0.0', true);
		wp_localize_script('yds_frontend_settings', 'ydsts_ajax_data', array('ydsts_ajax_url' => admin_url( 'admin-ajax.php')));
		$generalSettings=get_option('ydsts_general_settings');
		?>

		<?php
		ob_start();
		echo '<div class="support_ydsts">';
		if(is_user_logged_in()){
			include_once(YDSTS_PLUGIN_DIR.'includes/loggedInUser.php' );
		}
		else if($generalSettings['enable_guest_ticket']){
			include_once(YDSTS_PLUGIN_DIR.'includes/guestUser.php' );
		}
		echo '</div>';
		return ob_get_clean();
	}
	function yds_support_ticket_page($content)
	{
		$generalSettings=get_option('ydsts_general_settings');
		if($generalSettings['page_id']!=0)
		{
		if(is_page($generalSettings['page_id']))
		{
		wp_enqueue_style('yds_font_awesome_min',YDSTS_PLUGIN_URL.'asset/css/font-awesome.min.css', false, '4.6.3', 'all' );
		wp_enqueue_style('yds_frontend_css',YDSTS_PLUGIN_URL.'asset/css/yds_frontend_css.css', false, '1.0.0', 'all' );
		wp_enqueue_script('yds_frontend_settings', YDSTS_PLUGIN_URL.'asset/js/ydsts_front_end.js', array(), '1.0.0', true);
		wp_localize_script('yds_frontend_settings', 'ydsts_ajax_data', array('ydsts_ajax_url' => admin_url( 'admin-ajax.php')));
		$generalSettings=get_option('ydsts_general_settings');
		ob_start();
		echo '<div class="support_ydsts">';
		if(is_user_logged_in()){
			include_once(YDSTS_PLUGIN_DIR.'includes/loggedInUser.php' );
		}
		else if($generalSettings['enable_guest_ticket']){
			include_once(YDSTS_PLUGIN_DIR.'includes/guestUser.php' );
		}
		echo '</div>';
		return ob_get_clean();
		
	}else 
	{
		return $content;
	}
	}else 
	{
		return $content;
	}
	}
}
$GLOBALS['YDSSupportTicketSystemFrontEnd'] =new YDSSupportTicketSystemFrontEnd();
?>