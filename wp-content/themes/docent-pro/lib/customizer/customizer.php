<?php

/**
 * Themeum Customizer
 */


if (!class_exists('DOCENT_PRO_THMC_Framework')):

	class DOCENT_PRO_THMC_Framework
	{
		/**
		 * Instance of WP_Customize_Manager class
		 */
		public $wp_customize;


		private $docent_pro_fields_class = array();

		private $google_fonts = array();

		/**
		 * Constructor of 'DOCENT_PRO_THMC_Framework' class
		 *
		 * @wp_customize (WP_Customize_Manager) Instance of 'WP_Customize_Manager' class
		 */
		function __construct( $wp_customize )
		{
			$this->wp_customize = $wp_customize;

			$this->fields_class = array(
				'text'            => 'WP_Customize_Control',
				'checkbox'        => 'WP_Customize_Control',
				'textarea'        => 'WP_Customize_Control',
				'radio'           => 'WP_Customize_Control',
				'select'          => 'WP_Customize_Control',
				'email'           => 'WP_Customize_Control',
				'url'             => 'WP_Customize_Control',
				'number'          => 'WP_Customize_Control',
				'range'           => 'WP_Customize_Control',
				'hidden'          => 'WP_Customize_Control',
				'date'            => 'DOCENT_PRO_THMC_Date_Control',
				'color'           => 'WP_Customize_Color_Control',
				'upload'          => 'WP_Customize_Upload_Control',
				'image'           => 'WP_Customize_Image_Control',
				'radio_button'    => 'DOCENT_PRO_THMC_Radio_Button_Control',
				'checkbox_button' => 'DOCENT_PRO_THMC_Checkbox_Button_Control',
				'switch'          => 'DOCENT_PRO_THMC_Switch_Button_Control',
				'multi_select'    => 'DOCENT_PRO_THMC_Multi_Select_Control',
				'radio_image'     => 'DOCENT_PRO_THMC_Radio_Image_Control',
				'checkbox_image'  => 'DOCENT_PRO_THMC_Checkbox_Image_Control',
				'color_palette'   => 'DOCENT_PRO_THMC_Color_Palette_Control',
				'rgba'            => 'DOCENT_PRO_THMC_Rgba_Color_Picker_Control',
				'title'           => 'DOCENT_PRO_THMC_Switch_Title_Control',
			);

			$this->load_custom_controls();

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 100 );
		}

		public function customizer_scripts()
		{
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'thmc-select2', DOCENT_PRO_URI.'lib/customizer/assets/select2/css/select2.min.css' );
			wp_enqueue_style( 'thmc-customizer', DOCENT_PRO_URI.'lib/customizer/assets/css/customizer.css' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'thmc-select2', DOCENT_PRO_URI.'lib/customizer/assets/select2/js/select2.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'thmc-rgba-colorpicker', DOCENT_PRO_URI.'lib/customizer/assets/js/thmc-rgba-colorpicker.js', array('jquery', 'wp-color-picker'), '1.0', true );
			wp_enqueue_script( 'thmc-customizer', DOCENT_PRO_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );

			wp_localize_script( 'thmc-customizer', 'thm_customizer', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'import_success' => esc_html__('Success! Your theme data successfully imported. Page will be reloaded within 2 sec.', 'docent-pro'),
				'import_error' => esc_html__('Error! Your theme data importing failed.', 'docent-pro'),
				'file_error' => esc_html__('Error! Please upload a file.', 'docent-pro')
			) );
		}

		private function load_custom_controls(){
			get_template_part('lib/customizer/controls/radio-button');
            get_template_part('lib/customizer/controls/radio-image');
            get_template_part('lib/customizer/controls/checkbox-button');
            get_template_part('lib/customizer/controls/checkbox-image');
            get_template_part('lib/customizer/controls/switch');
            get_template_part('lib/customizer/controls/date');
            get_template_part('lib/customizer/controls/multi-select');
            get_template_part('lib/customizer/controls/color-palette');
            get_template_part('lib/customizer/controls/rgba-colorpicker');
            get_template_part('lib/customizer/controls/title');

            // Load Sanitize class
            get_template_part('lib/customizer/libs/sanitize');
		}

		public function add_option( $options ){
			if (isset($options['sections'])) {
				$this->panel_to_section($options);
			}
		}



		private function panel_to_section( $options )
		{
			$panel = $options;
			$panel_id = $options['id'];

			unset($panel['sections']);
			unset($panel['id']);

			// Register this panel
			$this->add_panel($panel, $panel_id);

			$sections = $options['sections'];

			if (!empty($sections)) {
				foreach ($sections as $section) {
					$docent_pro_fields = $section['fields'];
					$section_id = $section['id'];

					unset($section['fields']);
					unset($section['id']);

					$section['panel'] = $panel_id;

					$this->add_section($section, $section_id);

					if (!empty($docent_pro_fields)) {
						foreach ($docent_pro_fields as $field) {
							if (!isset($field['settings'])) {
								var_dump($field);
							}
							$field_id = $field['settings'];

							$this->add_field($field, $field_id, $section_id);
						}
					}
				}
			}
		}

		private function add_panel($panel, $panel_id){
			$this->wp_customize->add_panel( $panel_id, $panel );
		}

		private function add_section($section, $section_id)
		{
			$this->wp_customize->add_section( $section_id, $section );
		}

		private function add_field($field, $field_id, $section_id){



			$setting_args = array(
				'default'        => isset($field['default']) ? $field['default'] : '',
				'type'           => isset($field['setting_type']) ? $field['setting_type'] : 'theme_mod',
				'transport'     => isset($field['transport']) ? $field['transport'] : 'refresh',
				'capability'     => isset($field['capability']) ? $field['capability'] : 'edit_theme_options',
			);

			if (isset($field['type']) && $field['type'] == 'switch') {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'switch_sntz');
			} elseif (isset($field['type']) && ($field['type'] == 'checkbox_button' || $field['type'] == 'checkbox_image')) {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_checkbox');
			} elseif (isset($field['type']) && $field['type'] == 'multi_select') {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_select');
				$setting_args['sanitize_js_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_select_js');
			}

			$control_args = array(
				'label'       => isset($field['label']) ? $field['label'] : '',
				'section'     => $section_id,
				'settings'    => $field_id,
				'type'        => isset($field['type']) ? $field['type'] : 'text',
				'priority'    => isset($field['priority']) ? $field['priority'] : 10,
			);

			if (isset($field['choices'])) {
				$control_args['choices'] = $field['choices'];
			}

			// Register the settings
			$this->wp_customize->add_setting( $field_id, $setting_args );
			$control_class = isset($this->fields_class[$field['type']]) ? $this->fields_class[$field['type']] : 'WP_Customize_Control';
			// Add the controls
			$this->wp_customize->add_control( new $control_class( $this->wp_customize, $field_id, $control_args ) );
		}
	}

