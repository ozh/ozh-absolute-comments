<?php
/*
Part of Plugin: Absolute Comments
*/

// Load options and/or set default values
function wp_ozh_cqr_options() {
	global $wp_ozh_cqr;
	
	$wp_ozh_cqr = get_option('ozh_absolutecomments');
	
	$defaults = array(
		'editor_rows' => 5,
		'show_icon' => true,
		'prefill_reply' => '@%%name%%: ',
		'mail_promote' => true,
	);
	
	foreach($defaults as $k=>$v) {
		if (!isset($wp_ozh_cqr[$k]))
			$wp_ozh_cqr[$k] = $defaults[$k];
	}
	
}


function wp_ozh_cqr_request_handler() {
	// Only people who can access the admin area are allowed here, of course
	if (!current_user_can('edit_posts')) return false;

	global $wp_ozh_cqr;

	// Include personal prefs or load default
	wp_ozh_cqr_options();

	//$wp_ozh_cqr['path'] = dirname(plugin_basename(__FILE__));
	
	// Only on 'edit-comments?quick_reply=XX' we need to hijack the admin page
	if ( strpos($_SERVER['QUERY_STRING'], 'quick_reply=') === false )
		return false;
	
	// Still with us ? Take over the admin page. Hands up, this is a robbery!
	$title = __('Reply to Comments');
	$parent_file = 'edit-comments.php';
	
	require_once(ABSPATH.'/wp-admin/admin.php');
	require_once(ABSPATH.'/wp-admin/admin-header.php');

	if (isset($_GET['quick_reply'])) $cqr = intval($_GET['quick_reply']);
	
	// Case: ?quick_reply=XXX
	if ( ! $comment = get_comment(intval($cqr)) ) {
		echo '<div id="message" class="updated fade"><p>'.wp_ozh_cqr__('Oops, no comment with this ID.').sprintf(' <a href="%s">'.wp_ozh_cqr__('Go back').'</a>!', 'javascript:history.go(-1)').'</p></div>';
		return true;
	}
	
	$wp_ozh_cqr['comment'] = $comment;

	echo '<div class="wrap">
	<h2>'.wp_ozh_cqr__('Your Reply').'</h2>';
	wp_ozh_cqr_include('_view_comment.php');
	echo "</div>\n\n";
	
	return true;
}

function wp_ozh_cqr_add_page() {
	$page = add_options_page('Absolute Comments Options', 'Absolute Comments', 'manage_options', 'absolute-comments', 'wp_ozh_cqr_adminpage');
}

function wp_ozh_cqr_adminpage() {
	wp_ozh_cqr_options();
	wp_ozh_cqr_include('_admin.php');
	wp_ozh_cqr_adminpage_print();
}

// Hijack admin page if needed
function wp_ozh_cqr_take_over() {
	add_action('admin_footer','wp_ozh_cqr_print_js');
	wp_enqueue_script('admin-comments');
	if (wp_ozh_cqr_request_handler()) {
		include(ABSPATH.'/wp-admin/admin-footer.php');
		die();
	}
}

// Translation wrapper. If ($escape) replace all quotes '" with \' for use inside Javascript strings
function wp_ozh_cqr__($str, $escape=false) {
	if (!defined('WPLANG')) return $str;
	// Load translation file if needed, return translated if available
	global $l10n;
	if (!isset($l10n['absolutecomments']))
		load_plugin_textdomain('absolutecomments', 'wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/translations');
	$string = __($str, 'absolutecomments');
	if ($escape) $string=str_replace(array("'",'"'),array("\'","\'"),$string);
	return $string;
}

// Include the javascript
function wp_ozh_cqr_print_js() {
	global $wp_ozh_cqr, $user_ID;
	wp_ozh_cqr_include('_print_js.php');
}

// Custom icon
function wp_ozh_cqr_customicon() {
	return WP_PLUGIN_URL.'/'.plugin_basename(dirname(dirname(__FILE__))).'/images/ozh.png';
}

// Add the 'Settings' link to the plugin page
function wp_ozh_cqr_plugin_actions($links) {
	$links[] = "<a href='options-general.php?page=absolute-comments'><b>Settings</b></a>";
	return $links;
}