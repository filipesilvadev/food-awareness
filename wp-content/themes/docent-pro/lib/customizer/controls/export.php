<?php

if( class_exists( 'WP_Customize_Control' ) && !class_exists( 'DOCENT_PRO_THMC_Export_Control' ) ):
	/**
	* 
	*/
	class DOCENT_PRO_THMC_Export_Control extends WP_Customize_Control
	{
		public $type = 'export';
		
		public function render_content() {

			$name = '_customize-export-button-' . $this->id;

			if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<button type="button" id="tmm-export-data" class="button"><?php esc_html_e('Export', 'docent-pro'); ?></button>
			<?php
		}
	}
endif;