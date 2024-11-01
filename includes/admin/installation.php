<?php
if (! defined( 'ABSPATH')){
	exit; // Exit if accessed directly
}

global $wpdb;
//Roll & Capability
if(!get_role('yds_support_ticket_system')){
	add_role('yds_support_ticket_system', 'Support Agent');
}
$role = get_role('yds_support_ticket_system' );
$role->add_cap('manage_support_ticket');
$role->add_cap('read' );
$role = get_role('administrator' );
$role->add_cap('manage_support_ticket');

//Database
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_ticket'") != $wpdb->prefix . 'ydsts_ticket'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_ticket (
	ydstsID mediumint(11) NOT NULL AUTO_INCREMENT,
    support_cat integer,
    yds_priorityid integer,
	created_by integer,
	subject TINYTEXT DEFAULT NULL,
	status integer,
	create_time datetime,
	update_time datetime,
	PRIMARY KEY (ydstsID)
	);");
}

if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_ticket_thread'") != $wpdb->prefix . 'ydsts_ticket_thread'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_ticket_thread (
	thrID mediumint(11) NOT NULL AUTO_INCREMENT,
	ticket_id integer,
	created_by integer,
	message TEXT DEFAULT NULL,
	attachment_ids TINYTEXT DEFAULT NULL,
	create_time datetime,
	PRIMARY KEY (thrID)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_attachments'") != $wpdb->prefix . 'ydsts_attachments'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_attachments (
	id integer not null auto_increment,
	filename TINYTEXT DEFAULT NULL,
	filetype TINYTEXT DEFAULT NULL,
	attachments_path TINYTEXT DEFAULT NULL,
	attachments_url TINYTEXT DEFAULT NULL,
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_category'") != $wpdb->prefix . 'ydsts_category'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_category (
	ID mediumint(11) NOT NULL AUTO_INCREMENT,
    cat_status mediumint(11) DEFAULT 0,
	support_catname TINYTEXT DEFAULT NULL,
	PRIMARY KEY (ID)
	);");
	
	$wpdb->insert($wpdb->prefix.'ydsts_category',array('support_catname'=>'Sales'));
	$wpdb->insert($wpdb->prefix.'ydsts_category',array('support_catname'=>'Support'));

}

if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_priority'") != $wpdb->prefix . 'ydsts_priority'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_priority (
	priority_id mediumint(11) NOT NULL AUTO_INCREMENT,
    priority_status mediumint(11) DEFAULT 0,
	priority_name TINYTEXT DEFAULT NULL,
	PRIMARY KEY (priority_id)
	);");
	
	$wpdb->insert($wpdb->prefix.'ydsts_priority',array('priority_name'=>'Normal'));
	$wpdb->insert($wpdb->prefix.'ydsts_priority',array('priority_name'=>'Low'));
	$wpdb->insert($wpdb->prefix.'ydsts_priority',array('priority_name'=>'Urgent'));
	$wpdb->insert($wpdb->prefix.'ydsts_priority',array('priority_name'=>'High'));

}

if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ydsts_agent_settings'") != $wpdb->prefix . 'ydsts_agent_settings'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}ydsts_agent_settings (
	id integer not null auto_increment,
	agent_id integer NULL DEFAULT NULL,
	signature TEXT DEFAULT NULL,
	PRIMARY KEY (id)
	);");
}

//default settings
if( get_option('ydsts_general_settings')===false) {
	$generalSettings=array(
		'page_id'=>0,
		'enable_guest_ticket'=>1,
		'enable_upload_attachment'=>1,
	);
	update_option('ydsts_general_settings',$generalSettings);
}
if( get_option('ydsts_email_settings')===false){
	$emailSettings=array(
			'new_ticket_created'=>1,
			'ticket_reply'=>1,
			'delete_email'=>1
	);
	update_option('ydsts_email_settings',$emailSettings);
}


?>
