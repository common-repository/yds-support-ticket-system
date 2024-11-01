<?php global $wpdb;
$current_user = wp_get_current_user();
$get_userdata=get_user_meta($current_user->ID);
 ?>
<h2><?php _e('Edit Profile','ydssupport'); ?></h2>
<form class="form-inline" onsubmit="ydsUpdateUserDetail(event,this);">
            <div class="form-group">
                <div class="field">
                <input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>" />
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="<?php _e('First Name','ydssupport'); ?>" value="<?php echo esc_html($get_userdata['first_name'][0],'ydssupport'); ?>">
              </div>
                <div class="field">
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="<?php _e('Last Name','ydssupport'); ?>" value="<?php echo esc_html($get_userdata['last_name'][0],'ydssupport'); ?>">
              </div>
              </div>
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="<?php _e('Email','ydssupport'); ?>" value="<?php echo esc_html($current_user->user_email,'ydssupport'); ?>">
              </div>
            <div class="form-group">
           
             <textarea name="biographicalInfo" rows="8" class="form-control" id="biographicalInfo" placeholder="<?php _e('Biographical Info','ydssupport'); ?>"><?php if(isset($get_userdata['biographical_info'][0])){ echo stripcslashes($get_userdata['biographical_info'][0]); } ?></textarea>   
              
                <input type="hidden" name="action" value="updateUserDetail" />
             
              </div>
            <button type="submit" class="btn btn-primary ydsCreate-button"><?php _e('Save Changes','ydssupport'); ?></button>
          </form>
          <span class="profileUpdated"></span>