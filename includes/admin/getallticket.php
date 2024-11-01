<div class="supportadminContainer" id="ticketContainer">
<?php global $wpdb; if(isset($_GET['displaytkt'])){ ?>
<p><?php _e('Ticket has been stored','ydssupport'); ?></p>
<?php } ?>
<div class="supportadminHeader">
<h2><?php _e('ALL TICKETS','ydssupport') ?></h2>
</div>
<div class="adminFilter">
<form id="filterForm">
<table>
<tr>
<td><span><?php _e('STATUS:','ydssupport') ?></span></td>
<td><select name="status">
<option value=""><?php _e('ALL','ydssupport'); ?></option>
<option value="2"><?php _e('OPEN','ydssupport'); ?></option>
<option value="3"><?php _e('PENDING','ydssupport'); ?></option>
<option value="1"><?php _e('NEW','ydssupport'); ?></option>
<option value="4"><?php _e('CLOSE','ydssupport'); ?></option>
</select></td>
<td><span>Type</span></td>
<td>
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
</td>
<td><span><?php _e('PRIORITY','ydssupport'); ?></span></td>
<td>
<div id="get_product_name">
<?php $priority_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_priority where 1"); ?>
<select name="yds_priorityid" id="yds_priorityid" class="input list">
<option value=""><?php _e('ALL','ydssupport'); ?></option>
   <?php foreach($priority_record as $priorityVal){ if($priorityVal->priority_status==1){ ?>
      <option value="<?php echo $priorityVal->priority_id; ?>"><?php echo $priorityVal->priority_name; ?></option>
   <?php }} ?>
 </select>
</div>
</td>
<td><span><?php _e('CATEGORY','ydssupport'); ?></span></td>
<td><?php $cat_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_category where 1"); ?>
                <select class="input list" name="category" id="category">
                  <option value=""><?php _e('--Select Category--','ydssupport'); ?></option>
                  <?php foreach($cat_record as $catVal){ ?>
                  <option value="<?php echo $catVal->ID; ?>"><?php echo esc_html($catVal->support_catname); ?></option>
                  <?php } ?>
                </select></td>

<td>
<div class="search-ticket">
<input type="text" name="searchTicket" placeholder="Search Ticket"/>
<input type="hidden" name="action" value="searchFilter" />
<button type="submit" value="Search" class="search-ticket-btn" ><span class="dashicons dashicons-search"></span></button>
</div>
</td>
</tr>
</table>
</form>
</div>
<div class="ticketDetail">
<?php
$sql="select a.ydstsID,a.subject,a.status,a.yds_priorityid,
		TIMESTAMPDIFF(MONTH,a.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,a.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,a.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,a.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,a.update_time,UTC_TIMESTAMP()) as date_modified_sec,
        b.display_name,c.support_catname,d.priority_name
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id ORDER BY update_time DESC LIMIT 0,15";
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
<th align="center" valign="middle"><?php _e('status','ydssupport'); ?></th>
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
<td align="center" valign="middle"><div style="width:74px; display:inline-block "><span style="cursor:pointer;" onclick="viewticketDetail(<?php echo $ticketsval->ydstsID; ?>);" class="view"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/edit.png'; ?>" alt=""/></span><span style="cursor:pointer;" onclick="deleteTicket(<?php echo $ticketsval->ydstsID; ?>)" class="delete"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/delete.png'?>"   alt=""/></span></span></div></td>
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
		FROM {$wpdb->prefix}ydsts_ticket as a INNER JOIN {$wpdb->prefix}users as b ON a.created_by=b.ID INNER JOIN {$wpdb->prefix}ydsts_category as c ON a.support_cat=c.ID INNER JOIN {$wpdb->prefix}ydsts_priority as d ON a.yds_priorityid=d.priority_id";
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
</div>
</div>



