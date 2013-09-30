<?php

require_once 'lib/hooks.php';

elgg_register_event_handler('init', 'system', 'tu_spam_report_init');

function tu_spam_report_init() {
	// add spam report buttons to entity menus
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tu_spam_report_entity_menu');
	// run last to create a specific menu for admin
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tu_spam_report_reported_spam_menu', 1000);
	elgg_register_plugin_hook_handler('register', 'menu:river', 'tu_spam_report_river_menu');
	
	
	if (trusted_users_is_trusted(elgg_get_logged_in_user_entity())) {
		elgg_register_action('report_spam', dirname(__FILE__) . '/actions/report_spam.php');
		elgg_register_action('reported_spam/delete', dirname(__FILE__) . '/actions/delete.php', 'admin');
		elgg_register_action('reported_spam/notspam', dirname(__FILE__) . '/actions/notspam.php', 'admin');
		elgg_register_admin_menu_item('administer', 'reported_spam', 'administer_utilities');
	}
}


/**
 * has the user already marked the entity as spam?
 */
function tu_spam_report_is_marked($object, $user) {
	if (!elgg_instanceof($object) || !elgg_instanceof($user, 'user')) {
		return false;
	}
	
	$annotations = elgg_get_annotations(array(
		'guid' => $object->guid,
		'annotation_owner_guid' => $user->guid,
		'annotation_names' => 'tu_spam_report'
	));
	
	return $annotations ? true : false;
}