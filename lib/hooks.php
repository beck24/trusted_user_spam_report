<?php

/**
 * Add spam links to entity menus
 */
function tu_spam_report_entity_menu($hook, $type, $return, $params) {
	$user = elgg_get_logged_in_user_entity();
	if (!trusted_users_is_trusted($user)) {
		return $return;
	}
	
	// only objects should be markable with the entity menu
	if (!elgg_instanceof($params['entity'], 'object')) {
		return $return;
	}
	
	// only allow them to mark it once
	if (tu_spam_report_is_marked($params['entity'], $user)) {
		return $return;
	}
	
	// we're a trusted user, give us a spam link
	$text = elgg_view_icon('attention');
	$href = elgg_add_action_tokens_to_url('action/report_spam?guid=' . $params['entity']->guid);
	$item = new ElggMenuItem('report_spam', $text, $href);
	$item->setTooltip(elgg_echo('tu_spam_report:mark'));
	
	$return[] = $item;
	
	return $return;
}



function tu_spam_report_reported_spam_menu($hook, $type, $return, $params) {
	if (!elgg_is_admin_logged_in() || !$params['moderate_spam']) {
		return $return;
	}
	
	// completely replace the menu
	$return = array();
	
	// delete (requires new action due to it being deactivated)
	$href = elgg_add_action_tokens_to_url('action/reported_spam/delete?guid=' . $params['entity']->guid);
	$delete = new ElggMenuItem('delete', elgg_view_icon('delete'), $href);
	$delete->setLinkClass('elgg-requires-confirmation');
	
	// unspam - will unmark this as spam and reactivate it
	$href = elgg_add_action_tokens_to_url('action/reported_spam/notspam?guid=' . $params['entity']->guid);
	$unspam = new ElggMenuItem('unspam', elgg_echo('tu_spam_report:notspam'), $href);
	$unspam->setLinkClass('elgg-requires-confirmation');
	
	$return[] = $unspam;
	$return[] = $delete;
	
	return $return;
}


function tu_spam_report_river_menu($hook, $type, $return, $params) {
	if ($params['item']->type == 'object' && elgg_is_logged_in() && !$params['item']->annotation_id) {
		$user = elgg_get_logged_in_user_entity();
		$object = $params['item']->getObjectEntity();
		
		if (trusted_users_is_trusted($user) && !tu_spam_report_is_marked($object, $user)) {
			// we're a trusted user, give us a spam link
			$text = elgg_view_icon('attention');
			$href = elgg_add_action_tokens_to_url('action/report_spam?guid=' . $object->guid);
			$item = new ElggMenuItem('report_spam', $text, $href);
			$item->setTooltip(elgg_echo('tu_spam_report:mark'));
	
			$return[] = $item;
		}
	}
	
	return $return;
}


/**
 * add 'not spammer' and 'delete' links to entity menuy of listed spammers
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function tu_spam_report_spammer_menu($hook, $type, $return, $params) {
	if (!elgg_instanceof($params['entity'], 'user') || elgg_get_context() != 'reported_spammers') {
		return $return;
	}
	
	// delete (requires new action due to it being deactivated)
	$href = elgg_add_action_tokens_to_url('action/reported_spam/delete?guid=' . $params['entity']->guid);
	$delete = new ElggMenuItem('delete', elgg_view_icon('delete'), $href);
	$delete->setLinkClass('elgg-requires-confirmation');
	
	// unspam - will unmark this as spam and reactivate it
	$href = elgg_add_action_tokens_to_url('action/reported_spam/notspammer?guid=' . $params['entity']->guid);
	$unspam = new ElggMenuItem('unspam', elgg_echo('tu_spam_report:notspammer'), $href);
	$unspam->setLinkClass('elgg-requires-confirmation');
	
	$metadata = elgg_get_metadata(array('guid' => $params['entity']->guid, 'metadata_name' => 'disable_reason', 'metadata_value' => 'content_marked_spam', 'limit' => false));
	$href = false;
	$reported = new ElggMenuItem('reported', elgg_echo('tu_spam_report:reported', array(date('m/d/Y', $metadata[0]->time_created))), $href);
	
	$return[] = $reported;
	$return[] = $unspam;
	$return[] = $delete;
	
	return $return;
}