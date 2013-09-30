<?php

/* Trusted user settings */
$title = elgg_echo('tu_spam_report:settings');


$body .= '<div>';
$body .= '<label>' . elgg_echo('tu_spam_report:trusted_users:flag_count') . ':</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[trusted_users_flag_count]',
	'value' => $vars['entity']->trusted_users_flag_count,
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('tu_spam_report:trusted_users:flag_count:help'),
	'class' => 'elgg-subtext'
));
$body .= '</div>';


$body .= '<div>';
$body .= '<label>' . elgg_echo('tu_spam_report:user_spam_strtotime') . ':</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[user_spam_strtotime]',
	'value' => $vars['entity']->user_spam_strtotime,
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('tu_spam_report:user_spam_strtotime:help'),
	'class' => 'elgg-subtext'
));
$body .= '</div>';


$body .= '<div>';
$body .= '<label>' . elgg_echo('tu_spam_report:user_spam_count') . ':</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[user_spam_count]',
	'value' => $vars['entity']->user_spam_count,
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('tu_spam_report:user_spam_count:help'),
	'class' => 'elgg-subtext'
));
$body .= '</div>';

echo elgg_view_module('main', $title, $body);
