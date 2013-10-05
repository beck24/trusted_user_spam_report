<?php

$guid = get_input('guid');

access_show_hidden_entities(true);

$entity = get_entity($guid);

if ($entity) {
	$entity->enable();
}

system_message(elgg_echo('tu_spam_report:user:notspammer'));
forward(REFERER);