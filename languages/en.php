<?php

$en = array(
	'tu_spam_report:entity:deleted' => 'Entity has been deleted',
	'tu_spam_report:entity:notspam' => 'Entity has had spam reports cleared',
	'tu_spam_report:error:permissions' => "You don't have permission to do that",
	'tu_spam_report:error:marked' => "Content is already marked as spam",
	'tu_spam_report:success:marked' => "Content has been marked as spam",
	'tu_spam_report:noresults' => "No spam to list",
	'tu_spam_report:mark' => 'Mark as spam',
	'tu_spam_report:notspam' => "Not Spam",
	'tu_spam_report:reportedby' => "Reported by: %s",
	'tu_spam_report:settings' => "Spam Report Settings",
	'tu_spam_report:trusted_users:flag_count' => "How many reports required to disable the content?",
	'tu_spam_report:user_spam_strtotime' => "How far back to check for spam reports for a user (eg. -1 month, -6 months, etc):",
	'tu_spam_report:user_spam_count' => "Number of reported spam objects to trigger banning a user:",
	'tu_spam_report:trusted_users:flag_count:help' => "When a piece of content reaches this number of spam reports from trusted users the content will be disabled (not be visible on the site) and sent to the admin spam moderation page.",
	'tu_spam_report:user_spam_strtotime:help' => "When a piece of content gets marked as spam, the author of that content gets a strike against them.  Here you can set how far back to look for previous strikes.  For example if you enter '-1 month' only strikes within the last month will be considered when deciding whether to auto-ban that user.  Strikes older than one month will have no effect.",
	'tu_spam_report:user_spam_count:help' => "The number of strikes that need to be against a user to auto-ban them.  This number is time-dependent with the field above.  eg. if you enter '2' here, and '-1 month' above, you are saying that if a user has 2 pieces of content marked as spam within a month they will be automatically banned",
);

add_translation('en', $en);