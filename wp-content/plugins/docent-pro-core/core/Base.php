<?php
defined( 'ABSPATH' ) || exit;


if (! class_exists('Docent_Pro_Core_Base')) {

    class Docent_Pro_Core_Base{

        protected static $_instance = null;
        public static function instance(){
            if (is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct(){
			add_action( 'init', array( $this, 'blocks_init' ));
			add_action( 'enqueue_block_editor_assets', array( $this, 'post_editor_assets' ) );
			add_action( 'enqueue_block_assets', array( $this, 'post_block_assets' ) );
			add_filter( 'block_categories', array( $this, 'block_categories'), 1 , 2 );
		}

		/**
		 * Blocks Init
		 */
		public function blocks_init(){
			require_once DOCENT_PRO_CORE_PATH . 'core/blocks/posts/posts.php';
			require_once DOCENT_PRO_CORE_PATH . 'core/blocks/tutorcourse/tutorcourse.php';
        }
        
		/**
		 * Only for the Gutenberg Editor(Backend Only)
		 */
		public function post_editor_assets(){
			wp_enqueue_style(
				'docent-pro-core-editor-editor-css',
				DOCENT_PRO_CORE_URL . 'assets/css/blocks.editor.build.css',
				array( 'wp-edit-blocks' ),
				false
			);

			// Scripts.
			wp_enqueue_script(
				'docent-pro-core-block-script-js',
				DOCENT_PRO_CORE_URL . 'assets/js/blocks.script.build.min.js', 
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
				false,
				true
			);

			wp_localize_script( 'docent-pro-core-block-script-js', 
			'thm_option', array(
                'plugin' => DOCENT_PRO_CORE_URL,
				'name' => 'docent'
			) );
		}

		/**
		 * All Block Assets (Frontend & Backend)
		 */
		public function post_block_assets(){
			// Styles.
			wp_enqueue_style(
				'docent-pro-core-global-style-css',
				DOCENT_PRO_CORE_URL . 'assets/css/blocks.style.build.css', 
				array( 'wp-editor' ),
				false
			);
		}

		/**
		 * Block Category Add
		 */
		public function block_categories( $categories, $post ){
			return array_merge(
				array(
					array(
						'slug' => 'docent-pro',
						'title' => __( 'Docent Pro', 'docent-pro-core' ),
					)
				),
				$categories
			);
		}
		
    }
}
Docent_Pro_Core_Base::instance();





