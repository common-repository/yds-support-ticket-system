<?php
global $wpdb;
$sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id ";
$flagUseWhere=false;
$where=" WHERE ";
if(isset($_POST['status']) && $_POST['status']!=''){
	$flagUseWhere=true;
	$where.="a.status='".$_POST['status']."' ";
}
if(isset($_POST['user_id']) && $_POST['user_id']!=''){
	$where.=($flagUseWhere)?'AND ':'';
	$flagUseWhere=true;
	$where.="a.created_by='".$_POST['user_id']."' ";
}
if(isset($_POST['yds_priorityid']) && $_POST['yds_priorityid']!=''){
	$where.=($flagUseWhere)?'AND ':'';
	$flagUseWhere=true;
	$where.="a.yds_priorityid='".$_POST['yds_priorityid']."' ";
}
if(isset($_POST['category']) && $_POST['category']!=''){
	$where.=($flagUseWhere)?'AND ':'';
	$flagUseWhere=true;
	$where.="a.support_cat='".$_POST['category']."' ";
}
if(isset($_POST['searchTicket']) && $_POST['searchTicket']!=''){
	$where.=($flagUseWhere)?'AND ':'';
	$flagUseWhere=true;
	$where.="a.subject LIKE '%".$_POST['searchTicket']."%'";
}

$sql.=($flagUseWhere)?$where:'';
$sql.=" ORDER BY a.update_time DESC";
if(isset($_POST['page_number']) && $_POST['page_number']!='')
{
$limit_start=($_POST['page_number']-1)*15;
$sql.=" LIMIT ".$limit_start.", 15";
}else 
{
 
  $sql.=" LIMIT 0, 15";	
}
$tickets=$wpdb->get_results($sql);
if(count($tickets)>0)
{
        
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order-table">
<tr>
<th align="center" valign="middle"><?php _e('Ticket #','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('PRIORITY','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('Category','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('Subject','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('User','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('Time','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('Action','ydssupport'); ?></th>
<th align="center" valign="middle"><?php _e('Status','ydssupport'); ?></th>
</tr>
<?php foreach($tickets as $ticketsval){
	
	    $modified='';
		if ($ticketsval->date_modified_month) $modified=$ticketsval->date_modified_month.' months ago';
		else if ($ticketsval->date_modified_day) $modified=$ticketsval->date_modified_day.' days ago';
		else if ($ticketsval->date_modified_hour) $modified=$ticketsval->date_modified_hour.' hours ago';
		else if ($ticketsval->date_modified_min) $modified=$ticketsval->date_modified_min.' minutes ago';
		else $modified=$ticketsval->date_modified_sec.' seconds ago';	
	
	 ?>
<tr>
<td align="center" valign="middle">#<?php echo $ticketsval->ydstsID; ?></td>
<td align="center" valign="middle"><?php echo ucfirst($ticketsval->priority_name); ?></td>
<td align="center" valign="middle"><?php echo ucfirst($ticketsval->support_catname); ?></td>
<td align="center" valign="middle"><?php echo stripcslashes($ticketsval->subject); ?></td>
<td align="center" valign="middle"><?php echo ucfirst($ticketsval->display_name); ?></td>
<td align="center" valign="middle"><?php echo $modified; ?></td>
<td align="center" valign="middle"><div style="width:74px;"><span style="cursor:pointer;" onclick="viewticketDetail(<?php echo $ticketsval->ydstsID; ?>);" class="view"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/edit.png'; ?>" alt=""/></span><span style="cursor:pointer;" onclick="deleteTicket(<?php echo $ticketsval->ydstsID; ?>)" class="delete"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/delete.png'?>"   alt=""/></span></span></div></td>
<td align="center" valign="middle">
<?php if($ticketsval->status==1){ ?>
<div class="status color1"><?php _e('New','ydssupport'); ?></div>
<?php } if($ticketsval->status==2){ ?>
<div class="status color2"><?php _e('Waiting Customer Reply','ydssupport'); ?></div>
<?php } if($ticketsval->status==3){ ?>
<div class="status color3"><?php _e('Waiting Your Reply','ydssupport'); ?></div>
<?php } if($ticketsval->status==4){ ?>
<div class="status color4"><?php _e('Closed','ydssupport'); ?></div>
<?php } ?>
</td>
</tr>
<?php } ?>
</table>
<?php } else { echo 'Not found'; }?>
<?php
$page_sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id ";
$filterWhere=false;
$where_fpage=" WHERE ";
if(isset($_POST['status']) && $_POST['status']!=''){
	$filterWhere=true;
	$where_fpage.="a.status='".$_POST['status']."' ";
}
if(isset($_POST['user_id']) && $_POST['user_id']!=''){
	$where_fpage.=($filterWhere)?'AND ':'';
	$filterWhere=true;
	$where_fpage.="a.created_by='".$_POST['user_id']."' ";
}
if(isset($_POST['yds_priorityid']) && $_POST['yds_priorityid']!=''){
	$where_fpage.=($filterWhere)?'AND ':'';
	$filterWhere=true;
	$where_fpage.="a.yds_priorityid='".$_POST['yds_priorityid']."' ";
}
if(isset($_POST['category']) && $_POST['category']!=''){
	$where_fpage.=($filterWhere)?'AND ':'';
	$filterWhere=true;
	$where_fpage.="a.support_cat='".$_POST['category']."' ";
}
if(isset($_POST['searchTicket']) && $_POST['searchTicket']!=''){
	$where_fpage.=($filterWhere)?'AND ':'';
	$filterWhere=true;
	$where_fpage.="a.subject LIKE '%".$_POST['searchTicket']."%'";
}

$page_sql.=($filterWhere)?$where_fpage:'';
$page_sql.=" ORDER BY a.update_time DESC";
$page_result=$wpdb->get_results($page_sql);
$total_pages=ceil(count($page_result)/15);
if($total_pages>1)
{
?>

<div  class="pagination">
<a href="#" class="page-numbers"> < </a>
<?php for($i=1;$i<=$total_pages;$i++){ ?>
<a href="javascript:ticketPagination(<?php echo $i; ?>);"  class="page-numbers current"><?php echo $i; ?></a>
<?php } ?>
<a href="#" class="page-numbers"> > </a>
</div><!--pagination-->
<?php } ?>
