<?php
global $wpdb;
$emailSettings=get_option('ydsts_email_settings');
if($emailSettings['ticket_reply']==1){
$ticket_id=absint($_POST['ticket_id']);
$generalSettings=get_option('ydsts_general_settings');
$sql="select a.ydstsID,a.subject,a.created_by, b.message FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}ydsts_ticket_thread as b ON a.ydstsID=b.ticket_id WHERE b.ticket_id=$ticket_id ORDER BY b.create_time DESC";
$get_createtktmail=$wpdb->get_row($sql);
$user_id=absint($get_createtktmail->created_by);
$user_info=get_userdata($user_id);
$user_mail=$user_info->data->user_email;
$user_nickname=$user_info->data->user_nicename;
if($generalSettings['default_admin_email']){
	        $from = get_bloginfo('name');
			$from_mail=$generalSettings['default_admin_email'];
		}else 
		{
			$from = get_bloginfo('name');
			$from_mail=get_option('admin_email');
		}
/* Mail Body */
		$subject='YDS Tickets: Tracking ID : #'.$ticket_id.' Closed';
		$message='<p>Dear '.$user_nickname.'</p>';
		$message.='<p>Staff just reply of your ticket.</p>';
		$message.='<p>Ticket Subject : '.stripcslashes(html_entity_decode($get_createtktmail->subject, ENT_QUOTES, 'UTF-8')).'</p>';
		$message.='<p>Tracking ID : #'.$ticket_id.'</p>';
		$message.='<p>Your Email ID: : '.$user_mail.'</p>';
		$message.='<p>Ticket message:</p>';
		$message.=stripcslashes(preg_replace("/(\r\n|\n|\r)/", '<br>', $get_createtktmail->message));
		$message.='<h2>*DO NOT REPLY TO THIS E-MAIL*</h2><p>This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>';
		$email_headers="From: $from <$from_mail>" . "\r\n";
		$email_headers.= "Reply-To: $subject <$user_mail>\n";
		$email_headers.= "Return-Path: $subject <$user_mail>\n";
		$email_headers.= "Content-type: text/html; charset=UTF-8 \r\n";
		$email_headers.= "MIME-version: 1.0\n";
		$to=$user_mail;
       wp_mail($to,$subject,$message,$email_headers);
}
?>