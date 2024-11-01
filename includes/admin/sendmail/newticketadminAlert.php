<?php
global $wpdb;
$emailSettings=get_option('ydsts_email_settings');
if($emailSettings['new_ticket_created']==1){
$user_id=absint($_POST['user_id']);
$user_info=get_userdata($user_id);
$user_mail=$user_info->data->user_email;
$user_nickname=$user_info->data->display_name;
$generalSettings=get_option('ydsts_general_settings');
    if($generalSettings['default_admin_email']){
	$from=get_bloginfo('name');
	$from_mail=$generalSettings['default_admin_email'];
	}else 
		{
			$from = get_bloginfo('name');
			$from_mail=get_option('admin_email');
		}


$sql="select a.ydstsID,a.subject, b.message FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}ydsts_ticket_thread as b ON a.ydstsID=b.ticket_id WHERE b.ticket_id=$ticket_id ORDER BY b.create_time DESC";
$get_createtktmail=$wpdb->get_row($sql);

		/* Mail Body */
		$subject='YDS Tickets: New Ticket Received';
		$message='<p>Hello,</p>';
		$message.='<p>A new support ticket has been submitted. Ticket details.</p>';
		$message.='<p>Ticket Subject : '.stripcslashes(html_entity_decode($get_createtktmail->subject, ENT_QUOTES, 'UTF-8')).'</p>';
		$message.='<p>Tracking ID : #'.$ticket_id.'</p>';
		$message.='<p>Your Email ID: : '.$user_mail.'</p>';
		$message.=stripcslashes(preg_replace("/(\r\n|\n|\r)/", '<br>', $get_createtktmail->message));
		$message.='<h2>*DO NOT REPLY TO THIS E-MAIL*</h2><p>This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>';
        $email_headers="From: $user_nickname <$user_mail>" . "\r\n";
		$email_headers.= "Reply-To: $subject <$user_mail>\n";
		$email_headers.= "Return-Path: $subject <$user_mail>\n";
		$email_headers.= "Content-type: text/html; charset=UTF-8 \r\n";
		$email_headers.= "MIME-version: 1.0\n";
		if($generalSettings['default_admin_email']){
			$to=$generalSettings['default_admin_email'];
		}else 
		{
			$to=get_option('admin_email');
		}
      wp_mail($to,$subject,$message,$email_headers);
}
		
?>