<?php get_header(); ?>
    <section id="main" class="generic-padding">
        <?php get_template_part('lib/sub-header')?>
        <div class="container">
            <div class="row">
                <div id="content" class="site-content col-sm-12" role="main">
                    <?php
                    query_posts(array( 'post_type' => array('courses'), 's' => get_search_query() ));
                    $docent_col = get_theme_mod( 'blog_column', 12 );?>
                    <?php if ( have_posts() ) { ?>
                        <div class="row">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <div class="separator-wrapper col-md-<?php echo esc_attr($docent_col);?>">
                                    <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php }else {  ?>
                        <div class="error-log">
                            <img src="<?php echo esc_url(get_template_directory_uri().'/images/search-error.png'); ?>"  alt="<?php  esc_html_e( 'Error Search', 'docent-pro' ); ?>">
                            <h2 class="search-error-title"><?php esc_html_e( 'Nothing Found', 'docent-pro' ); ?></h2>
                            <p class="search-error-text"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'docent-pro' ); ?></p>
                            <?php if(isset($_GET['post_type'])){ ?>
                                <div class="search-type">
                                    <form role="search" action="<?php echo esc_url(site_url('/')); ?>" method="get">
                                        <input class="custom-input" type="search" name="s" placeholder="<?php echo 'Find '.$_GET['post_type']; ?>"/>
                                        <input type="submit" alt="Search" value="Search" class="transparent-button" />
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php 
                        global $wp_query;
                        $docent_pro_page_numb = max( 1, get_query_var('paged') );
                        $docent_pro_max_page = $wp_query->max_num_pages;
                        if ($docent_pro_page_numb < $docent_pro_max_page) {
                            echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page ));  
                        }
                    ?>
                </div><!-- content -->
            </div>
        </div> <!-- .container --> 
    </section> <!-- #main -->
<?php get_footer();