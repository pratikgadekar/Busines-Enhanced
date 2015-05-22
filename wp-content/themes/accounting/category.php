<?php get_header(); 
$new_query = new WP_Query();
$cat = "Posts";
if (single_cat_title('', false) != "") {
    $cat = single_cat_title('', false);
    $site_link = home_url();
}
$month = get_the_date('m');
$year = get_the_date('Y');
$day = get_the_date('d');	 
$new_query->query('cat=' . get_cat_id(single_cat_title("", false)) . '&paged=' . $paged . '&post_type=post&posts_per_page=-1');
global $counter_blog;
$counter_blog = 1;
echo '<section class="container"><div class="row"><div class="col-md-9">';
while ($new_query->have_posts()) :
    $new_query->the_post();
    get_template_part( 'content', get_post_format() );
    $counter_blog++;
endwhile; ?>
</div>
<aside class="sidebar col-md-3">
    <ul>
        <?php dynamic_sidebar("sidebar"); ?>
    </ul>
</aside> 
<?php echo "</div></section>";
get_footer(); ?>