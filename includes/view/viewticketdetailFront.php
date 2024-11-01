<?php
global $wpdb;
$current_user = wp_get_current_user();
$ticket_id=absint($_POST['ticket_id']);
$sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id WHERE a.ydstsID=$ticket_id";
$tickets=$wpdb->get_results($sql);
if(count($tickets)>0)
{
foreach($tickets as $ticketsval){
	    $modified='';
		if ($ticketsval->date_modified_month) $modified=$ticketsval->date_modified_month.' months ago';
		else if ($ticketsval->date_modified_day) $modified=$ticketsval->date_modified_day.' days ago';
		else if ($ticketsval->date_modified_hour) $modified=$ticketsval->date_modified_hour.' hours ago';
		else if ($ticketsval->date_modified_min) $modified=$ticketsval->date_modified_min.' minutes ago';
		else $modified=$ticketsval->date_modified_sec.' seconds ago';	


echo '<div class="supportadminHeader">
<h2>[Ticket #'.$ticket_id.'] <span>'.stripcslashes($ticketsval->subject).'</span><a href="#gotoreply" class="Reply">'.__('Go To Reply','ydssupport').'</a></h2>
</div>';

	
	 ?>


<div class="ticketDetail viewticketDetail">
<table border="1" width="100%">
<tr>
<th><?php _e('PRIORITY','ydssupport'); ?></th>
<th><?php _e('CATEGORY','ydssupport'); ?></th>
<th><?php _e('CREATED BY','ydssupport'); ?></th>
<th><?php _e('STATUS','ydssupport'); ?></th>
<th><?php _e('UPDATE ON','ydssupport'); ?></th>
</tr>
<tr>
<td><?php echo ucfirst($ticketsval->priority_name); ?></td>
<td><?php echo ucfirst($ticketsval->support_catname); ?></td>
<td><?php echo ucfirst($ticketsval->display_name); ?></td>
<td><?php if($ticketsval->status=='pending'){ ?>
<div class="pending"><?php _e('Pending','ydssupport'); ?></div>
<?php } if($ticketsval->status==1){ ?>
<div class="new"><?php _e('New','ydssupport'); ?></div>
<?php } if($ticketsval->status==2){ ?>
<div class="open"><?php _e('Waiting Your Reply','ydssupport'); ?></div>
<?php } if($ticketsval->status==3){ ?>
<div class="open"><?php _e('Waiting Staff Reply','ydssupport'); ?></div>
<?php } if($ticketsval->status==4){ ?>
<div class="closed"><?php _e('Closed','ydssupport'); ?></div>
<?php } ?></td>
<td><?php echo esc_html($modified); ?></td>
</tr>
</table>
<?php } } else { echo 'Not found'; }?>
</div>
<div class="adminticketdetailcontent">
<?php
$thread_sql="select thrID,message,attachment_ids,created_by,TIMESTAMPDIFF(MONTH,create_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,create_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,create_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,create_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,create_time,UTC_TIMESTAMP()) as date_modified_sec
		FROM {$wpdb->prefix}ydsts_ticket_thread WHERE ticket_id=".$_POST['ticket_id'].' ORDER BY create_time DESC' ;
$threads= $wpdb->get_results($thread_sql);

foreach ($threads as $thread){
	  $user_name='';
	  $user_email='';
	  $user=get_userdata($thread->created_by);
	  $user_name=$user->display_name;
	  $user_email=$user->user_email;
	  $attachments=array();
	  if($thread->attachment_ids){
		  $attachments=explode(',', $thread->attachment_ids);
	  }
	  
	    $thread_modified='';
		if ($thread->date_modified_month) $thread_modified=$thread->date_modified_month.' months ago';
		else if ($thread->date_modified_day) $thread_modified=$thread->date_modified_day.' days ago';
		else if ($thread->date_modified_hour) $thread_modified=$thread->date_modified_hour.' hours ago';
		else if ($thread->date_modified_min) $thread_modified=$thread->date_modified_min.' minutes ago';
		else $thread_modified=$thread->date_modified_sec.' seconds ago';	
	  
	  
?>

<div class="adminticketdetailSection">
<div class="adminGravtar">
<img src="<?php echo get_gravatar($user_email,60);?>">
</div>
<div class="adminticketMsg">
<div class="threadInfo">
   <span class="threadUserName"><?php echo esc_html($user_name);?></span><br>
   <small class="threadUserType"><?php echo esc_html($user_email) ;?></small><br>
   <small class="threadCreateTime"><?php echo esc_html($thread_modified); ?></small>
</div>
<div class="threadMsg">
<p><?php echo stripcslashes(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a target='_blank' href=\"\\0\">\\0</a>",$thread->message)); ?></p>
<?php if(count($attachments)){?>
			<div class="threadAttachment">
				<span><?php _e('Attachment:','ydssupport'); ?></span>
				<?php 
				$attachCount=0;
				foreach ($attachments as $attachment){
					$attach=$wpdb->get_row( "select * from {$wpdb->prefix}ydsts_attachments where id=".$attachment );
					$attachCount++;
				?>
				<a class="attachment_link" title="<?php _e('Download','ydssupport'); ?>" target="_blank" href="<?php echo esc_url($attach->attachments_url); ?>" ><img width="90" src="<?php echo esc_url($attach->attachments_url); ?>" /></a>
				<?php }?>
			</div>
			<?php }?>
</div>
</div>
</div>
<div style="clear:both;"></div>
<?php } ?>

<div class="replyForm" id="gotoreply">
<form id="replyticketForm" onsubmit="replyTicket(event,this);">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $current_user->ID; ?>">
<input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticket_id; ?>">
<div class="ticket-row">
<input type="hidden" value="3" name="ticket_status" />
</div>
<div class="ticket-row">
<label><?php _e('YOUR MESSAGE','ydssupport'); ?></label>
<textarea rows="8" class="input textarea" name="textmsg" id="textmsg"></textarea>
<span class="msgerror" id="msgerror_error"></span>
</div>
<!--ticket-row-->
<?php if(get_option('ydsts_general_settings')){ $generalSettings=get_option('ydsts_general_settings'); if($generalSettings['enable_upload_attachment']==1){ ?>
<div class="ticket-row" id="multiplefAttachement">
 <div class="attachment-row">    <input name="attachment[]" id="attachfile" type="file">   <span class="dashicons dashicons-plus-alt cursorPointer" id="addissueField" onclick="addfMoreattach(event,this);"></span> </div>
</div>
 <?php }} ?>
<!--field--><div class="ticket-row">
<input type="hidden" name="action" value="responseTicket"/>
<input type="submit" value="Reply" />
</span>
</div>
<span class="wait_replyticket"><img width="22" height="22" src="<?php echo YDSTS_PLUGIN_URL; ?>/asset/images/ajax-loader.gif" /></span>
</form>
</div>
</div>
<div style="clear:both;"></div>
<?php 
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}
?>
