<?php
global $wpdb;
global $current_user;
get_currentuserinfo();
$sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id ";
$where="WHERE a.created_by=".$current_user->ID.' ';
$sql.=$where;
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
 <h2><?php _e('View Tickets','ydssupport'); ?></h2>
<table width="100" border="0" cellspacing="0" cellpadding="0" class="ydstickets-table">
            <tr>
                <th align="left" valign="middle"><?php _e('Ticket ID','ydssupport'); ?></th>
                <th align="left" valign="middle"><?php _e('Status','ydssupport'); ?></th>
                <th align="left" valign="middle"><?php _e('Created on','ydssupport'); ?></th>
                <th align="left" valign="middle"><?php _e('Summary','ydssupport'); ?></th>
              </tr>
              <?php
			  foreach($tickets as $ticketsval){
	         $modified='';
		     if ($ticketsval->date_modified_month) $modified=$ticketsval->date_modified_month.' months ago';
		     else if ($ticketsval->date_modified_day) $modified=$ticketsval->date_modified_day.' days ago';
		     else if ($ticketsval->date_modified_hour) $modified=$ticketsval->date_modified_hour.' hours ago';
		     else if ($ticketsval->date_modified_min) $modified=$ticketsval->date_modified_min.' minutes ago';
		     else $modified=$ticketsval->date_modified_sec.' seconds ago';	
			  ?>
            <tr onclick="viewticketonFront(<?php echo $ticketsval->ydstsID; ?>);">
                <td><div class="tcid">#<?php echo $ticketsval->ydstsID; ?></div></td>
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
                <td align="center" valign="middle"><div class="date"><?php echo esc_html($modified,'ydssupport'); ?></div></td>
                <td><div class="summary"><?php echo stripcslashes($ticketsval->subject); ?></div></td>
              </tr>
              <?php } ?>
            
          </table>
          <?php } ?>
          <?php
$page_sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id WHERE a.created_by=".$current_user->ID."";
		
$page_result=$wpdb->get_results($page_sql);
$total_pages=ceil(count($page_result)/15);
if($total_pages>1)
{
?>
          <ul class="yds-pagination">
            <li><a href="#">&laquo;</a></li>
            <?php for($i=1;$i<=$total_pages;$i++){ ?>
            <a href="javascript:userticketPagination(<?php echo $i; ?>);"  class="page-numbers current"><?php echo $i; ?></a>
            <?php } ?>
            <li><a href="#">&raquo;</a></li>
          </ul>
     <?php } ?>