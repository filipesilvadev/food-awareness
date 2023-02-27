<!-- Single Page content -->
<div class="entry-summary clearfix">
    <?php 
        if ( is_single() ) {
            the_content();
        }
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'docent-pro' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
        ) ); 
    ?>
</div> <!-- .entry-summary -->

<?php if (is_single()){ ?>           
    <div class="post-tags-list">
        <h2 class="share"><?php esc_html_e('Share', 'docent-pro'); ?></h2>
        <!-- Social Share -->
        <?php
            $permalink  = get_permalink(get_the_ID());
            $titleget   = get_the_title();
            $media_url  = '';
            if( has_post_thumbnail( get_the_ID() ) ){
                $thumb_src =  wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
                $media_url = $thumb_src[0];
            }
        ?>
        <div class="share-icon">
            <a href="#" data-type="facebook" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_html($titleget); ?>" data-description="<?php echo esc_html($titleget); ?>" data-media="<?php echo esc_url( $media_url ); ?>" class="prettySocial fab fa-facebook-f"></a>
            <a href="#" data-type="twitter" data-url="<?php echo esc_url($permalink); ?>" data-description="<?php echo esc_html($titleget); ?>" class="prettySocial fab fa-twitter"></a>
            <a href="#" data-type="googleplus" data-url="<?php echo esc_url($permalink); ?>" data-description="<?php echo esc_html($titleget); ?>" class="prettySocial fab fa-google"></a>
            <a href="#" data-type="pinterest" data-url="<?php echo esc_url($permalink); ?>" data-description="<?php echo esc_html($titleget); ?>" data-media="<?php echo esc_url( $media_url ); ?>" class="prettySocial fab fa-pinterest"></a>      
            <a href="#" data-type="linkedin" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_html($titleget); ?>" data-description="<?php echo esc_html($titleget); ?>" data-via="<?php echo esc_html(get_theme_mod( 'wp_linkedin_user' )); ?>" data-media="<?php echo esc_url( $media_url ); ?>" class="prettySocial fab fa-linkedin-in"></a>
        </div> 
    </div>    
<?php } ?>

