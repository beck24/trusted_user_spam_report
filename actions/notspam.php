<?php

$guid = get_input('guid');

access_show_hidden_entities(true);

$entity = get_entity($guid);
$owner = $entity->getOwnerEntity();

if ($entity) {
	$entity->enable();
	$entity->deleteAnnotations('tu_spam_report');
	
	// remove last mark against the owner
	$annotations = $owner->getAnnotations('content_marked_spam', 1);
	
	if ($annotations) {
		$annotations[0]->delete();
	}
	
	$userlimit = elgg_get_plugin_setting('user_spam_count', 'trusted_user_spam_report');
	$user_strtotime = elgg_get_plugin_setting('user_spam_strtotime', 'trusted_user_spam_report');
	
	// if the user was banned for this lets unban them
	$time_lower = strtotime($user_strtotime);
	
	if ($owner->isBanned() && $time_lower && $userlimit) {
		$usercount = elgg_get_annotations(array(
			'guid' => $owner->guid,
			'annotation_names' => array('content_marked_spam'),
			'annotation_values' => array('1'),
			'annotation_created_time_lower' => $time_lower,
			'count' => true
		));
		
		if ($usercount < $userlimit) {
			$owner->unban();
		}
	}	
}

system_message(elgg_echo('tu_spam_report:entity:notspam'));
forward(REFERER);