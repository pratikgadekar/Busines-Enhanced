<?php
$coming_soon = get_option('coming_soon', '0');
if(($coming_soon || $coming_soon!="0")&&!is_super_admin()) {
    get_header();
    $post_soon = get_post($coming_soon);
    echo do_shortcode($post_soon->post_content);
    get_footer();
} else {
get_header();
global $anps_page_data, $row_inner; 
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

?>

<?php if ($num_of_sidebars > 0): $row_inner = true; ?>
<section class="container">
    <div class="row">
<?php endif; ?>
        <?php
            while (have_posts()) : the_post();
                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '<section class="container"><div class="row">';
                }

                if ($left_sidebar[0] != "0" && $left_sidebar[0] != null): ?>
                    <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
                        <ul>
                            <?php dynamic_sidebar($left_sidebar[0]); wp_reset_query(); ?>
                        </ul>
                    </aside>   
                <?php endif; ?>

                <?php if($num_of_sidebars == 0 && strpos('pre' . get_the_content(), 'vc_row')): ?>
                    <?php the_content(); ?>
                <?php else: ?>
                    <div class='col-md-<?php echo 12-esc_attr($num_of_sidebars)*3; ?>'><?php the_content(); ?></div>
                <?php endif; ?>

                <?php if (isset($right_sidebar[0]) && $right_sidebar[0] != "0"): ?>
                    <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
                        <ul>
                            <?php dynamic_sidebar($right_sidebar[0]); ?>
                        </ul>
                    </aside>   
                <?php endif;

                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '</div></section>';
                }
            endwhile; // end of the loop. 
        ?>
<?php if ($num_of_sidebars > 0): ?>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); 
} ?>