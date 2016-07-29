<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Caviar', false ) ) {
	class Caviar{
		/**
	     * @var Singleton The reference to *Singleton* instance of this class
	     */
		private static $instance;

		/**
		 * Current version number
		 * @var   string
		 * @since 1.0.0
		 */
		const VERSION = '1.0.2';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 1.0.0
		 */
		const PRIORITY = 102;

		public function __construct(){
			if ( ! defined( 'CAVIAR_LOADED' ) ) {
				define( 'CAVIAR_LOADED', self::PRIORITY );
			}

			add_action( 'init', array( $this, 'constants'), -95 );
			add_action( 'init', array( $this, 'requires'), self::PRIORITY);
		}

		/**
	     * Returns the *Singleton* instance of this class.
	     *
	     * @return Singleton The *Singleton* instance.
	     */
		public static function getInstance(){
			if (null === static::$instance) {
				static::$instance = new static();
			}

			return static::$instance;
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

			if ( ! defined( 'CAVIAR_VERSION' ) ) {
				define( 'CAVIAR_VERSION', self::VERSION );
			}	
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

	Caviar::getInstance();
}