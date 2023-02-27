<?php if(!is_user_logged_in()) { ?>
    <!-- Modal registration -->

    <div class="docent-signin-modal-popup" style="display: none;">
        <div class="docent-modal-overlay"></div>
        <div class="docent-signin-popup-inner" data-docent-login-tab="tab-1">
            <a href="#" class="docent-login-modal-close fas fa-times"></a>
            <div class="docent-signin-popup-body">
                <div class="docent-signin-modal-form">
                    <h2><?php esc_html_e('Sign In', 'docent-pro-core') ?></h2>
                    <form action="login" id="login" method="post">
                        <p class="status"></p>
                        <input type="text" id="username2" name="username" placeholder="<?php _e('Username', 'docent-pro-core');?>">
                        <input type="password" id="password2" placeholder="<?php _e('Password', 'docent-pro-core');?>" name="password">
                        <label for="rememberme" class="docent-login-remember">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <span class="fas fa-check"></span><?php _e('Remember Me', 'docent-pro-core'); ?>
                        </label>
                        <button class="docent_btn btn-fill" type="submit"><?php esc_html_e('Login Now', 'docent-pro-core') ?></button>
                        <?php wp_nonce_field( 'ajax-login-nonce2', 'security2' ); ?>
                    </form>

                </div>
                <div class="docent-signin-modal-right">
                    <p><?php esc_html_e('If you don’t already have an account click the button below to create your account.', 'docent-pro-core'); ?></p>
                    <a class='docent-login-tab-toggle docent_btn btn-fill  bg-black' href='#tab-2'><?php esc_html_e('Create New Account', 'docent-pro-core');?></a>
                    
                    <?php
                    $en_social_login = get_theme_mod('en_social_login', true);
                    $google_client_ID = get_theme_mod('google_client_ID', true);
                    $facebook_app_ID = get_theme_mod('facebook_app_ID', true);
                    $twitter_consumer_key = get_theme_mod('twitter_consumer_key', true);
                    $twitter_consumer_secreat = get_theme_mod('twitter_consumer_secreat', true);
                    $twitter_auth_callback_url = get_theme_mod('twitter_auth_callback_url', true);
                    $social_twitter_condition = !empty($twitter_consumer_key) && !empty($twitter_consumer_secreat) && !empty($twitter_auth_callback_url);
                    $social_condition_all = $social_twitter_condition || !empty($google_client_ID) || !empty($facebook_app_ID);
                    ?>
                    
                    <?php echo do_shortcode('[nextend_social_login]'); ?>
                    
                    <?php if ($en_social_login): ?>    
                    <div class="docent-login-popup-divider"><?php _e('OR', 'docent-pro-core') ?></div>
                    <div class="docent-signin-modal-social">
                        <?php if(!empty($google_client_ID)) : ?>
                            <a href="#" class="google-login" id="gSignIn2">
                                <img src="<?php echo DOCENT_PRO_CORE_URL.'assets/img/google-icon.png';?>" alt="google icon"/>
                            </a>
                        <?php endif; ?>
                        <?php if($facebook_app_ID) : ?>
                            <a href="#" class="facebook-login docent_btn btn-fill bg-facebook" onclick="javascript:login();"> <i class="fab fa-facebook-f"></i> <?php esc_html_e('Login with Facebook', 'docent-pro-core')?></a>
                            <div id="fb-root"></div>
                        <?php endif; ?>
                        <?php if($social_twitter_condition) : ?>
                            <a class="twitter-login docent_btn btn-fill bg-twitter" href="<?php echo esc_url($twitter_auth_callback_url).'?twitterlog=1'; ?>"> <i class="fab fa-twitter"></i> <?php esc_html_e('Login with Twitter', 'docent-pro-core')?></a>
                        <?php endif; ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="docent-signin-popup-footer">
                <?php
                $lostpass_url =  wp_lostpassword_url();
                printf(__('So you can’t get in to your account? Did you %s forget your password? %s', 'docent-pro-core'), "<a href='$lostpass_url'>", "</a>");
                ?>
            </div>
        </div> <!--docent-signin-popup-inner-->

        <div class="docent-signin-popup-inner" data-docent-login-tab="tab-2"  style="display: none">
            <a href="#" class="docent-login-modal-close fas fa-times"></a>
            <div class="docent-signin-popup-body">
                <div class="docent-signin-modal-form">
                    <h2><?php esc_html_e('Registration', 'docent-pro-core') ?></h2>
                    <form form id="registerform" action="login" method="post">
                        <p class="status"></p>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" id="nickname" name="nickname" placeholder="<?php esc_html_e('Nickname', 'docent-pro-core');?>">
                                <input type="text" id="username" name="username" placeholder="<?php esc_html_e('Username', 'docent-pro-core');?>">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="email" name="email" placeholder="<?php esc_html_e('Email', 'docent-pro-core');?>">
                                <input type="password" id="password" name="password" placeholder="<?php esc_html_e('Password', 'docent-pro-core');?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="docent_btn btn-fill register_button" type="submit"><?php esc_html_e('Registration', 'docent-pro-core') ?></button>
                                <?php wp_nonce_field( 'ajax-register-nonce', 'security' ); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="docent-signin-popup-footer">
                <?php printf(__('Already have an account? %s Sign In %s', 'docent-pro-core'), "<a class='docent-login-tab-toggle' href='#tab-1'>", "</a>");
                ?>
            </div>
        </div><!--docent-signin-popup-inner-->

    </div>
<?php } ?>