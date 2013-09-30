<?php

$entity = $vars['entity'];
$owner = $entity->getOwnerEntity();

$title = $entity->title ? $entity->title : $entity->name;
if (!strlen($title)) {
	$title = $entity->type . ':' . $entity->getSubtype() . ':' . $entity->guid;
}

$description = $entity->description ? $entity->description : $entity->briefdescription;

$owner_link = elgg_view('output/url', array(
	'href' => $owner->getURL(),
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($entity->time_created);

$params = array(
		'entity' => $entity,
		'title' => $title,
		'metadata' => elgg_view_menu('entity', array(
				'entity' => $entity,
				'class' => 'elgg-menu-hz',
				'sort_by' => 'priority',
				'moderate_spam' => true,
			)),
		'tags' => false,
		'subtitle' => $author_text . ' ' . $date,
		'content' => elgg_get_excerpt($description, 500)
	);

$summary = elgg_view('object/elements/summary', $params);


// display who reported this
$reporters = '';
$annotations = $entity->getAnnotations('tu_spam_report', false);
foreach ($annotations as $a) {
	$a_owner = get_user($a->owner_guid);
	$reporters .= elgg_view_entity_icon($a_owner, 'small');
}

$body = $summary . '<br>' . elgg_echo('tu_spam_report:reportedby', array($reporters)) . '<br><br>';

echo elgg_view_image_block(elgg_view_entity_icon($owner, 'small'), $body);