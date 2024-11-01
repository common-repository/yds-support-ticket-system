<form id="yds_login_form"  class="yds_form">
<fieldset>
	<p>
<input name="yds_user_Login" id="yds_user_Login" class="required" type="text" placeholder="<?php _e('Username','ydssupport'); ?>"/>
	</p>
	<p>
		<input name="yds_user_pass" id="yds_user_pass" class="required" type="password" placeholder="<?php _e('Password','ydssupport'); ?>"/>
	</p>
	<p>
        <input type="hidden" name="action" value="ydsloginformControl" />
		<input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('yds-login-nonce'); ?>"/>
        <input type="hidden" name="loginredirectUrl" id="loginredirectUrl" value="<?php echo get_permalink($post->ID); ?>"/>
		<input id="pippin_login_submit" type="submit" value="<?php _e('Login','ydssupport'); ?>"/></p>
       <p class="f-text"><a href="#" class="ragister-link"><?php _e('Register Here','ydssupport'); ?></a> <?php _e('to Submit a Support Ticket','ydssupport'); ?></p>
	   <span class="loginError"></span>
</fieldset>
</form>

<!--Registration Form--->
<form id="yds_registration_form" class="yds_form" action="" method="POST">
<fieldset>
	<p>
<input name="yds_user_name" id="yds_user_name" class="required" type="text" placeholder="<?php _e('Username','ydssupport'); ?>"/>
  <span id="loginregError" class="regError"></span>
	</p>
	<p>
<input name="yds_user_email" id="yds_user_email" class="required" type="email" placeholder="<?php _e('Email','ydssupport'); ?>"/>
   <span id="emailregError" class="regError"></span>
	</p>
	<p>
<input name="yds_user_first" id="yds_user_first" type="text" placeholder="<?php _e('First Name','ydssupport'); ?>"/>
   <span id="fnameregError" class="regError"></span>
	</p>
	<p>
		<input name="yds_user_last" id="yds_user_last" type="text" placeholder="<?php _e('Last Name','ydssupport'); ?>"/>
        <span id="lnameregError" class="regError"></span>
	</p>
	<p>
		<input name="yds_user_regpass" id="yds_user_regpass" class="required" type="password" placeholder="<?php _e('Password','ydssupport'); ?>"/>

                    <span id="passregError" class="regError"></span>
	</p>
	<p>
		<input name="yds_user_pass_confirm" id="yds_user_pass_confirm" class="required" type="password" placeholder="<?php _e('Confirm Password','ydssupport'); ?>"/>

                    <span id="againpassregError" class="regError"></span>
	</p>
	<p>

                    <input type="hidden" name="action" value="yds_registration"/>

                    <input type="hidden" name="redirectUrl" id="redirectUrl" value="<?php global $post; echo esc_url(get_permalink($post->ID)); ?>"/>
		<input type="hidden" name="yds_register_nonce" value="<?php echo wp_create_nonce('yds-register-nonce'); ?>"/>
		<input type="submit" value="<?php _e('Register Your Account','ydssupport'); ?>"/>
	</p>
</fieldset>

</form>

        

 

        