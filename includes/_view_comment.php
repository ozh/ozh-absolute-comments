<?php
/*
Part of Plugin: Absolute Comments
*/

global $wp_ozh_cqr;
$comment = $wp_ozh_cqr['comment'];
$comment_id = $comment->comment_ID;
$comment_post_id = $comment->comment_post_ID;

//var_dump($comment);

if (!function_exists('wp_ozh_cqr_take_over')) die('You cannot do this.');

?>
<table class="widefat comments fixed" cellspacing="0">
<thead>
	<tr>
<?php print_column_headers('edit-comments'); ?>
	</tr>
</thead>

<tbody id="the-comment-list" class="list:comment">
<?php
		_wp_comment_row( $comment_id, 'detail', '', true);
?>
</tbody>
</table>
<div id="ajax-response"></div>
<?php
wp_comment_reply('-1', true, 'detail');



echo <<<HTML
	<style type="text/css">
		th.check-column input {display:none}
		div.row-actions {visibility:visible}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		// Slightly delay to allow the other document.ready to fire first
		jQuery('div.row-actions span.reply a').animate({'opacity':'1'}, 100, function(){
			jQuery(this).click();
		});
	});
	</script>
HTML;


?>