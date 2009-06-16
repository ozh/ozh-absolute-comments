<?php
/*
Part of Plugin: Absolute Comments
*/
global $wp_ozh_cqr;
if (!function_exists('wp_ozh_cqr_take_over')) die('You cannot do this');

// Link icons
if ( $wp_ozh_cqr['show_icon'] ) {
	$cqr_plugindir = WP_PLUGIN_URL.'/'.dirname(dirname(plugin_basename(__FILE__)));
	echo <<<CSS
	<style type="text/css" media="screen">
	span.reply a{
		background:transparent url($cqr_plugindir/images/reply.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
 	span.edit a, span.quickedit a  {
		background:transparent url($cqr_plugindir/images/edit.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
 	span.spam a {
		background:transparent url($cqr_plugindir/images/spam.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
 	span.unapprove a {
		background:transparent url($cqr_plugindir/images/unapprove.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
 	span.approve a {
		background:transparent url($cqr_plugindir/images/approve.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
 	span.delete a {
		background:transparent url($cqr_plugindir/images/delete.gif) 4px -2px no-repeat;
		padding-left:22px;
	}
	</style>
CSS;
}


// Prefilling comments
if ($wp_ozh_cqr['prefill_reply']) {

	$cqr_reply = stripslashes(html_entity_decode($wp_ozh_cqr['prefill_reply']));

	echo <<<JS
	<script type="text/javascript">
		
	jQuery(document).ready(function() {

		jQuery('div.row-actions span.reply a').click(function(){
			// wait half a second to be sure the reply box has displayed
			jQuery(this).animate({'opacity': 1}, 500, function() {
				// find author name
				var nick = jQuery(this).parent().parent().parent().parent().find('td.author strong').text();
				// find comment id
				var id = jQuery(this).parent().parent().find('a[href*=editcomment]').attr('href').replace(/.*&?c=([^&]*).*/,function($0,$1){return $1;});
				// make reply text
				var replytext = '$cqr_reply';
				replytext = replytext.replace('%%link%%', '#comment-'+id);
				replytext = replytext.replace('%%name%%', jQuery.trim(nick));
				jQuery('#replycontent').val(replytext);		
			});
		});
		
	});
	
	</script>

JS;

}

