<div class="ticketDetail categoriessection">
<?php
global $wpdb;
$pr_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_priority where 1");
$inc=1;

 ?>

<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<th><?php _e('Priority Name','ydssupport'); ?></th>
<th><?php _e('Ordering','ydssupport'); ?></th>
<th><?php _e('Status','ydssupport'); ?></th>
<th colspan="2"><?php _e('Action','ydssupport'); ?></th>
</tr>
<?php foreach($pr_record as $prVal){ ?>
<tr id="showPriorityrow<?php echo $prVal->priority_id; ?>">
<td><?php echo ucfirst($prVal->priority_name); ?></td>
<td><?php echo $inc++; ?><a href="#"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/downarrow.png'; ?>" alt=""/></a></td>
<td><div onclick="priorityStatus(<?php echo $prVal->priority_id.','.$prVal->priority_status; ?>);" class="status-cnt">
<?php if($prVal->priority_status==1){ ?>
<span class="dashicons dashicons-yes"></span>
<?php }else {?>
<span class="dashicons dashicons-no-alt"></span>
<?php } ?>
</div></td>
 
<td>
<div class="action-cnt">
<span onclick="editPriority(<?php echo $prVal->priority_id; ?>)"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/edit.png'; ?>" alt=""/></span>
<span onclick="deletPriority(<?php echo $prVal->priority_id; ?>)"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/delete.png'?>"   alt=""/></span></div>
</td>
</tr>

<tr style="display:none;" id="editPriorityrow<?php echo $prVal->priority_id; ?>">
<td colspan="5">
<form  class="editcatForm" onsubmit="updatePriority(event,this);">
<input type="text" name="priorityValue" value="<?php echo $prVal->priority_name; ?>" />
<input type="hidden" name="priorityId" value="<?php echo $prVal->priority_id; ?>" />
<input type="hidden" name="action" value="updatePriorityval" />
<input type="submit" value="Save" />
</form></td>
</tr>

<?php } ?>
</table>
</div>
