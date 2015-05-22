<?php 
$coming_soon = get_option('coming_soon', '0');
if(($coming_soon || $coming_soon!="0")&&!is_super_admin()) {
    get_header();
    $post_soon = get_post($coming_soon);
    echo do_shortcode($post_soon->post_content);
    get_footer();
} else {
get_header(); 
$meta = get_post_meta(get_the_ID());
$num_of_sidebars = 0;
$left_sidebar = 0;
if (isset($meta['sbg_selected_sidebar'])) {
    $left_sidebar = $meta['sbg_selected_sidebar'];
    if($left_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}
$right_sidebar = 0;
if (isset($meta['sbg_selected_sidebar_replacement'])) {
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'];
    if($right_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}

global $row_inner;

if ($num_of_sidebars > 0) {
    $row_inner = true;
}
?>
<?php
if(get_post_type() == "post") : ?>
<section class="blog-single">
    <div class="container">
        <div class="row">
        <?php if (isset($left_sidebar[0]) && $left_sidebar[0] != "0"): ?>
            <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
            	<ul><?php dynamic_sidebar($left_sidebar[0]); ?></ul>
            </aside>   
	<?php endif; ?>
        <div class="<?php if($num_of_sidebars == 1) { echo "col-md-9"; } else if($num_of_sidebars == 2) { echo "col-md-6"; } else { echo "col-md-12"; } ?>">
<?php while(have_posts()) {
    the_post(); 
    get_template_part( 'content-single-blog', get_post_format() );
    wp_link_pages();
    comments_template();
}    
endif; ?>
        </div>
        <?php if (isset($right_sidebar[0]) && $right_sidebar[0] != "0"): ?>
            <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
            	<ul>
            		<?php dynamic_sidebar($right_sidebar[0]); ?>
            	</ul>	
            </aside>   
        <?php endif; ?>
      </div>
      </div>
</section>
<?php get_footer(); 
} ?>