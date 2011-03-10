<?php
/*
Plugin Name: Ozh' Absolute Comments
Plugin URI: http://planetozh.com/blog/my-projects/absolute-comments-manager-instant-reply/
Description: Reply instantly to comments from email notifications. <strong>For WordPress 3.1+</strong>
Author: Ozh
Author URI: http://ozh.org/
Version: 4.0
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
   4.0: Update for WP 3.1, removed a ton of deprecated stuff
 */

/********* Do not edit anything. *********/

/* Note: all 'cqr' references mean 'comment quick reply', original name for the plugin */

// Add the convenient Reply link to mail notifications
function wp_ozh_cqr_email($text, $comment_id) {
	$text .= __( 'Reply' ).': '.admin_url( 'edit-comments.php?quick_reply='.$comment_id )."\r\n";
	$text .= "[ Powered by Absolute Comments * http://ozh.in/kq ]\r\n";
	return $text;
}

// All set up, now tell WP what to do
add_filter('comment_notification_text', 'wp_ozh_cqr_email', 10, 2);
if (is_admin()) {
	require_once( dirname( __FILE__ ) . '/inc/core.php' );
	add_filter( 'the_comments', 'wp_ozh_cqr_get_comment' );
	add_action( 'load-edit-comments.php', 'wp_ozh_cqr_printjscss' );
}
