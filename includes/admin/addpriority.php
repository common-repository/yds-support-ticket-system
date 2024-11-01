<div class="supportadminContainer">
<div class="supportadminHeader">
<h2><?php _e('Priority','ydssupport'); ?></h2>
</div>
<div class="categoriesformSection">
<form id="addPriorityForm" class="ydsdynamicForm">
<table width="100%" id="priorityfieldContainer">
<tr>
<td><span class="dashicons dashicons-plus-alt cursorPointer" id="addprField"></span></td>
<td><?php _e('Add Priority','ydssupport'); ?></td>
<td><input type="text" class="ydsPriority" size="20" name="fieldValue[addprField1]" value="" placeholder="<?php _e('Priority Name','ydssupport'); ?>"/>
<input type="hidden" name="action" value="addPriority">
</td>
<td><input type="submit" name="save" value="<?php _e('PUBLISH','ydssupport'); ?>"></td>
</tr>
</table>
</form>
</div>
<div class="priorityList" id="priorityList">
</div>
</div>