endif;

/**
*
*/
class THM_Customize
{
	public $google_fonts = array();

	function __construct( $options )
	{
		$this->options = $options;

		add_action('customize_register', array($this, 'customize_register'));
		add_action('wp_enqueue_scripts', array($this, 'get_google_fonts_data'));

		add_action('wp_ajax_thm_export_data', array($this, 'export_data_cb'));
		add_action('wp_ajax_thm_import_data', array($this, 'import_data_cb'));
	}

	public function customize_register( $wp_customize )
	{
		$docent_pro_framework = new DOCENT_PRO_THMC_Framework( $wp_customize );

		$docent_pro_framework->add_option( $this->options );

		$this->import_export_ui( $wp_customize );
	}

	public function import_export_ui( $wp_customize )
	{

		get_template_part( 'lib/customizer/controls/export' );
        get_template_part( 'lib/customizer/controls/import' );

		$wp_customize->add_section( 'thm_import_export', array(
			'title'           => esc_html__( 'Import/Export', 'docent-pro' ),
			'description'     => esc_html__( 'Import Export Option Data', 'docent-pro' ),
			'priority'        => 1000,
		) );

		$wp_customize->add_setting( 'thm_export', array(
			'default'        => '',
			'transport'      => 'postMessage',
            'capability'     => 'edit_theme_options',
            'sanitize_callback'  => 'esc_attr',
		) );

		$wp_customize->add_control( new DOCENT_PRO_THMC_Export_Control( $wp_customize, 'thm_export_ctrl', array(
			'label'       => 'Export Theme Data',
			'section'     => 'thm_import_export',
			'settings'    => 'thm_export',
			'type'        => 'export',
			'priority'    => 10,
		) ) );

		$wp_customize->add_setting( 'thm_import', array(
			'default'        => '',
			'transport'      => 'postMessage',
            'capability'     => 'edit_theme_options',
            'sanitize_callback'  => 'esc_attr',
		) );

		$wp_customize->add_control( new DOCENT_PRO_THMC_Import_Control( $wp_customize, 'thm_import_ctrl', array(
			'label'       => 'Import Theme Data',
			'section'     => 'thm_import_export',
			'settings'    => 'thm_import',
			'type'        => 'export',
			'priority'    => 10,
		) ) );
	}

	public function export_data_cb()
	{
		$theme_slug = get_option( 'stylesheet' );
		$mods = get_option( "theme_mods_$theme_slug" );

		header( "Content-Description: File Transfer" );
		header( "Content-Disposition: attachment; filename=theme_data.json" );
		header( "Content-Type: application/octet-stream" );
		echo json_encode($mods);
		exit;
	}

