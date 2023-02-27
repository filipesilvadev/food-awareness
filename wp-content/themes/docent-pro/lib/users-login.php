<ul class="login-cls">
	<?php if (function_exists('tutor_utils')){ ?>
		<?php if( !is_user_logged_in() ) { ?>
		    <li class="header_btn_group">
	            <a href="tab-1" class="login-popup docent-login-tab-toggle">
	                <?php echo get_theme_mod('header_login_text', 'Login'); ?>
	            </a>
		    </li>
		<?php }else { ?>
			<li class="header_profile_menu">
                <div class="docent_header_profile_photo">
                    <div class="user-icon-wrap">
                        <img src="<?php echo get_template_directory_uri();?>/images/icon-user.png" alt="">
                    </div>
                </div>
                <ul class="user-submenu">
                    <li class="user-own-info">
                        <div class="media">
                            <?php
                            
                                if(function_exists('tutor_utils')){
                                    echo wp_kses_post(tutor_utils()->get_tutor_avatar(get_current_user_id(), 'thumbnail'));
                                }else{
                                    $get_avatar_url = get_avatar_url(get_current_user_id(), 'thumbnail');
                                    echo "<img alt='Avatar' src='".esc_url($get_avatar_url)."' />";
                                }
                            ?>
                            <div class="media-body">
                                <?php
                                $uid = get_current_user_id();
                                $user = get_userdata( $uid );
                                $fname = $user->first_name;
                                $lname = $user->last_name;
                                    if(function_exists('tutor_utils')){
                                        echo '<p>'.$fname.'&nbsp'.$lname.'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </li>
                <?php 
                	if(function_exists('tutor_utils')) {
                        if(function_exists('tutor_utils')) {
                            $dashboard_page_id = tutor_utils()->get_option('tutor_dashboard_page_id');
                            $dashboard_pages = tutor_utils()->tutor_dashboard_nav_ui_items();
    
                            foreach ($dashboard_pages as $dashboard_key => $dashboard_page){
                                $menu_title = $dashboard_page;
                                $menu_link = tutils()->get_tutor_dashboard_page_permalink($dashboard_key);
                                $separator = false;
                                if (is_array($dashboard_page)){
                                    //if(!current_user_can(tutor()->instructor_role)) continue;
                                    $menu_title = tutor_utils()->array_get('title', $dashboard_page);
                                    /**
                                     * Add new menu item property "url" for custom link
                                     */
                                    if (isset($dashboard_page['url'])){
                                        $menu_link = $dashboard_page['url'];
                                    }
                                    if (isset($dashboard_page['type']) && $dashboard_page['type'] == 'separator'){
                                        $separator = true;
                                    }
                                }
                                if ($separator) {
                                    echo '<li class="tutor-dashboard-menu-divider"></li>';
                                    if ($menu_title) {
                                        echo "<li class='tutor-dashboard-menu-divider-header'>{$menu_title}</li>";
                                    }
                                } else {
                                    if ($dashboard_key === 'index') $dashboard_key = '';
                                    echo "<li><a href='".esc_url($menu_link)."'>".esc_html($menu_title)." </a> </li>";
                                }
                            }
                        }
                    }
                ?>
                </ul>
            </li>
		<?php }	?>
	<?php }	?>
</ul>		