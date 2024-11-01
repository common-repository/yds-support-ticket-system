<div class="supportadminContainer">
<div class="supportadminHeader">
<h2><?php _e('Categories','ydssupport'); ?></h2>
</div>
<div class="categoriesformSection">
<form id="createsupportCategories" class="ydsdynamicForm">
<table width="100%" id="catfieldContainer">
<tr>
<td><span class="dashicons dashicons-plus-alt cursorPointer" id="addcatField"></span></td>
<td><?php _e('Add Category','ydssupport'); ?></td>
<td><input type="text" rel-id='1' class="yds_cat" size="20" name="fieldValue[yds_cat1]" value="" placeholder="<?php _e('Input Value','ydssupport'); ?>"/>
<input type="hidden" name="action" value="supportCat">
</td>
<td><input type="submit" name="save" value="<?php _e('PUBLISH','ydssupport'); ?>"></td>
</tr>
</table>
</form>
</div>
<div class="categoriesList" id="displayadminCat">
</div>
</div>
