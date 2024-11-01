<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
final class YdsStAdmin
{
	public function __construct()
	{
        add_action('admin_enqueue_scripts', array( $this, 'ystsloadScripts') );
		add_action('admin_menu', array($this,'custom_menu_page'));
	}
        
        function ystsloadScripts(){
              wp_enqueue_script('jquery');
			  wp_enqueue_script('jquery-ui-tabs'); //load tabs
		      wp_enqueue_style('jquery_ui_css',YDSTS_PLUGIN_URL.'asset/css/jquery-ui.css', false, '4.6.3', 'all' );
		    }
                
	function custom_menu_page(){
		add_menu_page(__('Yds Support','ydssupport'), __('YDS Support','ydssupport'), 'manage_support_ticket', 'manage-support-ticket', array($this,'tickets'),YDSTS_PLUGIN_URL.'asset/images/icon-maintain.png', '22.56');
		add_submenu_page('manage-support-ticket', __('All Tickets','ydssupport'), __('All Tickets','ydssupport'), 'manage_options', 'manage-support-ticket');
		add_submenu_page('manage-support-ticket', __('Create New Ticket','ydssupport'), __('Create New Ticket','ydssupport'), 'manage_options', 'create-new-ticket', array($this,'create_new_ticket') );
		add_submenu_page('manage-support-ticket', __('Category','ydssupport'), __('Category','ydssupport'), 'manage_options', 'category-settings', array($this,'category_settings') );
 		add_submenu_page('manage-support-ticket', __('Priority','ydssupport'), __('Priority','ydssupport'), 'manage_options', 'priority-settings', array($this,'priority_settings'));
		add_submenu_page('manage-support-ticket', __('Settings','ydssupport'), __('Settings','ydssupport'), 'manage_options', 'yds-support-settings', array($this,'yds_support_settings') );
    }
	function tickets()
	{
          
        wp_enqueue_script('yds_admin_settings',YDSTS_PLUGIN_URL.'asset/js/yds_ticket_management.js', array(), '1.0.0', true);
		wp_enqueue_style('yds_admin_css',YDSTS_PLUGIN_URL.'asset/css/yds-admin-support.css', false, '1.0.0', 'all' );
		wp_localize_script('yds_admin_settings', 'ydsts_ajax_data', array( 'ydsts_ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        include_once('getallticket.php');
      
	}
	function category_settings()
	{
		wp_enqueue_script('yds_admin_settings',YDSTS_PLUGIN_URL.'asset/js/yds_ticket_management.js', array(), '1.0.0', true);
		wp_enqueue_style('yds_admin_css',YDSTS_PLUGIN_URL.'asset/css/yds-admin-support.css', false, '1.0.0', 'all' );
		wp_localize_script('yds_admin_settings', 'ydsts_ajax_data', array( 'ydsts_ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        include_once('create-support-categories.php');
	}
	function create_new_ticket()
	{
		wp_enqueue_script('yds_admin_settings',YDSTS_PLUGIN_URL.'asset/js/yds_ticket_management.js', array(), '1.0.0', true);
		wp_enqueue_style('yds_admin_css',YDSTS_PLUGIN_URL.'asset/css/yds-admin-support.css', false, '1.0.0', 'all' );
		wp_localize_script('yds_admin_settings', 'ydsts_ajax_data', array( 'ydsts_ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        include_once('create_new_ticket.php');
	}
	function priority_settings()
	{
		wp_enqueue_script('yds_admin_settings',YDSTS_PLUGIN_URL.'asset/js/yds_ticket_management.js', array(), '1.0.0', true);
		wp_enqueue_style('yds_admin_css',YDSTS_PLUGIN_URL.'asset/css/yds-admin-support.css', false, '1.0.0', 'all' );
		wp_localize_script('yds_admin_settings', 'ydsts_ajax_data', array( 'ydsts_ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        include_once('addpriority.php');
	}
	function yds_support_settings()
	{
		wp_enqueue_style('yds_admin_css',YDSTS_PLUGIN_URL.'asset/css/yds-admin-support.css', false, '1.0.0', 'all' );
		wp_enqueue_script('yds_admin_settings',YDSTS_PLUGIN_URL.'asset/js/yds_ticket_management.js', array('jquery'), '1.0.0', true);
		wp_localize_script('yds_admin_settings', 'ydsts_ajax_data', array( 'ydsts_ajax_url' => admin_url('admin-ajax.php')));
		include_once('create_support_page.php');
		include_once('settings/settings.php');
		
		
	}
}
$GLOBALS['YdsStAdmin']=new YdsStAdmin();
?>