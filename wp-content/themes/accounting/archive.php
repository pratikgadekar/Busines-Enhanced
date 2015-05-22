<?php get_header(); 
$new_query = new WP_Query();
$month = get_the_date('m');
$year = get_the_date('Y');
$day = get_the_date('d');	 
if (is_archive()) {
    $new_query->query('paged=' . $paged . '&year=' . $year . '&monthnum=' . $month . '&day=' . $day . '&post_type=post&posts_per_page=-1');
} else {
    $new_query->query('paged=' . $paged . '&post_type=post');
}
global $counter_blog;
$counter_blog = 1;
echo '<section class="container"><div class="row"><div class="col-md-9">';
while ($new_query->have_posts()) :
    $new_query->the_post();
    get_template_part( 'content', get_post_format() );
    $counter_blog++;
endwhile;
?>  
<?php
echo "</div>"; ?>
<aside class="sidebar col-md-3">
    <ul>
        <?php dynamic_sidebar("sidebar"); ?>
    </ul>
</aside> 
</div>
</section>
<?php get_footer(); ?>