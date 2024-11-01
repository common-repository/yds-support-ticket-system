<?php
$current_user = wp_get_current_user();
if ($current_user->has_cap('manage_options')) { 
	$yds_supportpage_title = 'Yds Support Ticket System';
    $yds_supportpage_content = '[yds_support_ticket_system]';
    $page_check = get_page_by_title($yds_supportpage_title);
    $new_page = array(
        'post_type' => 'page',
        'post_title' => $yds_supportpage_title,
        'post_content' => $yds_supportpage_content,
        'post_status' => 'publish',
        'post_author' => $current_user->data->ID,

    );

    if(!isset($page_check->ID)){
        $new_page_id = wp_insert_post($new_page);
        update_option('yds_support_page', $new_page);
    }
}
?>