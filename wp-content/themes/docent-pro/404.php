<?php get_header();
/*
*Template Name: 404 Page Template
*/
?>

<?php $docent_pro_logo_404   = get_theme_mod( 'logo_404', get_template_directory_uri().'/images/404-img.png' ); ?>

<div class="docent-error">
	<div class="docent-error-wrapper" style="background-image: url(<?php echo esc_url( get_theme_mod('error_404', '')); ?>)">
		<div class="row">
		    <div class="col-md-12 info-wrapper">

		    	<a class="error-logo" href="<?php echo esc_url(site_url()); ?>">
			    	<img class="enter-logo img-responsive" src="<?php echo esc_url( $docent_pro_logo_404 ); ?>" alt="<?php  esc_html_e( 'Logo', 'docent-pro' ); ?>" title="<?php esc_html_e( 'Logo', 'docent-pro' ); ?>">
			    </a>

		    	<h2 class="error-message-title"><?php echo esc_attr(get_theme_mod( '404_title', '' )); ?></h2>
		    	<p class="error-message"><?php echo esc_attr(get_theme_mod( '404_description', '' )); ?></p>
		    	
	            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-secondary">
	            	<?php echo esc_attr(get_theme_mod( '404_btn_text', 'Go Home' )); ?>
	            </a>
		    	
		    </div>
	    </div>
	</div>
</div>
<?php get_footer();
