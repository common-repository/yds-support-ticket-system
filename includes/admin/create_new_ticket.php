<div class="supportadminContainer" id="ticketContainer">
<div class="supportadminHeader">
<h2><?php _e('Submit a ticket','ydssupport'); ?></h2>
</div>
<div class="create_new_ticket"> <span class="alertmsg"></span>
<?php global $wpdb; ?>

    <form class="edit-profile-form submit-ticket-form" id="createbyadminNewticket" method="post" action="" enctype="multipart/form-data">
             <div class="ticket-row">
                 <label><?php _e('USER','ydssupport'); ?></label>
                <select class="input list" name="user_id" id="user_list">
                <option value=""><?php _e('-Select User-','ydssupport'); ?></option>
                <?php
				  $query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta) ORDER BY user_nicename ASC";
				  $users_of_this_role = $wpdb->get_results($query);
				  if ($users_of_this_role)
				  {
					  foreach($users_of_this_role as $user)
					  {
						  $curuser = get_userdata($user->ID);
						  if($curuser->roles[0]!='administrator')
						  {
						  $author_post_url=get_author_posts_url($curuser->ID, $curuser->display_name);
						  echo '<option value="'.$curuser->ID.'">'.$curuser->display_name.'</option>';
						  }
					  }
				  }
	       ?>
     </select>
     <span class="msgerror" id="error_user"></span>
  </div>
  <div class="ticket-row">
                <label><?php _e('CATEGORY','ydssupport'); ?></label>
                <?php $cat_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_category where 1"); ?>
                <select class="input list" name="ydsts_category" id="ydsts_category">
                  <option value=""><?php _e('--Select Support Category--','ydssupport'); ?></option>
                  <?php foreach($cat_record as $catVal){ if($catVal->cat_status==1){ ?>
                  <option value="<?php echo $catVal->ID; ?>"><?php echo $catVal->support_catname; ?></option>
                  <?php }} ?>
                </select>
                <span id="error_cat" class="msgerror"></span>
              </div>
              <div class="ticket-row">
                <label><?php _e('PRIORITY','ydssupport'); ?></label>
                <?php $priority_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_priority where 1"); ?>
                <select name="yds_priorityid" id="yds_priorityid" class="input list">
                <option value=""><?php _e('--Select Priority--','ydssupport'); ?></option>
                <?php foreach($priority_record as $priorityVal){ if($priorityVal->priority_status==1){ ?>
                  <option value="<?php echo $priorityVal->priority_id; ?>"><?php echo $priorityVal->priority_name; ?></option>
                  <?php }} ?>
                </select>
                <span id="error_priority" class="msgerror"></span>
              </div>
        <div class="ticket-row">
                <label><?php _e('SUBJECT','ydssupport'); ?></label>
                <input type="text" class="input" name="support_subject" id="support_subject" />
                <span class="msgerror" id="error_sub"></span>
              </div>
              <!--ticket-row-->
              <div class="ticket-row">
                <label><?php _e('YOUR MESSAGE','ydssupport'); ?></label>
                <textarea rows="8" class="input textarea" name="textmsg" id="textmsg"></textarea>
                <span class="msgerror" id="error_textmsg"></span>
              </div>
              <!--ticket-row-->
              <div class="ticket-row" id="multipleAttachement">
              <label><?php _e('Uploade Attachment','ydssupport'); ?></label>
             <div class="attachment-row"><input name="attachment[]" id="attachfile" type="file">
             <span class="dashicons dashicons-plus-alt cursorPointer" id="addissueField" onclick="addMoreattach(event,this);"></span>
              </div>
              </div>
              <!--field-->
          <div class="ticket-row">
               <input type="hidden" name="redirectUrl" id="redirectUrl" value="<?php echo esc_url(home_url('/wp-admin/admin.php?page=manage-support-ticket&displaytkt=thbs')); ?>" />
              <label></label> <input type="hidden" name="action" value="submitadminNewticket" />
              <input type="submit" name="submittikat" id="submittikat" value="<?php _e('CREATE NEW TICKET','ydssupport'); ?>" class="save-button">
              </div>
            </form>
            <span class="successfullyMessages"></span>
            <span class="wait"><img width="22" height="22" src="<?php echo YDSTS_PLUGIN_URL; ?>/asset/images/ajax-loader.gif" /></span>
          </div>
          <div style="clear:both;"></div>
</div>