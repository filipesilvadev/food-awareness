<?php get_header(); ?>

<section id="main">
    <?php get_template_part('lib/sub-header'); ?>
    <div class="container blog-full-container">
        <?php $enable_sidebar = get_theme_mod('enable_sidebar', false); ?>
        <div class="row">
            <div id="content" class="site-content col-md-<?php echo esc_attr($enable_sidebar ? '9' : '12'); ?>" role="main">
                <div class="row">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) : the_post(); ?>
                            <div class="separator-wrapper col-md-<?php echo esc_attr(get_theme_mod( 'blog_column', 6 ));?>">
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                            </div>
                        <?php
                        endwhile;

                        $docent_pro_page_numb = max( 1, get_query_var('paged') );
                        $docent_pro_max_page = $wp_query->max_num_pages;
                        echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page ));

                    } else {
                        get_template_part( 'post-format/content', 'none' );
                    }
                    ?>
                </div>
            </div>
            <?php if($enable_sidebar) get_sidebar(); ?>
        </div> <!-- .row -->
    </div><!-- .container -->
</section> 
<?php get_footer();