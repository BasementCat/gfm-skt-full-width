<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Full Width
 */

get_header(); 
?>

<?php if( is_home() && get_option('page_for_posts') ) { ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content container">
            <main id="main" class="site-main" role="main">
                <header class="page"><h1 class="entry-title">BLOG</h1></header>
                <?php
                    if ($cat = of_get_option('frontpage-category', ''))
                    {
                        global $wp_query;
                        query_posts(array_merge($wp_query->query_vars, array('category_name' => $cat)));
                    }
                    $max_posts = (int) of_get_option('frontpage-postcount', '0');
                    $post_count = 0;
                    if (have_posts())
                    {
                        while (have_posts())
                        {
                            the_post();
                            get_template_part('content', get_post_format());
                            if ($max_posts && ++$post_count >= $max_posts) break;
                        }
                        skt_full_width_pagination();
                    }
                    else
                    {
                        get_template_part('no-results', 'index');
                    }
                    if (!empty($cat))
                    {
                        wp_reset_query();
                    }
                ?>
                <div class="clear"></div>
            </main><!-- main -->
    <?php get_footer(); ?>

<?php } else { ?>

		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html><?php } ?>