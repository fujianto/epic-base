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
		$extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
		$extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $extension_dir ) );

		define('CAVIAR_DIR'     , $extension_dir);
		define('CAVIAR_DIR_URI' , $extension_url);	
		define('CAVIAR_BOWER'   , CAVIAR_DIR_URI . '/vendor/bower');	
	}

	/**
	 * Include script based on Theme Support
	 * @return Void
	 */
	public function requires(){
		require_once ( CAVIAR_DIR.'/class/class-basic-fields.php');
		require_once ( CAVIAR_DIR.'/class/class-field-controls.php');
	}
}