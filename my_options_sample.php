<?php
/*
Part of Plugin: Absolute Comments
*/

/******************************************************************************
 * Copy my_options_sample.php to my_options.php then edit to suit your needs. *
 ******************************************************************************/

$wp_ozh_cqr['editor_rows'] = 5;
	// integer: number of lines of the Editor for comment replying
	// false: leave as WordPress default (editable through Options / Writing page)
	// Default value: 5

$wp_ozh_cqr['show_icon'] = true;
	// boolean: show little icon next to "Reply" links
	// Default value: true

$wp_ozh_cqr['prefill_reply'] = '%%name%% &amp;raquo; ';
	// string: text (HTML) pattern to prefill comment. Set to empty string to disable this feature.
	// Uses the following tokens:
	// %%link%% : comment permalink
	// %%name%% : commenter's name
	// Examples :
	//  	'%%name%% &amp;raquo; ' => 'Joe &raquo; '
	//		'@<a href="%%link%%">%%name%%</a>: ' => '@<a href="#comment-1234">Joe</a>: '
	//		'@%%name%%: ' => '@Joe: '
	// Default value: '@%%name%%: '
	
$wp_ozh_cqr['show_threaded'] = false;
	// boolean: Add option to reply in threaded	mode (needs a "threaded comments" plugin & theme)
	// Default value: false

$wp_ozh_cqr['show_allcomments'] = true;
	// boolean: Show link to display all comments for a post
	// Default value: true

$wp_ozh_cqr['mail_promote'] = true;
	// boolean: Add a promoting link to the plugin in mail footers. Might help new people
	// find about this great plugin if you usually reply by email to comments !
	// Default value: true
	
	
?>