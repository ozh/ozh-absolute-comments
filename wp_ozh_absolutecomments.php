<?php
/*
Plugin Name: Ozh' Absolute Comments
Plugin URI: http://planetozh.com/blog/my-projects/absolute-comments-manager-instant-reply/
Description: Reply instantly to comments, either from the email notification, or the usual <a href="edit-comments.php">Comments</a> page, without loading the post first. <strong>For WordPress 2.8+</strong>
Author: Ozh
Author URI: http://planetozh.com/
Version: 3.0
*/

/* Release history:
 * 1.0 : Initial release
 * 2.0 : Update for WordPress 2.5 only. Mostly everything reworked.
 * 2.1 : Improved error handling & reporting to help identify conflicting plugins
         Added an external config file to prevent option overwritting on plugin update
   2.2 : Improved: adding JS & CSS only on relevant pages
         Fixed: now correct "View all" links for pages and attachments
         Added: admin panel to manage options
		 Removed: external config file.
   2.2.1: Fixed: Strip slashes on comment prefill
   2.2.2: Fixed compat with WP 2.6
   2.2.2.1: More translations
   3.0: Update for WP 2.8
 */

/********* Do not edit anything. *********/

/* Note: all 'cqr' references mean 'comment quick reply', original name for the plugin */

global $wp_ozh_cqr;

// Include one of our files
function wp_ozh_cqr_include($inc) {
	include(WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)).'/includes/'.basename($inc));
}

// Add the convenient Reply link to mail notifications
function wp_ozh_cqr_email($text, $comment_id) {
	global $wp_ozh_cqr;
	wp_ozh_cqr_include('core.php');
	$text .= wp_ozh_cqr__('Reply').': '.get_bloginfo('wpurl').'/wp-admin/edit-comments.php?quick_reply='.$comment_id."\r\n";
	if ($wp_ozh_cqr['mail_promote'])
		$text .= '[ '.wp_ozh_cqr__('Powered by')." Absolute Comments * http://ozh.in/kq ]\r\n";
	return $text;
}

// All set up, now tell WP what to do
add_filter('comment_notification_text', 'wp_ozh_cqr_email', 10, 2);
if (is_admin()) {
	wp_ozh_cqr_include('core.php');
	add_action('load-edit-comments.php', 'wp_ozh_cqr_take_over');
	add_filter('ozh_adminmenu_icon_absolute-comments', 'wp_ozh_cqr_customicon');
	add_action('admin_menu', 'wp_ozh_cqr_add_page');
	add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'wp_ozh_cqr_plugin_actions', -10); // Add Config link to plugin list
}
?>