<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'directory'            => 'merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'docent-pro', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => '', // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Docent Pro Setup', 'merlin-wp' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'merlin-wp' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'merlin-wp' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'merlin-wp' ),

		'btn-skip'                 => esc_html__( 'Skip', 'merlin-wp' ),
		'btn-next'                 => esc_html__( 'Next', 'merlin-wp' ),
		'btn-start'                => esc_html__( 'Start', 'merlin-wp' ),
		'btn-no'                   => esc_html__( 'Cancel', 'merlin-wp' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'merlin-wp' ),
		'btn-child-install'        => esc_html__( 'Install', 'merlin-wp' ),
		'btn-content-install'      => esc_html__( 'Install', 'merlin-wp' ),
		'btn-import'               => esc_html__( 'Import', 'merlin-wp' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'merlin-wp' ),
		'btn-license-skip'         => esc_html__( 'Later', 'merlin-wp' ),

		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'merlin-wp' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'merlin-wp' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'merlin-wp' ),
		'license-label'            => esc_html__( 'License key', 'merlin-wp' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'merlin-wp' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'merlin-wp' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'merlin-wp' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'merlin-wp' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'merlin-wp' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import demo content. It is optional & should take only a few minutes.', 'merlin-wp' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'merlin-wp' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'merlin-wp' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'merlin-wp' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'merlin-wp' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'merlin-wp' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'merlin-wp' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'merlin-wp' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'merlin-wp' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'merlin-wp' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'merlin-wp' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'merlin-wp' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'merlin-wp' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'merlin-wp' ),

		'import-header'            => esc_html__( 'Import Demo Content', 'merlin-wp' ),
		'import'                   => esc_html__( 'Let\'s import demo content to your website, to help you get familiar with the theme.', 'merlin-wp' ),
		'import-action-link'       => esc_html__( 'Advanced', 'merlin-wp' ),

		'ready-header'             => esc_html__( 'All done. Have fun!', 'merlin-wp' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by Themeum.', 'merlin-wp' ),
		'ready-action-link'        => esc_html__( 'Extras', 'merlin-wp' ),
		'ready-big-button'         => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', home_url(), 'View your website' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://www.themeum.com/product/docent/', esc_html__( 'Explore Docent Pro', 'merlin-wp' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themeum.com/contact/', esc_html__( 'Get Theme Support', 'merlin-wp' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'merlin-wp' ) ),
	)
);
