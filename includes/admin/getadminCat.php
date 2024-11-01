<div class="ticketDetail categoriessection">
<?php
global $wpdb;
$cat_record=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}ydsts_category where 1");
$inc=1;

 ?>

<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<th><?php _e('Category Name','ydssupport'); ?></th>
<th><?php _e('Ordering','ydssupport'); ?></th>
<th><?php _e('Status','ydssupport'); ?></th>
<th colspan="2"><?php _e('Action','ydssupport'); ?></th>
</tr>
<?php foreach($cat_record as $catVal){ ?>
<tr id="showCatrow<?php echo $catVal->ID; ?>">
<td><?php echo ucfirst($catVal->support_catname); ?></td>
<td><?php echo $inc++; ?><a href="#"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/downarrow.png'; ?>" alt=""/></a></td>
<td><div onclick="categoryStatus(<?php echo $catVal->ID.','.$catVal->cat_status; ?>);" class="status-cnt">
<?php if($catVal->cat_status==1){ ?>
<span class="dashicons dashicons-yes"></span>
<?php }else {?>
<span class="dashicons dashicons-no-alt"></span>
<?php } ?>
</div></td>
 
<td>
<div class="action-cnt">
<span onclick="editCat(<?php echo $catVal->ID; ?>)"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/edit.png'; ?>" alt=""/></span>
<span onclick="deletCat(<?php echo $catVal->ID; ?>)"><img src="<?php echo YDSTS_PLUGIN_URL.'asset/images/delete.png'?>"   alt=""/></span></div>
</td>
</tr>

<tr style="display:none;" id="editCatrow<?php echo $catVal->ID; ?>">
<td colspan="5">
<form  class="editcatForm" onsubmit="editCategory(event,this);">
<input type="text" name="editCatvalue" value="<?php echo $catVal->support_catname; ?>" />
<input type="hidden" name="editCatid" value="<?php echo $catVal->ID; ?>" />
<input type="hidden" name="action" value="saveCatvalue" />
<input type="submit" value="Save" />
</form></td>
</tr>

<?php } ?>
</table>
</div>
