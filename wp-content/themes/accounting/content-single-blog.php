<?php
/* number of sidebars */
$meta = get_post_meta(get_queried_object_id()); 
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
if($num_of_sidebars=="0") {
    $image_class = "blog-full";
} else {
    $image_class = "large";
} 
/* get blog categories */ 
$post_categories = wp_get_post_categories(get_the_ID());
?>
<?php if(anps_header_media_single(get_the_ID())!="" && $num_of_sidebars>0) : ?>
<article class="post style-2">
    <header>
        <?php echo anps_header_media_single(get_the_ID(), 'blog-full'); ?>   

        <div class="post-meta">
            <ul>               
                <li><i class='hovercolor fa fa-comment-o'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number()." ".__("comments", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><i class='hovercolor fa fa-folder-o'></i><span>
                    <?php $first_item = false;
                        foreach($post_categories as $c) {
                            $cat = get_category($c); 
                            if($first_item) {
                                echo ", ";
                            }
                            $first_item = true;
                            echo "<a href='".get_category_link($c)."'>".$cat->name."</a>";
                    } ?>
                </span></li>
                <li><i class='hovercolor fa fa-user'></i><span><?php echo __("posted by", ANPS_TEMPLATE_LANG)." <a href='".get_author_posts_url(get_the_author_meta('ID'))."' class='author'>".get_the_author()."</a>"; ?></span></li>
                <li><i class='hovercolor fa fa-calendar'></i><span><?php echo get_the_date(); ?></span></li>
            </ul>
        </div>
    </header>
            <h1 ><?php the_title();?></h1>
    <div class="post-content"><?php the_content(); ?></div>
</article>
<?php elseif($num_of_sidebars=="0") : ?>
<article class='post style-2'>
<header class="text-center">
<?php echo anps_header_media_single(get_the_ID(), 'blog-full'); ?>
<h1 class="single-blog"><?php the_title(); ?></h1>
<div class='post-meta'>
<ul>
<li><i class='fa fa-comment'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number()." ".__("comments", ANPS_TEMPLATE_LANG); ?></a></li>
<li><i class='fa fa-folder-open'></i>
<?php
$first_item = false;
$post_data = "";
foreach($post_categories as $c) {
    $cat = get_category($c); 
    if($first_item) {
        $post_data .= ", ";
    }
    $first_item = true;
    $post_data .= "<a href='".get_category_link($c)."'>".esc_html($cat->name)."</a>";
} ?>
<?php echo $post_data; ?>
</li>
<li><i class='fa fa-user'></i><?php echo __("posted by", ANPS_TEMPLATE_LANG)." <a href='".get_author_posts_url(get_the_author_meta('ID'))."' class='author'>".get_the_author()."</a>"; ?></li>
<li><i class='fa fa-calendar'></i><?php echo get_the_date("j.m.Y") ?></li>
</ul>
</div>
</header>
<div class='post-content'><?php echo the_content(); ?></div> 
</article>
<?php else : ?>
<article class='post style-2'>
<header>
<span><?php echo get_the_date("j.m.Y") ?></span>
<h1><?php the_title(); ?></h1>
<div class='post-meta'>
<ul>
<li><i class='fa fa-comment'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number()." ".__("comments", ANPS_TEMPLATE_LANG); ?></a></li>
<li><i class='fa fa-folder-open'></i>
<?php
$first_item = false;
$post_data = "";
foreach($post_categories as $c) {
    $cat = get_category($c); 
    if($first_item) {
        $post_data .= ", ";
    }
    $first_item = true;
    $post_data .= "<a href='".get_category_link($c)."'>".esc_html($cat->name)."</a>";
} ?>
<?php echo $post_data; ?>
</li>
<li><i class='fa fa-user'></i><?php echo __("posted by", ANPS_TEMPLATE_LANG)." <a href='".get_author_posts_url(get_the_author_meta('ID'))."' class='author'>".get_the_author()."</a>"; ?></li>
</ul>
</div>
</header>
<div class='post-content'><?php echo the_content(); ?></div> 
</article>
<?php endif; ?>