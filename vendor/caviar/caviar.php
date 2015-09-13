<?php 
class Caviar{
	
	public function __construct(){
		add_action( 'after_setup_theme', array( $this, 'constants'), -95 );
		add_action( 'after_setup_theme', array( $this, 'requires'), 14);
	}

	/**
	 * Constant to be used on the class
	 * @return void
	 */
	public function constants() {
		define('CAVIAR_DIR'     , trailingslashit( get_template_directory() ) . '/vendor/caviar');
		define('CAVIAR_DIR_URI' , trailingslashit( get_template_directory_uri() ) . '/vendor/caviar');	
	}

	/**
	 * Include script based on Theme Support
	 * @return Void
	 */
	public function requires(){
		require_if_theme_supports ('caviar-basic-fields', 	CAVIAR_DIR.'/class/class-basic-fields.php');
		require_if_theme_supports ('caviar-field-controls', CAVIAR_DIR.'/class/class-field-controls.php');
	}
}