	public function import_data_cb()
	{

        global $wp_filesystem;
		$theme_data = $wp_filesystem->put_contents($_FILES['file']['tmp_name']);

		if (empty($theme_data)) {
			echo 0;
			exit();
		}

		$theme_data = json_decode($theme_data, true);

		if (empty($theme_data)) {
			echo 0;
			exit();
		}

		unset($theme_data['nav_menu_locations']);

		$theme_slug = get_option( 'stylesheet' );
		$mods = get_option( "theme_mods_$theme_slug" );

		if ($mods  === false) {
			$status = add_option( "theme_mods_$theme_slug", $theme_data );
			if ($status) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			$theme_data['nav_menu_locations'] = $mods['nav_menu_locations'];
			$status = update_option( "theme_mods_$theme_slug", $theme_data );

			if ($status) {
				echo 1;
			} else {
				echo 0;
			}
		}

		exit();
	}

	public function get_google_fonts_data()
	{
		if (isset($this->options['sections']) && !empty($this->options['sections'])) {
			foreach ($this->options['sections'] as $section) {
				if (isset($section['fields']) && !empty($section['fields'])) {
					foreach ($section['fields'] as $field) {
						if (isset($field['google_font']) && $field['google_font'] == true) {
							$this->google_fonts[$field['settings']] = array();

							if (isset($field['default']) && !empty($field['default'])) {
								$this->google_fonts[$field['settings']]["default"] = $field['default'];
							}

							if (isset($field['google_font_weight']) && !empty($field['google_font_weight'])) {
								$this->google_fonts[$field['settings']]["weight"] = $field['google_font_weight'];
							}

							if (isset($field['google_font_weight_default']) && !empty($field['google_font_weight_default'])) {
								$this->google_fonts[$field['settings']]["weight_default"] = $field['google_font_weight_default'];
							}
						}
					}
				}
			}
		}

		$all_fonts = array();

		if (!empty($this->google_fonts)) {
			foreach ($this->google_fonts as $font_id => $font_data) {
				$font_family_default = isset($font_data['default']) ? $font_data['default'] : '';
				$font_family = get_theme_mod( $font_id, $font_family_default );

				if (!isset($all_fonts[$font_family])) {
					$all_fonts[$font_family] = array();
				}

				if (isset($font_data['weight']) && !empty($font_data['weight'])) {
					$font_weight_default = isset($font_data['weight_default']) ? $font_data['weight_default'] : '';

					$font_weight = get_theme_mod( $font_data['weight'], $font_weight_default );

					$all_fonts[$font_family][] = $font_weight;
				}

			}
		}

		$font_url = "//fonts.googleapis.com/css?family=";

		if (!empty($all_fonts)) {

			$i = 0;

			foreach ($all_fonts as $font => $weights) {

				if ($i) {
					$font_url .= "%7C";
				}

				$font_url .= str_replace(" ", "+", $font);

				if (!empty($weights)) {
					$font_url .= ":";
					$font_url .= implode(",", $weights);
				}

				$i++;
			}

			wp_enqueue_style( "tm-google-font", $font_url );
		}
	}
}



