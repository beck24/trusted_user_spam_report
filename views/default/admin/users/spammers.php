<?php

access_show_hidden_entities(true);

$offset = get_input('offset', 0);
$limit = get_input('limit', 10);

$dbprefix = elgg_get_config('dbprefix');
$options = array(
	'type' => 'user',
	'metadata_names' => array('disable_reason'),
	'metadata_values' => array('content_marked_spam'),
	'joins' => array("JOIN {$dbprefix}users_entity ue ON ue.guid = e.guid"),
	'order_by' => 'ue.name ASC',
	'limit' => $limit,
	'offset' => $offset,
	'count' => true
);

$count = elgg_get_entities_from_metadata($options);

if ($count) {
	unset($options['count']);
	
	elgg_push_context('reported_spammers');
	echo elgg_list_entities_from_metadata($options);
	elgg_pop_context();

}
else {
	echo elgg_echo('tu_spam_report:spammers:noresults');
}