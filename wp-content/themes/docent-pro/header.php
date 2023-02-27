<!DOCTYPE html> 
<html <?php language_attributes(); ?>> 
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>  
	<?php 
		$docent_pro_layout = get_theme_mod( 'boxfull_en', 'fullwidth' );
		$head_style = get_theme_mod('header_style', 'logo_center');
		$head_cat_en = get_theme_mod('en_header_cat_menu', true);
	
		$docent_pro_sticky_class = '';
		if( get_theme_mod( 'header_fixed', false )){
			$docent_pro_sticky_class = ' enable-sticky ';
		} 
	?> 
	<div id="page" class="hfeed site <?php echo esc_attr($docent_pro_layout); ?>">

	<header id="masthead" class="site-header <?php echo esc_attr($docent_pro_sticky_class); ?><?php echo $head_style == 'logo_left' || !$head_cat_en ? 'logo-left-style' : ''; ?>">  	
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="primary-menu">
						<div class="row">

							<!-- Course Category -->
							<?php if(get_theme_mod('en_header_cat_menu', true)) {?>
							<div class="col-lg-5 clearfix col-4 <?php echo $head_style == 'logo_left' ? 'order-lg-2' : ''; ?>">
			                    <?php
								$category_menu_label = get_theme_mod('category_menu_label', 'Courses');
								$course_page_url = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/');
								$cat_icon = get_theme_mod('category_menu_icon', get_template_directory_uri().'/images/course-cat.png');
			                    if( taxonomy_exists('course-category')) :
			                        ?>
			                        <div class="header-cat-menu">
			                            <div>
											<img src="<?php echo esc_url($cat_icon); ?>" alt="<?php esc_attr__('Category Icon', 'docent-pro'); ?>">
											<a href="<?php echo esc_attr($course_page_url);  ?>">
												<?php echo esc_html($category_menu_label); ?>
											</a>
			                                <i class="fas fa-caret-down"></i>
			                            </div>

			                            <ul>
			                                <?php
				                                wp_list_categories(
				                                    array(
				                                        'taxonomy' => 'course-category',
				                                        'title_li' => ''
				                                    )
				                                );
			                                ?>
			                            </ul>
			                        </div>
			                    <?php endif; ?>
							</div>
							<!--Course category-->
							<?php }?>

							<div class="col-lg-2 clearfix col-4">
								<div class="docent-navbar-header">
									<div class="logo-wrapper">
										<a class="docent-navbar-brand" href="<?php echo esc_url(site_url()); ?>">
											<?php
											$docent_pro_logoimg   = get_theme_mod( 'logo', get_template_directory_uri().'/images/logo.svg' );
											$docent_pro_logotext  = get_theme_mod( 'logo_text', 'docent-pro' );
											$docent_pro_logotype  = get_theme_mod( 'logo_style', 'logoimg' );
											switch ($docent_pro_logotype) {
												case 'logoimg':
												if( !empty($docent_pro_logoimg) ) { ?>
													<img class="enter-logo img-responsive" src="<?php echo esc_url( $docent_pro_logoimg ); ?>" alt="<?php esc_html_e( 'Logo', 'docent-pro' ); ?>" title="<?php esc_html_e( 'Logo', 'docent-pro' ); ?>">
												<?php } else { ?>
													<h1> <?php echo esc_html(get_bloginfo('name'));?> </h1>
												<?php }
												break;
												# Default Menu
												default:
												if( $docent_pro_logotext ) { ?>
													<h1> <?php echo esc_html( $docent_pro_logotext ); ?> </h1>
												<?php } else { ?>
													<h1><?php echo esc_html(get_bloginfo('name'));?> </h1>
												<?php }
												break;
											} ?>
										</a>
									</div>   
								</div> <!--/#docent-navbar-header-->   
							</div> <!--/.col-sm-2-->

							<?php if( !class_exists('wp_megamenu_initial_setup') ) { ?>
							<!-- Mobile Monu -->
							<div class="ml-auto clearfix col-4 docent-menu hidden-lg-up">
								<?php get_template_part('lib/users-login'); ?>
								<button id="hamburger-menu" type="button" class="navbar-toggle hamburger-menu-button" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="hamburger-menu-button-open"></span>
                                </button>
							</div>
							<div id="mobile-menu" class="thm-mobile-menu"> 
								<div class="collapse navbar-collapse">
									<?php 
										if ( has_nav_menu( 'primary' ) ) {
											wp_nav_menu( 
												array(
													'theme_location'    => 'primary',
													'container'         => false,
													'menu_class'        => 'nav navbar-nav',
													'fallback_cb'       => 'wp_page_menu',
													'depth'             => 3,
													'walker'            => new wp_bootstrap_mobile_navwalker()
												)
											); 
										} 
									?>
								</div>
							</div> <!-- thm-mobile-menu -->
							<?php } ?>
							
							<!-- Primary Menu with megamenu-->
							<?php if( class_exists('wp_megamenu_initial_setup') ) { ?>
							<div class="col-lg-auto ml-auto clearfix col-4 common-menu space-wrap docent-megamenu">
							<?php }else { ?>
							<div class="col-lg-auto ml-auto clearfix col-4 common-menu space-wrap <?php echo $head_style == 'logo_left' ? 'order-3' : ''; ?>">
							<?php } ?>
								<div class="header-common-menu">
									<?php if ( has_nav_menu( 'primary' ) ) { ?>
										<div id="main-menu" class="common-menu-wrap">
											<?php 
												wp_nav_menu(  
													array(
														'theme_location'  => 'primary',
														'container'       => '', 
														'menu_class'      => 'nav',
														'fallback_cb'     => 'wp_page_menu',
														'depth'            => 4,
														//'walker'          => new Megamenu_Walker()
													)
												); 

												
											?>
											
											<?php 
												if(get_theme_mod('en_header_login', true)){
													get_template_part('lib/users-login');
												}
											 ?>

											<?php if(get_theme_mod('en_header_search', true)) {?>
								
											<div class="header-search-wrap <?php echo is_user_logged_in() ? '' : 'search-not-login'; ?>">
									
												<a href="#" class="docent-search search-open-icon">
													<img src="<?php echo get_template_directory_uri();?>/images/icon-search.png" alt="">
												</a> 
												<a href="#" class="docent-search search-close-icon"><i class="far fa-times-circle"></i></a>
												<div class="header-search-input-wrap">
													<div class="header-search-overlay"></div>
													<div class="container">
														<?php $docent_action = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/'); ?>

														<form role="search" method="get" id="searchform" action="<?php echo esc_url($docent_action); ?>" class="docent-header-search search_form_shortcode">
															<div class="search-wrap form-inlines">
																<div class="search pull-right docent-top-search">
																	<div class="sp_search_input docent-search-wrapper search">
																		<div class="docent-course-search-icons"></div>
																		<input class="form-control" type="text" placeholder="<?php _e('Search Course...', 'docent-pro'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="searchword" title="<?php esc_attr_x( 'Search for:', 'label', 'docent-core' ); ?>" data-url="<?php echo get_template_directory_uri().'/lib/search-data.php'; ?>">
																		<input type="hidden" name="post_type" value="courses">
																		<button type="submit"><?php _e('Search', 'docent-pro'); ?> <i class="fas fa-search"></i></button>
																	</div>
																</div>
															</div>
														</form>

														
													</div>
												</div>

											</div> 
											<?php }?>

												
										</div><!-- End -->
										
									<?php } ?>

								</div><!-- header-common-menu -->
							</div><!-- common-menu -->
						</div>
					</div>

				</div>
			</div><!--row-->  
		</div><!--/.container--> 

		<!-- Header Progress. -->
		<?php if (get_theme_mod('progress_en', true)): ?>
			<?php if (get_theme_mod('header_fixed', true)): ?>
				<div class="docent-progress">
					<progress value="0" max="1">
						<span class="progress-bar"></span>    
					</progress>
				</div>
			<?php endif ?>
		<?php endif ?>
		<div class="docent-course-search-results"></div>
	</header> <!-- header -->

	
