<?php
/**
* Plugin Name: YDS Support Ticket System
* Plugin URI: https://wordpress.org/plugins/yds-support-ticket-system/
* Description: YDS Support Ticket System enables you to easily create your own ticket system on your WordPress Theme. 
* License: GPL v2
* Version: 1.0
* Author: ydesignservices
* Author URI: http://www.ydesignservices.com/
*/
if (! defined( 'ABSPATH')){
	exit; // Exit if accessed directly
}

final class YdsSupportTicketSystem{
	       public function __construct() {
           $this->define_constants();
           register_activation_hook( __FILE__, array($this,'installation') );
           $this->installation();
           $this->include_files();
		   load_plugin_textdomain('yds-support-ticket', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	private function define_constants() {
		  define('YDSTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		  define('YDSTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		  define('YDSTS_VERSION', '7.0.3' );
	}

       private function include_files(){
			  if (is_admin()) {
				 include_once(YDSTS_PLUGIN_DIR.'includes/admin/admin.php');
				 include_once(YDSTS_PLUGIN_DIR.'includes/admin/ajax.php');
				 $ajax=new YdsSupportAjax();
				 add_action('wp_ajax_submituserNewticket', array( $ajax, 'submituserNewticket'));
				 add_action('wp_ajax_nopriv_submituserNewticket', array( $ajax, 'submituserNewticket'));
				 add_action('wp_ajax_getproductnamebyTerm', array( $ajax, 'getproductnamebyTerm'));
				 add_action('wp_ajax_supportCat', array( $ajax, 'supportCat'));
				 add_action('wp_ajax_nopriv_supportCat', array( $ajax, 'supportCat'));
				 add_action('wp_ajax_displayCat', array( $ajax, 'displayCat'));
				 add_action('wp_ajax_ticketDetail', array( $ajax, 'ticketDetail'));
				 add_action('wp_ajax_responseTicket', array( $ajax, 'responseTicket'));
				 add_action('wp_ajax_nopriv_responseTicket', array( $ajax, 'responseTicket'));
				 add_action('wp_ajax_ticketFrontdetail', array( $ajax, 'ticketFrontdetail'));
                 add_action('wp_ajax_deleteCategory',array($ajax,'deleteCategory'));
				 add_action('wp_ajax_saveCatvalue', array( $ajax, 'saveCatvalue'));
				 add_action('wp_ajax_nopriv_saveCatvalue', array( $ajax, 'saveCatvalue'));
				 add_action('wp_ajax_searchFilter', array( $ajax, 'searchFilter'));
				 add_action('wp_ajax_nopriv_searchFilter', array( $ajax, 'searchFilter'));
				 add_action('wp_ajax_deleteadTicket', array( $ajax, 'deleteadTicket'));
				 add_action('wp_ajax_submitadminNewticket', array( $ajax, 'submitadminNewticket'));
				 add_action('wp_ajax_nopriv_submitadminNewticket', array( $ajax, 'submitadminNewticket'));
				 add_action('wp_ajax_yds_registration', array( $ajax, 'yds_registration'));
				 add_action('wp_ajax_nopriv_yds_registration', array( $ajax, 'yds_registration'));
				 add_action('wp_ajax_getUsertkt', array( $ajax, 'getUsertkt'));
				 add_action('wp_ajax_getTicketpage', array( $ajax, 'getTicketpage'));
				 add_action('wp_ajax_upcategoryStatus', array( $ajax, 'upcategoryStatus'));
				 add_action('wp_ajax_ydsloginformControl', array( $ajax, 'ydsloginformControl'));
				 add_action('wp_ajax_nopriv_ydsloginformControl', array( $ajax, 'ydsloginformControl'));
				 add_action('wp_ajax_addPriority', array( $ajax, 'addPriority'));
				 add_action('wp_ajax_nopriv_addPriority', array( $ajax, 'addPriority'));
				 add_action('wp_ajax_displayPriority', array( $ajax, 'displayPriority'));
				 add_action('wp_ajax_updatePriorityval', array( $ajax, 'updatePriorityval'));
				 add_action('wp_ajax_nopriv_updatePriorityval', array( $ajax, 'updatePriorityval'));
				 add_action('wp_ajax_updatepriorityStatus', array( $ajax, 'updatepriorityStatus'));
				 add_action('wp_ajax_deletePriority', array( $ajax, 'deletePriority'));
				 add_action('wp_ajax_showcreateTicketForm', array( $ajax, 'showcreateTicketForm'));
                 add_action('wp_ajax_showeditProfileForm', array( $ajax, 'showeditProfileForm'));
                 add_action('wp_ajax_updateUserDetail', array( $ajax, 'updateUserDetail'));
                 add_action('wp_ajax_nopriv_updateUserDetail', array( $ajax, 'updateUserDetail'));
		         add_action('wp_ajax_getfrontTicketpage', array( $ajax, 'getfrontTicketpage'));
				 add_action('wp_ajax_ydscloseTicket', array( $ajax, 'ydscloseTicket'));

          }
		  else {
				   include_once(YDSTS_PLUGIN_DIR.'includes/shortcode.php' );
		        }
	}
	function installation(){
       include_once(YDSTS_PLUGIN_DIR.'includes/admin/installation.php' );
      }
  }
$GLOBALS['YdsSupportTicketSystem'] =new YdsSupportTicketSystem();

?>
