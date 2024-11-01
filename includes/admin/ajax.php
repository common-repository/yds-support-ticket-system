<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
final class YdsSupportAjax
{
	function submituserNewticket()
	{
		global $wpdb;
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
				
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
	}
				$upload = wp_handle_upload($daFile , array('test_form'=>FALSE));
				//var_dump( $upload);
				$attachments[]=array(
					'name'=>$_FILES['attachment']['name'][$i],
					'file_path'=>$upload['file'],
					'file_url'=>$upload['url'],
					'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		foreach ($attachments as $attachment){
			$values=array(
				'filename'=>$attachment['name'],
				'filetype'=>$attachment['type'],
				'attachments_path'=>$attachment['file_path'],
				'attachments_url'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'ydsts_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
		
		//create ticket
		$values=array(
				'support_cat'=>absint($_POST['ydsts_category']),
				'yds_priorityid'=>absint($_POST['yds_priorityid']),
				'created_by'=>absint($_POST['user_id']),
				'subject'=>htmlspecialchars($_POST['support_subject'],ENT_QUOTES),
				'status'=>1,
				'create_time'=>current_time('mysql', 1),
				'update_time'=>current_time('mysql', 1)
		);
		$wpdb->insert($wpdb->prefix.'ydsts_ticket',$values);
		$ticket_id=$wpdb->insert_id;
		
		//create thread
		$values=array(
				'ticket_id'=>absint($ticket_id),
				'created_by'=>absint($_POST['user_id']),
				'message'=>htmlspecialchars($_POST['textmsg'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
                'create_time'=>current_time('mysql', 1)
		);
		$wpdb->insert($wpdb->prefix.'ydsts_ticket_thread',$values);
		//check mail settings
		include_once('sendmail/newticketadminAlert.php');
		include_once('sendmail/newticketMail.php');
		//end
		echo "1";die();
	}
	
	/*Category Manegment of Yds Support Ticket System*/
	function supportCat()
	{
	   global $wpdb;
	   foreach($_POST['fieldValue'] as $fieldValue)
	   {
		   $values=array('support_catname'=>sanitize_text_field($fieldValue));
	       $wpdb->insert($wpdb->prefix.'ydsts_category',$values);
	   }
	   die();
	}
	
	function displayCat()
	{
		include_once('getadminCat.php');
		die();
	}
	
	function deleteCategory()
	{
		global $wpdb;
		$catId=absint($_POST['catId']);
		$wpdb->delete($wpdb->prefix.'ydsts_category',array('ID' =>$catId));  
		die();
	}
	
	function saveCatvalue()
	{
		global $wpdb;
		$values=array('support_catname'=>sanitize_text_field($_POST['editCatvalue']));
		$wpdb->update($wpdb->prefix.'ydsts_category',$values,array('ID'=>absint($_POST['editCatid'])));
		
		die();
	}
	
	function upcategoryStatus()
	{
		global $wpdb;
		if(absint($_POST['cat_status'])==1)
		{
		$values=array('cat_status'=>0);
		}else 
		{
			$values=array('cat_status'=>1);
		}
		$wpdb->update($wpdb->prefix.'ydsts_category',$values,array('ID' => absint($_POST['cat_id'])));
		
		die();
	}
	
	/*End Category Manegment*/
	
	
	/*PRIORITY Manegment of Yds Support Ticket System*/
	function addPriority()
	{
	   global $wpdb;
	   foreach($_POST['fieldValue'] as $fieldValue)
	   {
		   $values=array('priority_name'=>sanitize_text_field($fieldValue));
	       $wpdb->insert($wpdb->prefix.'ydsts_priority',$values);
	   }
	   die();
	}
	
	function displayPriority()
	{
		include_once('displayPriority.php');
		die();
	}
	
	function deletePriority()
	{
		global $wpdb;
		$priorityId=absint($_POST['priorityId']);
		$wpdb->delete($wpdb->prefix.'ydsts_priority',array('priority_id' =>$priorityId));  
		die();
	}
	
	function updatePriorityval()
	{
		global $wpdb;
		$values=array('priority_name'=>sanitize_text_field($_POST['priorityValue']));
		$wpdb->update($wpdb->prefix.'ydsts_priority',$values,array('priority_id'=>absint($_POST['priorityId'])));
		
		die();
	}
	
	function updatepriorityStatus()
	{
		global $wpdb;
		if(absint($_POST['priorityStatus'])==1)
		{
		$values=array('priority_status'=>0);
		}else 
		{
			$values=array('priority_status'=>1);
		}
		$wpdb->update($wpdb->prefix.'ydsts_priority',$values,array('priority_id' => absint($_POST['priorityId'])));
		
		die();
	}
	
	/*End PRIORITY Manegment*/
	
	function ticketDetail()
	{
		include_once('viewticketDetail.php');
		die();
	}
	
	function ticketFrontdetail()
	{
	  include_once(YDSTS_PLUGIN_DIR.'includes/view/viewticketdetailFront.php');
	  die();	
	}
	
	function responseTicket(){
	
		global $wpdb;
	
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
	
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
				}
				$upload = wp_handle_upload($daFile , array('test_form' => FALSE));
				//var_dump( $upload);
				$attachments[]=array(
						'name'=>$_FILES['attachment']['name'][$i],
						'file_path'=>$upload['file'],
						'file_url'=>$upload['url'],
						'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		foreach ($attachments as $attachment){
			$values=array(
					'filename'=>$attachment['name'],
					'filetype'=>$attachment['type'],
					'attachments_path'=>$attachment['file_path'],
					'attachments_url'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'ydsts_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
	
		//create ticket
		$values=array(
				'status'=>absint($_POST['ticket_status']),
				'update_time'=>current_time('mysql', 1)
				
		);
		$wpdb->update($wpdb->prefix.'ydsts_ticket',$values,array('ydstsID' =>absint($_POST['ticket_id'])));
	
		//create thread
		$values=array(
				'ticket_id'=>absint($_POST['ticket_id']),
				'created_by'=>absint($_POST['user_id']),
				'message'=>htmlspecialchars($_POST['textmsg'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
				'create_time'=>current_time('mysql', 1)		
		);
		$wpdb->insert($wpdb->prefix.'ydsts_ticket_thread',$values);
		//check mail settings
		include_once('sendmail/ticketresponceMail.php');
		//end
		echo "1";die();
	}
	
	
	function searchFilter()
	{
		include_once('adminsearchFilter.php');
		die();
	}
	
	function deleteadTicket()
	{
		global $wpdb;
		$ticket_id=absint($_POST['ticket_id']);
		include_once('sendmail/deleteticketMail.php');
		$wpdb->delete($wpdb->prefix.'ydsts_ticket',array('ydstsID' =>$ticket_id));  
		$wpdb->delete($wpdb->prefix.'ydsts_ticket_thread',array('thrID' =>$ticket_id));  
		$get_thread=$wpdb->get_row("SELECT attachment_ids FROM {$wpdb->prefix}ydsts_ticket_thread where ticket_id=$ticket_id");
		if($get_thread->attachment_ids!='')
		{
			
			$get_attachement=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_attachments WHERE `id` IN(".$get_thread->attachment_ids.")");
			foreach($get_attachement as $get_attachementval)
			{
				$file=$get_attachementval->attachments_url;
				$file_url=str_replace(rtrim(get_site_url(),'/').'/', ABSPATH, $file);
				$delatID=$get_attachementval->id;
				$wpdb->delete($wpdb->prefix.'ydsts_attachments',array('id' =>$delatID));
				unlink($file_url);
			}
		}
		include_once('adminsearchFilter.php');
		die();
		
	}
	
	function ydscloseTicket()
	{
		global $wpdb;
		$values=array(
				'status'=>4,
				'update_time'=>current_time('mysql', 1)
				
		);
		$wpdb->update($wpdb->prefix.'ydsts_ticket',$values,array('ydstsID' =>absint($_POST['ticket_id'])));
		include_once('sendmail/closeticketMail.php');
		include_once('viewticketDetail.php');
		die();
	}
	
	function submitadminNewticket()
	{
	
		global $wpdb;
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
				
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
	}
				$upload = wp_handle_upload($daFile , array('test_form'=>FALSE));
				//var_dump( $upload);
				$attachments[]=array(
					'name'=>$_FILES['attachment']['name'][$i],
					'file_path'=>$upload['file'],
					'file_url'=>$upload['url'],
					'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		foreach ($attachments as $attachment){
			$values=array(
				'filename'=>$attachment['name'],
				'filetype'=>$attachment['type'],
				'attachments_path'=>$attachment['file_path'],
				'attachments_url'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'ydsts_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
		
		//create ticket
		$values=array(
				'support_cat'=>absint($_POST['ydsts_category']),
				'yds_priorityid'=>absint($_POST['yds_priorityid']),
				'created_by'=>absint($_POST['user_id']),
				'subject'=>htmlspecialchars($_POST['support_subject'],ENT_QUOTES),
				'status'=>1,
				'create_time'=>current_time('mysql', 1),
				'update_time'=>current_time('mysql', 1)
		);
		$wpdb->insert($wpdb->prefix.'ydsts_ticket',$values);
		echo $ticket_id=$wpdb->insert_id;
		
		//create thread
		$values=array(
				'ticket_id'=>absint($ticket_id),
				'created_by'=>($_POST['user_id']),
				'message'=>htmlspecialchars($_POST['textmsg'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
                'create_time'=>current_time('mysql', 1)
		);
		$wpdb->insert($wpdb->prefix.'ydsts_ticket_thread',$values);
		//check mail settings
		include_once('sendmail/newticketadminAlert.php');
		include_once('sendmail/newticketMail.php');
		//end
		echo "1";die();
	
	}
	
	
	function getTicketpage()
	{
		include_once('adminsearchFilter.php');
		die();
		
	}
	
	function ydsloginformControl(){
            $info = array();
            $info['user_login'] = sanitize_text_field($_POST['yds_user_Login']);
            $info['user_password'] =sanitize_text_field($_POST['yds_user_pass']);
            $info['remember'] = true;
            $user_signon = wp_signon($info, false);
            if ( is_wp_error($user_signon) ){
              echo $user_signon->get_error_message();
             } else {
              echo 1;
                }
               die();
	 }
	 
	 
	 
	 /*User Registration*/
	 
	 function yds_registration()
	 {
		 $user_login=sanitize_text_field($_POST['yds_user_name']);
		 $user_email=sanitize_text_field($_POST['yds_user_email']);
		 $user_fname=sanitize_text_field($_POST['yds_user_first']);
		 $user_lname=sanitize_text_field($_POST['yds_user_last']);
		 $user_pass=sanitize_text_field($_POST['yds_user_regpass']);
		 if(username_exists($user_login)) {
			echo 1;
			
		}else if(email_exists($user_email)) {
			//Email address already registered
			
			echo 2;
			
		}else 
		{
			$new_user_id = wp_insert_user(array(
					'user_login'		=> $user_login,
					'user_pass'	 		=> $user_pass,
					'user_email'		=> $user_email,
					'first_name'		=> $user_fname,
					'last_name'			=> $user_lname,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'role'				=> 'subscriber'
				)
			);
			if($new_user_id) {
				// send an email to the admin alerting them of the registration
				wp_new_user_notification($new_user_id);
 				// log the new user in
				wp_setcookie($user_login, $user_pass, true);
				wp_set_current_user($new_user_id, $user_login);	
				do_action('wp_login', $user_login);
 
				// send the newly created user to the home page after logging them in
				///wp_redirect(home_url()); exit;
			}
		}
		
		die();
		
	 }
	 
	 /*Display Front End Ticket */
	 function getUsertkt()
	 {
		 $current_user = wp_get_current_user();
		$user_info = get_userdata($current_user->ID);
        $role=implode($user_info->roles);
		if($role=='administrator'){
		include_once(YDSTS_PLUGIN_DIR.'includes/view/getallTicket.php');
		}else 
		{
		  include_once(YDSTS_PLUGIN_DIR.'includes/view/getuserTicket.php');	
		}
		die();
	 }
	 
	 function showcreateTicketForm()
	 {
		include_once(YDSTS_PLUGIN_DIR.'includes/view/create_new_ticketbyuser.php');
		die();  
	 }
	 
	 function showeditProfileForm()
	 {
		include_once(YDSTS_PLUGIN_DIR.'includes/view/editProfile.php');
		die();  
	 }
	 
	 function updateUserDetail()
	 {
		 $user_id=absint($_POST['user_id']);
		 $firstName=sanitize_text_field($_POST['firstName']);
		 $lastName=sanitize_text_field($_POST['lastName']);
		 $email=sanitize_email($_POST['email']);
		 $biographicalInfo=htmlspecialchars($_POST['biographicalInfo'],ENT_QUOTES);
		 $userdata=array('user_email'=>$email,'first_name' => $firstName,'last_name' => $lastName,'biographical_info'=>$biographicalInfo,'ID' => $user_id);
		 update_user_meta($user_id, 'biographical_info', $biographicalInfo);
		 $update_user=wp_update_user($userdata);
		 if (is_wp_error($update_user)){
	           echo 'Sorry there was a problem!';
		  } else {
			 echo 'Profile updated successfully!';
		  }
		  
		  die();
	 }
	 
	 function getfrontTicketpage()
	 {
		 
		 $current_user = wp_get_current_user();
		 $user_info = get_userdata($current_user->ID);
         $role=implode($user_info->roles);
		 if($role=='administrator'){
		 include_once(YDSTS_PLUGIN_DIR.'includes/view/getpageallTicket.php');
		 }else 
		  {
		  include_once(YDSTS_PLUGIN_DIR.'includes/view/getpageuserTicket.php');
		  }
		die();
		
	 }
	
	
}
?>