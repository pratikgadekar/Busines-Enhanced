<?php get_header(); ?>

<div class="site-content container" role="main">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix " . $blog_post_class); ?>>
            <?php $check_if_text_only = true; ?>
            <?php if (strpos(get_post_field('post_content', get_the_ID()), "[vimeo]") > -1): ?>
            <?php
            $check_if_text_only = false;
            $content = get_post_field('post_content', get_the_ID());
            $start = strpos($content, "[vimeo]");
            $end = strpos($content, "[/vimeo]");

            echo "<div class='video-outer'>" . do_shortcode(substr($content, $start, $end - $start + 8)) . "</div>";
            ?>
                        <?php elseif (strpos(get_post_field('post_content', get_the_ID()), "[youtube]") > -1): ?>
        <?php
        $check_if_text_only = false;
        $content = get_post_field('post_content', get_the_ID());
        $start = strpos($content, "[youtube]");
        $end = strpos($content, "[/youtube]");

        echo "<div class='video-outer'>" . do_shortcode(substr($content, $start, $end - $start + 10)) . "</div>";
        ?>
            <?php elseif (get_the_post_thumbnail($post->ID, $blog_class) == ""): ?>

            <?php else: ?>
                <div class="post-media">
                    <?php $wp_image_class = explode(' ', $blog_class); ?>
                    <?php echo get_the_post_thumbnail($post->ID, $wp_image_class[0]); ?>
                </div>
            <?php endif; ?>
            
            <div class="post-inner">
            <header class="clearfix">
                <h2><?php the_title(); ?></h2>
                <div class="post-meta">
                    <span class="glyphicon first glyphicon-calendar"></span>
                    <span><?php echo get_the_date('d/m/Y'); ?></span>

                    <span class="glyphicon glyphicon-user"></span>
                    <span><?php echo get_the_author(); ?></span>

                    <span class="glyphicon glyphicon-comment"></span>
                    <a href="<?php echo the_permalink(); ?>#comments"><?php echo __('Leave comment', ANPS_TEMPLATE_LANG); ?> / <?php echo esc_attr($post->comment_count); ?></a>
                </div>
            </header>

            <?php
                $meta = get_post_meta(get_the_ID());
                $gallery_images = $meta["gallery_images"]; 
            ?>

            <div class="post-content">

				<?php if ( wp_attachment_is_image() ) :
					$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
					foreach ( $attachments as $k => $attachment ) {
						if ( $attachment->ID == $post->ID )
							break;
					}
					$k++;
					// If there is more than 1 image attachment in a gallery
					if ( count( $attachments ) > 1 ) {
						if ( isset( $attachments[ $k ] ) )
							// get the URL of the next image attachment
							$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
						else
							// or get the URL of the first image attachment
							$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
					} else {
						// or, if there's only 1 image attachment, get the URL of the image
						$next_attachment_url = wp_get_attachment_url();
					}
				?>
										<p><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
											$attachment_size = apply_filters( 'widebox_attachment_size', 900 );
											echo wp_get_attachment_image( $post->ID, array( $attachment_size, 9999 ) ); // filterable image width with, essentially, no limit for image height.
										?></a></p>
				<?php else : ?>
										<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
				<?php endif; ?>

				<?php comments_template(); ?>

				<?php endwhile; ?>

            </div>
        </div>

        <?php
            $posttags = get_the_tags();
            if ($posttags):?>
                <footer>
                    <span class="glyphicon first glyphicon-tag"></span>
                    <?php
                        $first_tag = true;
                        foreach ($posttags as $tag) {

                            if ( ! $first_tag) {
                                echo ' / ';
                            }

                            echo '<a href="' . esc_url(home_url('/')) . 'tag/' . $tag->slug . '/">';
                            echo esc_html($tag->name);
                            echo '</a>';

                            $first_tag = false;

                        }
                    ?>
                </footer>
        <?php endif; ?>

    </article>

</div>

<?php get_footer(); ?>