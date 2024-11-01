<div class="supportadminContainer" id="ticketContainer">
<div class="supportadminHeader">
<h2><?php $current_user = wp_get_current_user(); global $wpdb; _e('Create Ticket','ydssupport'); ?></h2>
</div>
  
 <div class="create_new_ticket"> <span class="alertmsg"></span>
<form class="edit-profile-form submit-ticket-form" id="submitUsertktform" onsubmit="submitTicketByUser(event,this);">
              <fieldset class="form-group">
               <?php  $cat_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_category where 1"); ?>
                <select class="form-control" name="ydsts_category" id="ydsts_category">
                  <option value=""><?php _e('--Select Support Category--','ydssupport'); ?></option>
                  <?php foreach($cat_record as $catVal){ if($catVal->cat_status==1){ ?>
                  <option value="<?php echo absint($catVal->ID); ?>"><?php echo esc_html($catVal->support_catname); ?></option>
                  <?php }} ?>
                </select>
                <span id="error_cat" class="msgerror"></span>
              </fieldset>
             <fieldset class="form-group">
              <input type="hidden" name="user_id" id="user_id" value="<?php echo absint($current_user->ID); ?>" />   
                <?php $priority_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_priority where 1"); ?>
                <select name="yds_priorityid" id="yds_priorityid" class="form-control">
                <option value=""><?php _e('Select Priority','ydssupport'); ?></option>
                <?php foreach($priority_record as $priorityVal){ if($priorityVal->priority_status==1){ ?>
                  <option value="<?php echo $priorityVal->priority_id; ?>"><?php echo esc_html($priorityVal->priority_name); ?></option>
                  <?php }} ?>
                </select>
                <span id="error_priority" class="msgerror"></span>
             </fieldset>
             <fieldset class="form-group">
              <input type="text" class="form-control" name="support_subject" id="support_subject" placeholder="<?php _e('Subject','ydssupport'); ?>"/>
                <span class="msgerror" id="error_sub"></span>
             </fieldset>
              <!--ticket-row-->
              
              <fieldset class="form-group">
               <textarea rows="7" name="textmsg" id="textmsg" placeholder="<?php _e('Message','ydssupport'); ?>"></textarea>
                <span class="msgerror" id="error_textmsg"></span>
              </fieldset>
              <!--ticket-row-->
              <?php if(get_option('ydsts_general_settings')){ $generalSettings=get_option('ydsts_general_settings'); if($generalSettings['enable_upload_attachment']==1){ ?>
              <fieldset class="form-group" id="multipleAttachement">
             <div class="attachment-row"> <input name="attachment[]" id="attachfile" class="form-control-file" type="file">
             <span class="dashicons dashicons-plus-alt cursorPointer" id="addissueField" onclick="addMoreattach(event,this);"></span>
              </div>
             </fieldset>
              <?php }} ?>
              <!--field-->
               <fieldset class="form-group">
              <input type="hidden" name="action" value="submituserNewticket" />
              <input type="submit" name="submittikat" id="submittikat" value="<?php _e('SUBMIT TICKET','ydssupport'); ?>" class="ydsCreate-button">
             </fieldset>
            </form>
         
            <span class="successfullyMessages"></span>
            <span class="wait"><img src="<?php echo YDSTS_PLUGIN_URL; ?>/asset/images/ajax-loader.gif" /></span>
          </div>
          <div style="clear:both;"></div>
</div>