// Customizer Section
$docent_pro_panel_to_section = array(
	'id'           => 'languageschool_panel_options',
	'title'        => esc_html( 'Docent Pro Options', 'docent-pro' ),
	'description'  => esc_html__( 'Docent Pro Theme Options', 'docent-pro' ),
	'priority'     => 10,
	
	'sections'     => array(
		array(
			'id'              => 'header_setting',
			'title'           => esc_html__( 'Header Settings', 'docent-pro' ),
			'description'     => esc_html__( 'Header Settings', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'header_style',
					'label'    => esc_html__( 'Select Header Style', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'logo_center',
					'choices'  => array(
						'logo_center' => esc_html( 'Logo Center', 'docent-pro' ),
						'logo_left'   => esc_html( 'Logo Left', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'header_padding_top',
					'label'    => esc_html__( 'Header Top Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 13,
				),
				array(
					'settings' => 'header_padding_bottom',
					'label'    => esc_html__( 'Header Bottom Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 13,
				),
				array(
					'settings' => 'header_margin_bottom',
					'label'    => esc_html__( 'Header Bottom Margin', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 0,
				),
				array(
					'settings' => 'header_fixed',
					'label'    => esc_html__( 'Sticky Header', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'progress_en',
					'label'    => esc_html__( 'Enable Progress Bar', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'sticky_header_color',
					'label'    => esc_html__( 'Sticky background Color', 'docent-pro' ),
					'type'     => 'rgba',
					'priority' => 10,
					'default'  => '#fff',
				),
                array(
                    'settings' => 'en_header_cat_menu',
                    'label'    => esc_html__( 'Header Category Menu', 'docent-pro' ),
                    'type'     => 'switch',
                    'priority' => 10,
                    'default'  => true,
				),
				array(
					'settings' => 'category_menu_icon',
					'label'    => esc_html__( 'Upload Icon', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' 	=> get_template_directory_uri().'/images/course-cat.png',
				),
                array(
                    'settings' => 'category_menu_label',
                    'label'    => esc_html__( 'Category Menu Label Text', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => 'Courses'
				),
				array(
                    'settings' => 'en_header_search',
                    'label'    => esc_html__( 'Header Search Enable', 'docent-pro' ),
                    'type'     => 'switch',
                    'priority' => 10,
                    'default'  => true,
				),
				array(
                    'settings' => 'en_header_login',
                    'label'    => esc_html__( 'Header Login Enable', 'docent-pro' ),
                    'type'     => 'switch',
                    'priority' => 10,
                    'default'  => true,
				),
				array(
                    'settings' => 'header_login_text',
                    'label'    => esc_html__( 'Login Text', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => 'Login'
				),
		
				
			) # Fields
		), # Header_setting

		# Logo Settings
		array(
			'id'              => 'logo_setting',
			'title'           => esc_html__( 'All Logo', 'docent-pro' ),
			'description'     => esc_html__( 'All Logo', 'docent-pro' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(
				array(
					'settings' => 'logo_style',
					'label'    => esc_html__( 'Select Header Style', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'logoimg',
					'choices'  => array(
						'logoimg' => esc_html( 'Logo image', 'docent-pro' ),
						'logotext' => esc_html( 'Logo text', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'logo',
					'label'    => esc_html__( 'Upload Logo', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' 	=> get_template_directory_uri().'/images/logo.svg',
				),
				array(
					'settings' => 'logo_width',
					'label'    => esc_html__( 'Logo Width', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 90,
				),
				array(
					'settings' => 'logo_height',
					'label'    => esc_html__( 'Logo Height', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
				),
				array(
					'settings' => 'logo_text',
					'label'    => esc_html__( 'Custom Logo Text', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => 'Docent Pro',
				),
				array(
					'settings' => 'logo-404',
					'label'    => esc_html__( 'Coming Soon Logo', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => get_template_directory_uri().'/images/404-img.png',
				),		
			) # Fields
		), #logo_setting
		
		# Sub Header Banner.
		array(
			'id'              => 'sub_header_banner',
			'title'           => esc_html__( 'Sub Header Banner', 'docent-pro' ),
			'description'     => esc_html__( 'sub header banner', 'docent-pro' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(

				array(
					'settings' => 'sub_header_padding_top',
					'label'    => esc_html__( 'Sub-Header Padding Top', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),
				array(
					'settings' => 'sub_header_padding_bottom',
					'label'    => esc_html__( 'Sub-Header Padding Bottom', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),
				array(
					'settings' => 'sub_header_banner_img',
					'label'    => esc_html__( 'Sub-Header Background Image', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' 	=> '',
				),
				array(
					'settings' => 'sub_header_title',
					'label'    => esc_html__( 'Title Settings', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_header_title_size',
					'label'    => esc_html__( 'Header Title Font Size', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => '34',
				),
				array(
					'settings' => 'sub_header_title_color',
					'label'    => esc_html__( 'Header Title Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),
			)//fields
		),//sub_header_banner


		# Docent Social Login. 
		array(
            'id'              => 'docent_login_options',
            'title'           => esc_html__( 'Social login', 'docent-pro' ),
            'description'     => esc_html__( 'Social login', 'docent-pro' ),
            'priority'        => 10,
            'fields'         => array(
                array(
                    'settings' => 'en_social_login',
                    'label'    => esc_html__( 'Enable Social Login', 'docent-pro' ),
                    'type'     => 'switch',
                    'priority' => 10,
                    'default'  => true,
                ),
                array(
                    'settings' => 'google_client_ID',
                    'label'    => esc_html__( 'Google Login Client ID* (Leave empty to disable), ', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => ''
                ),
                array(
                    'settings' => 'facebook_app_ID',
                    'label'    => esc_html__( 'Facebook login App ID* (Leave empty to disable), ', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => ''
                ),
                array(
                    'settings' => 'twitter_consumer_key',
                    'label'    => esc_html__( 'Twitter Login Consumer Key* (Leave empty to disable), ', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => ''
                ),
                array(
                    'settings' => 'twitter_consumer_secreat',
                    'label'    => esc_html__( 'Twitter Login Consumer Secret* ', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => ''
                ),
                array(
                    'settings' => 'twitter_auth_callback_url',
                    'label'    => esc_html__( 'Twitter Login auth redirect URL* ', 'docent-pro' ),
                    'type'     => 'text',
                    'priority' => 10,
                    'default'  => ''
                ),
            )//fields
        ),//logo_setting


		array(
			'id'              => 'typo_setting',
			'title'           => esc_html__( 'Typography Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Typography Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(

				array(
					'settings' => 'font_title_body',
					'label'    => esc_html__( 'Body Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//body font
				array(
					'settings' => 'body_google_font',
					'label'    => esc_html__( 'Select Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Taviraj',
					'choices'  => get_google_fonts(),
					'google_font' 					=> true,
					'google_font_weight' 			=> 'body_font_weight',
					'google_font_weight_default' 	=> '400'
				),
				array(
					'settings' => 'body_font_size',
					'label'    => esc_html__( 'Body Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'body_font_height',
					'label'    => esc_html__( 'Body Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'body_font_weight',
					'label'    => esc_html__( 'Body Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '400',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'body_font_color',
					'label'    => esc_html__( 'Body Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#535967',
				),
				array(
					'settings' => 'font_title_menu',
					'label'    => esc_html__( 'Menu Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
                ),
                
				//Menu font
				array(
					'settings' => 'menu_google_font',
					'label'    => esc_html__( 'Select Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'menu_font_size',
					'label'    => esc_html__( 'Menu Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'menu_font_height',
					'label'    => esc_html__( 'Menu Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '54',
				),
				array(
					'settings' => 'menu_font_weight',
					'label'    => esc_html__( 'Menu Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'menu_font_color',
					'label'    => esc_html__( 'Menu Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h1',
					'label'    => esc_html__( 'Heading 1 Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 1
				array(
					'settings' => 'h1_google_font',
					'label'    => esc_html__( 'Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'h1_font_size',
					'label'    => esc_html__( 'Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '46',
				),
				array(
					'settings' => 'h1_font_height',
					'label'    => esc_html__( 'Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '48',
				),
				array(
					'settings' => 'h1_font_weight',
					'label'    => esc_html__( 'Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'h1_font_color',
					'label'    => esc_html__( 'Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h2',
					'label'    => esc_html__( 'Heading 2 Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 2
				array(
					'settings' => 'h2_google_font',
					'label'    => esc_html__( 'Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h2_font_size',
					'label'    => esc_html__( 'Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '30',
				),
				array(
					'settings' => 'h2_font_height',
					'label'    => esc_html__( 'Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '36',
				),
				array(
					'settings' => 'h2_font_weight',
					'label'    => esc_html__( 'Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'h2_font_color',
					'label'    => esc_html__( 'Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h3',
					'label'    => esc_html__( 'Heading 3 Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 3
				array(
					'settings' => 'h3_google_font',
					'label'    => esc_html__( 'Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '400'
				),
				array(
					'settings' => 'h3_font_size',
					'label'    => esc_html__( 'Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'h3_font_height',
					'label'    => esc_html__( 'Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '28',
				),
				array(
					'settings' => 'h3_font_weight',
					'label'    => esc_html__( 'Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'h3_font_color',
					'label'    => esc_html__( 'Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h4',
					'label'    => esc_html__( 'Heading 4 Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 4
				array(
					'settings' => 'h4_google_font',
					'label'    => esc_html__( 'Heading4 Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h4_font_size',
					'label'    => esc_html__( 'Heading4 Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '18',
				),
				array(
					'settings' => 'h4_font_height',
					'label'    => esc_html__( 'Heading4 Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '28',
				),
				array(
					'settings' => 'h4_font_weight',
					'label'    => esc_html__( 'Heading4 Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'h4_font_color',
					'label'    => esc_html__( 'Heading4 Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h5',
					'label'    => esc_html__( 'Heading 5 Font Options', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),

				//Heading 5
				array(
					'settings' => 'h5_google_font',
					'label'    => esc_html__( 'Heading5 Google Font', 'docent-pro' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h5_font_size',
					'label'    => esc_html__( 'Heading5 Font Size', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'h5_font_height',
					'label'    => esc_html__( 'Heading5 Font Line Height', 'docent-pro' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'h5_font_weight',
					'label'    => esc_html__( 'Heading5 Font Weight', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html( 'Select', 'docent-pro' ),
						'100' => esc_html( '100', 'docent-pro' ),
						'200' => esc_html( '200', 'docent-pro' ),
						'300' => esc_html( '300', 'docent-pro' ),
						'400' => esc_html( '400', 'docent-pro' ),
						'500' => esc_html( '500', 'docent-pro' ),
						'600' => esc_html( '600', 'docent-pro' ),
						'700' => esc_html( '700', 'docent-pro' ),
						'800' => esc_html( '800', 'docent-pro' ),
						'900' => esc_html( '900', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'h5_font_color',
					'label'    => esc_html__( 'Heading5 Font Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

			)//fields
		),//typo_setting

		array(
			'id'              => 'layout_styling',
			'title'           => esc_html__( 'Layout & Styling', 'docent-pro' ),
			'description'     => esc_html__( 'Layout & Styling', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'boxfull_en',
					'label'    => esc_html__( 'Select BoxWidth of FullWidth', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'fullwidth',
					'choices'  => array(
						'boxwidth' => esc_html__( 'BoxWidth', 'docent-pro' ),
						'fullwidth' => esc_html__( 'FullWidth', 'docent-pro' ),
					)
				),

				array(
					'settings' => 'body_bg_color',
					'label'    => esc_html__( 'Body Background Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'body_bg_img',
					'label'    => esc_html__( 'Body Background Image', 'docent-pro' ),
					'type'     => 'image',
					'priority' => 10,
				),
				array(
					'settings' => 'body_bg_attachment',
					'label'    => esc_html__( 'Body Background Attachment', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'fixed',
					'choices'  => array(
						'scroll' 	=> esc_html__( 'Scroll', 'docent-pro' ),
						'fixed' 	=> esc_html__( 'Fixed', 'docent-pro' ),
						'inherit' 	=> esc_html__( 'Inherit', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'body_bg_repeat',
					'label'    => esc_html__( 'Body Background Repeat', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'no-repeat',
					'choices'  => array(
						'repeat' => esc_html__( 'Repeat', 'docent-pro' ),
						'repeat-x' => esc_html__( 'Repeat Horizontally', 'docent-pro' ),
						'repeat-y' => esc_html__( 'Repeat Vertically', 'docent-pro' ),
						'no-repeat' => esc_html__( 'No Repeat', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'body_bg_size',
					'label'    => esc_html__( 'Body Background Size', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'cover',
					'choices'  => array(
						'cover' => esc_html__( 'Cover', 'docent-pro' ),
						'contain' => esc_html__( 'Contain', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'body_bg_position',
					'label'    => esc_html__( 'Body Background Position', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'left top',
					'choices'  => array(
						'left top' => esc_html__('left top', 'docent-pro'),
						'left center' => esc_html__('left center', 'docent-pro'),
						'left bottom' => esc_html__('left bottom', 'docent-pro'),
						'right top' => esc_html__('right top', 'docent-pro'),
						'right center' => esc_html__('right center', 'docent-pro'),
						'right bottom' => esc_html__('right bottom', 'docent-pro'),
						'center top' => esc_html__('center top', 'docent-pro'),
						'center center' => esc_html__('center center', 'docent-pro'),
						'center bottom' => esc_html__('center bottom', 'docent-pro'),
					)
				),
				array(
					'settings' => 'custom_preset_en',
					'label'    => esc_html__( 'Set Custom Color', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'major_color',
					'label'    => esc_html__( 'Major Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),
				array(
					'settings' => 'hover_color',
					'label'    => esc_html__( 'Hover Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#333',
				),
			
				# navbar color section start.
				array(
					'settings' => 'menu_color_title',
					'label'    => esc_html__( 'Menu Color Settings', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'navbar_text_color',
					'label'    => esc_html__( 'Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),
				array(
					'settings' => 'navbar_hover_text_color',
					'label'    => esc_html__( 'Hover Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),

				array(
					'settings' => 'navbar_active_text_color',
					'label'    => esc_html__( 'Active Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),

				array(
					'settings' => 'sub_menu_color_title',
					'label'    => esc_html__( 'Sub-Menu Color Settings', 'docent-pro' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_menu_bg',
					'label'    => esc_html__( 'Background Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#f8f8f8',
				),
				array(
					'settings' => 'sub_menu_text_color',
					'label'    => esc_html__( 'Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#7e879a',
				),
				array(
					'settings' => 'sub_menu_text_color_hover',
					'label'    => esc_html__( 'Hover Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),
				#End of the navbar color section
			)//fields
		),//Layout & Styling


		array(
			'id'              => 'social_media_settings',
			'title'           => esc_html__( 'Social Media', 'docent-pro' ),
			'description'     => esc_html__( 'Social Media', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'wp_facebook',
					'label'    => esc_html__( 'Add Facebook URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '#',
				),
				array(
					'settings' => 'wp_twitter',
					'label'    => esc_html__( 'Add Twitter URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '#',
				),
				array(
					'settings' => 'wp_google_plus',
					'label'    => esc_html__( 'Add Goole Plus URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '#',
				),
				array(
					'settings' => 'wp_pinterest',
					'label'    => esc_html__( 'Add Pinterest URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '#',
				),
				array(
					'settings' => 'wp_youtube',
					'label'    => esc_html__( 'Add Youtube URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_linkedin',
					'label'    => esc_html__( 'Add Linkedin URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_linkedin_user',
					'label'    => esc_html__( 'Linkedin Username( For Share )', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),

				array(
					'settings' => 'wp_instagram',
					'label'    => esc_html__( 'Add Instagram URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '#',
				),
				array(
					'settings' => 'wp_dribbble',
					'label'    => esc_html__( 'Add Dribbble URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_behance',
					'label'    => esc_html__( 'Add Behance URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_flickr',
					'label'    => esc_html__( 'Add Flickr URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_vk',
					'label'    => esc_html__( 'Add Vk URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_skype',
					'label'    => esc_html__( 'Add Skype URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
			)//fields
		),//social_media

		array(
			'id'              => 'coming_soon',
			'title'           => esc_html__( 'Coming Soon', 'docent-pro' ),
			'description'     => esc_html__( 'Coming Soon', 'docent-pro' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(
				array(
					'settings' => 'comingsoon_en',
					'label'    => esc_html__( 'Enable Coming Soon', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'coming_soon_bg',
					'label'    => esc_html__( 'Coming Background Image', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => get_template_directory_uri().'/images/coming-soon-bg.svg',
				),
				array(
					'settings' => 'coming_soon_logo',
					'label'    => esc_html__( 'Upload Logo', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => get_template_directory_uri().'/images/coming-soon-user.png',
				),

				array(
					'settings' => 'user_info_text',
					'label'    => esc_html__( 'Add user info text', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => esc_html__( 'Hello! I am Jayden Patton', 'docent-pro' ),
				),
				array(
					'settings' => 'comingsoontitle',
					'label'    => esc_html__( 'Add Coming Soon Title', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => esc_html__( 'Coming Soon', 'docent-pro' ),
				),

				array(
					'settings' => 'countdown_en',
					'label'    => esc_html__( 'Enable Countdown', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'comingsoon_date',
					'label'    => esc_html__( 'Coming Soon date', 'docent-pro' ),
					'type'     => 'date',
					'priority' => 10,
					'default'  => '2020-08-09',
				),
				array(
					'settings' => 'newsletter',
					'label'    => esc_html__( 'Add mailchimp Form Shortcode Here', 'docent-pro' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'coming_description',
					'label'    => esc_html__( 'Coming Soon Description', 'docent-pro' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => esc_html__('We are come back soon', 'docent-pro'),
				),
				array(
					'settings' => 'comingsoon_facebook',
					'label'    => esc_html__( 'Add Facebook URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_twitter',
					'label'    => esc_html__( 'Add Twitter URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_pinterest',
					'label'    => esc_html__( 'Add Pinterest URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_youtube',
					'label'    => esc_html__( 'Add Youtube URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_linkedin',
					'label'    => esc_html__( 'Add Linkedin URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_dribbble',
					'label'    => esc_html__( 'Add Dribbble URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'comingsoon_instagram',
					'label'    => esc_html__( 'Add Instagram URL', 'docent-pro' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
			) # Fields
		), # coming_soon

		# 404 Page.
		array(
			'id'              => '404_settings',
			'title'           => esc_html__( '404 Page', 'docent-pro' ),
			'description'     => esc_html__( '404 page background and text settings', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(

				array(
					'settings' => 'error_404',
					'label'    => esc_html__( 'Background Image', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => get_template_directory_uri().'/images/404-img.png',
				),
				array(
					'settings' => 'logo_404',
					'label'    => esc_html__( 'Upload Image', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => get_template_directory_uri().'/images/logo.svg',
				),
				array(
					'settings' => '404_description',
					'label'    => esc_html__( '404 Page Description', 'docent-pro' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => ''
				),
			)
		),

		# Blog Settings.
		array(
			'id'              => 'blog_setting',
			'title'           => esc_html__( 'Blog Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Blog Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'enable_sidebar',
					'label'    => esc_html__( 'Enable Blog Sidebar', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_column',
					'label'    => esc_html__( 'Select Blog Column', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '6',
					'choices'  => array(
						'12' 	=> esc_html( 'Column 1', 'docent-pro' ),
						'6' 	=> esc_html( 'Column 2', 'docent-pro' ),
						'4' 	=> esc_html( 'Column 3', 'docent-pro' ),
						'3' 	=> esc_html( 'Column 4', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'en_blog_date',
					'label'    => esc_html__( 'Enable Blog Date', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_author',
					'label'    => esc_html__( 'Enable Blog Author', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_category',
					'label'    => esc_html__( 'Enable Blog Category', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_intro_en',
					'label'    => esc_html__( 'Enable Blog Content', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),				

			)//fields
		),//blog_setting

		array(
			'id'              => 'blog_single_setting',
			'title'           => esc_html__( 'Blog Single Page Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Blog Single Page Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				
				array(
					'settings' => 'blog_date_single',
					'label'    => esc_html__( 'Enable Blog Date', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_author_single',
					'label'    => esc_html__( 'Enable Blog Author', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_category_single',
					'label'    => esc_html__( 'Enable Blog Category', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_hit_single',
					'label'    => esc_html__( 'Enable Hit Count', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_comment_single',
					'label'    => esc_html__( 'Enable Comment', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_tags_single',
					'label'    => esc_html__( 'Blog Tag', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
					 		
			) #Fields
		), # Blog Single Page Setting

		# Mailchamp Settings
		array( 
			'id'              => 'mailchamp_setting',
			'title'           => esc_html__( 'Mailchimp Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Mailchimp Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'newsletter_en',
					'label'    => esc_html__( 'Enable Newsletter', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'footer_newsletter',
					'label'    => esc_html__( 'Add mailchimp Form Shortcode Here', 'docent-pro' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'mc_bg_color',
					'label'    => esc_html__( 'Background Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fbfbfc',
				),
				array(
					'settings' => 'mc_padding_top',
					'label'    => esc_html__( 'Bottom Top Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),	
				array(
					'settings' => 'mc_padding_bottom',
					'label'    => esc_html__( 'Bottom Padding Bottom', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 45,
				),
			)
		),
		# Mailchamp End


		array(
			'id'              => 'bottom_setting',
			'title'           => esc_html__( 'Bottom Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Bottom Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'bottom_en',
					'label'    => esc_html__( 'Enable Bottom Area', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'bottom_column',
					'label'    => esc_html__( 'Select Bottom Column', 'docent-pro' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '4',
					'choices'  => array(
						'12' => esc_html( 'Column 1', 'docent-pro' ),
						'6' => esc_html( 'Column 2', 'docent-pro' ),
						'4' => esc_html( 'Column 3', 'docent-pro' ),
						'3' => esc_html( 'Column 4', 'docent-pro' ),
					)
				),
				array(
					'settings' => 'bottom_color',
					'label'    => esc_html__( 'Bottom background Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fbfbfc',
				),
				array(
					'settings' => 'bottom_title_color',
					'label'    => esc_html__( 'Bottom Title Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),	
				array(
					'settings' => 'bottom_link_color',
					'label'    => esc_html__( 'Bottom Link Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#a8a9c4',
				),				
				array(
					'settings' => 'bottom_hover_color',
					'label'    => esc_html__( 'Bottom link hover color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'bottom_text_color',
					'label'    => esc_html__( 'Bottom Text color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#a8a9c4',
				),
				array(
					'settings' => 'bottom_padding_top',
					'label'    => esc_html__( 'Bottom Top Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),	
				array(
					'settings' => 'bottom_padding_bottom',
					'label'    => esc_html__( 'Bottom Padding Bottom', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 45,
				),					
			)//fields
		),//bottom_setting	


		# Footer Settings.	
		array(
			'id'              => 'footer_setting',
			'title'           => esc_html__( 'Footer Setting', 'docent-pro' ),
			'description'     => esc_html__( 'Footer Setting', 'docent-pro' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'footer_en',
					'label'    => esc_html__( 'Disable Copyright Area', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'footer_logo',
					'label'    => esc_html__( 'Upload Logo', 'docent-pro' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' => get_template_directory_uri().'/images/logo.svg',
				),
				array(
					'settings' => 'copyright_en',
					'label'    => esc_html__( 'Disable copyright text', 'docent-pro' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'copyright_text',
					'label'    => esc_html__( 'Copyright Text', 'docent-pro' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => esc_html__( '2019 Docent Pro. All Rights Reserved.', 'docent-pro' ),
				),
				array(
					'settings' => 'copyright_text_color',
					'label'    => esc_html__( 'Footer Text Color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#6c6d8b',
				),				
				array(
					'settings' => 'copyright_hover_color',
					'label'    => esc_html__( 'Footer link hover color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'copyright_bg_color',
					'label'    => esc_html__( 'Footer background color', 'docent-pro' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fbfbfc',
				),
				array(
					'settings' => 'copyright_padding_top',
					'label'    => esc_html__( 'Footer Top Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 30,
				),	
				array(
					'settings' => 'copyright_padding_bottom',
					'label'    => esc_html__( 'Footer Bottom Padding', 'docent-pro' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 20,
				),					
			)//fields
		),//footer_setting.
		
	),
);//wpestate-core_panel_options

$docent_pro_framework = new THM_Customize( $docent_pro_panel_to_section );

