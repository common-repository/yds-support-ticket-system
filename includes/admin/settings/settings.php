<?php
global $generalSettings;
global $emailSettings;
if(isset($_POST['setydsGeneralSubBtn']))
{
	$current_user = wp_get_current_user();
    if ($current_user->has_cap('manage_options')) { 
	$generalSettings=array(
			'page_id'=>absint($_POST['setYdsSupportPage']),
			'enable_guest_ticket'=>absint($_POST['enable_guest_ticket']),
			'enable_upload_attachment'=>absint($_POST['enable_upload_attachment']),
			'default_admin_email'=>sanitize_text_field($_POST['default_admin_email'])
	);
	update_option('ydsts_general_settings',$generalSettings);
	echo '<div class="updated">Your settings have been saved.</div>';
	
}
}

if(isset($_POST['emailsettingsBtn']))
{
	$current_user = wp_get_current_user();
    if ($current_user->has_cap('manage_options')) { 
	$emailSettings=array(
			'new_ticket_created'=>absint($_POST['new_ticket_created']),
			'ticket_reply'=>absint($_POST['ticket_reply']),
			'delete_email'=>absint($_POST['delete_email'])
	);
	update_option('ydsts_email_settings',$emailSettings);
	echo '<div class="updated">Your settings have been saved.</div>';
	
}
}


 
if(get_option('ydsts_general_settings') || get_option('ydsts_email_settings'))
{
$generalSettings=get_option('ydsts_general_settings');
$emailSettings=get_option('ydsts_email_settings');
}
?>

<div id="tabs">
<div class="tab_title"><?php _e('SETTINGS','ydssupport'); ?></div><!--tab_title-->
  <ul>
      <li><a href="#general_setting"><?php _e('General Settings','ydssupport'); ?></a></li>
     <li><a href="#mail_setting"><?php _e('Mail Settings','ydssupport'); ?></a></li>
  </ul>
  <div id="general_setting">
  <form action="" method="post">
    <div class="setting-right">
      <?php $pages=get_pages( array('post_type' => 'page','post_status' => 'publish')); ?>
   <p><select id="setYdsSupportPage" name="setYdsSupportPage">
     <option value="0" <?php echo ($generalSettings['page_id']==0)?'selected="selected"':'';?>><?php _e('Select Page','ydssupport'); ?></option>
       <?php
		foreach ($pages as $page){
			$selected=($generalSettings['page_id']==$page->ID)?'selected="selected"':'';
			echo '<option '.$selected.' value="'.$page->ID.'">'.$page->post_title.'</option>';
		}
		?>
    </select></p>
    <p><small><?php _e('Page where ticket system will be displayed. This page should contain the shortcode [yds_support_ticket_system]','ydssupport'); ?></small></p>
<p><label><input <?php echo ($generalSettings['enable_guest_ticket']==1)?'checked="checked"':'';?> type="checkbox" value="1" id="setydsEnableGuestTicket" name="enable_guest_ticket" /></label><label><?php _e('Enable Guest Tickets','ydssupport'); ?></label><br/><small><?php _e('This will allow guest users to submit ticket','ydssupport') ?></small></p>
<p><label><input <?php echo ($generalSettings['enable_upload_attachment']==1)?'checked="checked"':'';?> type="checkbox" value="1" id="enableUploadAttachment" name="enable_upload_attachment" /></label><label><?php _e('Enable Upload Attachment','ydssupport'); ?></label><br/><small><?php _e('This will allow users to upload attachment with the ticket','ydssupport'); ?></small></p>
<p><label><input type="text" id="defaultadminEmail" name="default_admin_email" value="<?php if($generalSettings['default_admin_email']){echo $generalSettings['default_admin_email']; }else { echo get_option('admin_email');} ?>" /></label><br/><small><?php _e('Default Assignee email','ydssupport'); ?> </small></p>
<button class="btn btn-success" id="setydsGeneralSubBtn" name="setydsGeneralSubBtn" type="submit"><?php _e('Save Settings','ydssupport'); ?></button>
    </div>
    <div style="clear:both;"></div>
</form>
  </div>
    
  <div id="mail_setting">
 <form action="" method="post">
   <div class="setting-right">
   <p><label><input <?php echo ($emailSettings['new_ticket_created']==1)?'checked="checked"':'';?> type="checkbox" value="1" id="newticketCreated" name="new_ticket_created" /></label><label><?php _e('Enable New Ticket Email','ydssupport'); ?></label><br/><small><?php _e('Do you want to activate this e-mail template?','ydssupport')?></small></p>
<p><label><input <?php echo ($emailSettings['ticket_reply']==1)?'checked="checked"':'';?> type="checkbox" value="1" id="ticketReply" name="ticket_reply" /></label><label><?php _e('Enable Ticket Reply Email','ydssupport'); ?></label><br/><small><?php _e('Do you want to activate this e-mail template?','ydssupport')?></small></p>
<p><label><input <?php echo ($emailSettings['delete_email']==1)?'checked="checked"':'';?> type="checkbox" value="1" id="deleteEmail " name="delete_email" /></label><label><?php _e('Enable Delete Email','ydssupport'); ?> </label><br/><small><?php _e('Do you want to activate this e-mail template?','ydssupport'); ?></small></p>
<button class="btn btn-success" id="emailsettingsBtn" name="emailsettingsBtn" type="submit"><?php _e('Save Settings','ydssupport'); ?></button>
</div>
<div style="clear:both;"></div>
</form>
</div>
</div>
