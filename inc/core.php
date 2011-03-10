<?php

function wp_ozh_cqr_get_comment( $comments ) {

	if( isset( $_GET['quick_reply'] ) ) {
		$comment = get_comment( absint( $_GET['quick_reply'] ) );
		if( $comment === NULL ) {
			$comments = array();
		} else {
			$comments = array( $comment );
			add_action( 'admin_footer', 'wp_ozh_cqr_popup_reply' );
		}
	}
	
	return $comments;
}

function wp_ozh_cqr_popup_reply(){
	echo <<<FFSWTF
	<style type="text/css">
	p.search-box, div.tablenav, #comments-form tfoot, #cb input, th.check-column input {display:none;}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#the-comment-list div.row-actions span.reply a').click();
	});
	</script>

FFSWTF;
}

function wp_ozh_cqr_printjscss(){
	add_action( 'admin_footer', 'wp_ozh_cqr_printjscss_damnit' );
}

function wp_ozh_cqr_printjscss_damnit() {

	$replychar = apply_filters( 'ozh_absolutecomments_replychar', 'String.fromCharCode(187)' );
	$pluginurl = plugins_url('/images/', dirname(__FILE__) );

	echo <<<OMGLOL
	<style type="text/css">
	div.row-actions span a{padding-left:22px; background: transparent 4px -1px no-repeat;}
	div.row-actions span.reply a{background-image:url('$pluginurl/reply.gif');}
	div.row-actions span.unapprove a{background-image:url('$pluginurl/unapprove.gif');}
	div.row-actions span.approve a{background-image:url('$pluginurl/approve.gif');}
	div.row-actions span.edit a{background-image:url('$pluginurl/edit.gif');}
	div.row-actions span.quickedit a{background-image:url('$pluginurl/edit.gif');}
	div.row-actions span.trash a{background-image:url('$pluginurl/delete.gif');}
	div.row-actions span.spam a{background-image:url('$pluginurl/spam.gif');}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('div.row-actions span.reply a').click(function(){
			// wait half a second to be sure the reply box has displayed
			jQuery(this).animate({'opacity': 1}, 500, function() {
				// find author name
				var nick = jQuery(this).parent().parent().parent().parent().find('td.author strong').text();
				// make reply text
				jQuery('#replycontent').val( nick + ' ' + $replychar + ' ');
			});
		});
	});
	</script>
OMGLOL;
}