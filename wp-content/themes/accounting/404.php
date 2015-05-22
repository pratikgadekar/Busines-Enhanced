<?php get_header(); ?>
<?php
	if(isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '0') {
		$page = get_page( $anps_page_data['error_page'] );
		echo do_shortcode(str_replace("&nbsp;", "<p><br /></p>", $page->post_content));
	}
?>
<?php get_footer(); ?>