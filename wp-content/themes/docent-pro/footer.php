<section class="footer-bottom">
     <!-- Footer Widgets -->
    <?php if( get_theme_mod('newsletter_en', false)): ?>
        <div class="footer-mailchamp"> 
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- News Latter -->
                        <div class="newslatter">
                            <?php echo do_shortcode(get_theme_mod( 'footer_newsletter' )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/#bottom-wrap-->
    <?php endif; ?> 

    <!-- Footer Widgets -->
    <?php if ( get_theme_mod( 'bottom_en', false )) { ?>
        <?php $docent_col = get_theme_mod( 'bottom_column', 3 ); ?>
        <div id="bottom-wrap"  class="footer"> 
            <div class="container">
                <div class="row clearfix border-wrap">
                    <?php if (is_active_sidebar('bottom1')):?>
                        <div class="col-sm-6 col-md-6 col-lg-<?php echo esc_attr($docent_col);?>">
                            <?php dynamic_sidebar('bottom1'); ?>
                        </div>
                    <?php endif; ?> 
                    <?php if (is_active_sidebar('bottom2')):?>
                        <div class="col-sm-6 col-md-6 col-lg-<?php echo esc_attr($docent_col);?>">
                            <?php dynamic_sidebar('bottom2'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('bottom3')):?>
                        <div class="col-sm-6 col-md-6 col-lg-<?php echo esc_attr($docent_col);?>">
                            <?php dynamic_sidebar('bottom3'); ?>
                        </div>  
                    <?php endif; ?>  
                    <?php if (is_active_sidebar('bottom4')):?>                 
                        <div class="col-sm-6 col-md-6 col-lg-<?php echo esc_attr($docent_col);?>">
                            <?php dynamic_sidebar('bottom4'); ?>
                        </div>
                    <?php endif; ?>  
                </div>
            </div>
        </div><!--/#bottom-wrap-->
    <?php } ?>
</section>

<?php if ( get_theme_mod( 'footer_en', true )) { ?>
    <footer id="footer-wrap"> 
        <div class="container">
            <div class="row clearfix">
                
                <div class="col-sm-12 text-sm-center text-md-left col-md-6">
                    <div class="footer-copyright">
                        <?php $docent_pro_footer_logo = get_theme_mod( 'footer_logo', get_template_directory_uri().'/images/logo.svg' );
                            if( !empty($docent_pro_footer_logo) ) { ?>
                                <a class="docent-navbar-brand" href="<?php echo esc_url(site_url()); ?>">
                                    <img class="enter-logo img-responsive" src="<?php echo esc_url( $docent_pro_footer_logo ); ?>" alt="<?php esc_html_e( 'Logo', 'docent-pro' ); ?>" title="<?php esc_html_e( 'Logo', 'docent-pro' ); ?>"> 
                                </a>
                        <?php } ?>

                        
                    </div> <!-- col-md-6 -->
                </div> <!-- end footer-copyright -->
                  
                <div class="col-sm-12 col-md-6 text-right">
                    <?php if( get_theme_mod( 'copyright_en', true ) ) { ?>
                        <?php echo wp_kses_post( get_theme_mod( 'copyright_text', '2019 Docent Pro. All Rights Reserved.')); ?>
                    <?php } ?> 
                </div>

            </div><!--/.row clearfix-->    
        </div><!--/.container-->    
    </footer><!--/#footer-wrap-->    
<?php } ?>

</div> <!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
