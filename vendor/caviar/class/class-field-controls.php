<?php
if( ! class_exists('Field_Controls')) {

	class Field_Controls extends Basic_Fields{
		/**
	     * @var Singleton The reference to *Singleton* instance of this class
	     */
		private static $instance;
		
		public function __construct(){
			/* Enable media library */
			add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
			/* Add custom Admin styles. */
			add_action( 'admin_enqueue_scripts',  array($this, 'caviar_enqueue_admin_styles'));

			/* Add custom Admin scripts. */
			add_action( 'admin_enqueue_scripts', array($this, 'caviar_enqueue_admin_scripts'));

			/* Add the color picker css file */       
			add_action( 'admin_enqueue_scripts',  array($this, 'caviar_add_color_picker'));
		}

		public static function getInstance(){
			if (null === static::$instance) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		public function caviar_enqueue_admin_styles(){
			wp_enqueue_style( 'caviar-styles'      , CAVIAR_DIR_URI. '/css/caviar-admin-styles.css');
			wp_enqueue_style( 'radiotabs-admin'    , CAVIAR_DIR_URI. '/css/caviar-radio-tabs.css');
			wp_enqueue_style( 'caviar-fontawesome' , 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css');
			wp_enqueue_style( 'chosen'             , CAVIAR_BOWER . '/chosen/chosen.min.css');

			// wp_enqueue_style('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css');
			wp_enqueue_style('jquery-ui', CAVIAR_DIR_URI.'css/jekui.css');
		}

		public function caviar_enqueue_admin_scripts(){
			wp_register_script( 'radiotabs-admin-js' , CAVIAR_DIR_URI. '/js/caviar-radio-tabs.js', array('jquery'), null, true);
			wp_register_script( 'chosen'             , CAVIAR_BOWER . '/chosen/chosen.jquery.min.js', array('jquery'), null, true );
			wp_register_script( 'caviar-admin-js'    , CAVIAR_DIR_URI. '/js/caviar-admin-scripts.js', array('jquery', 'radiotabs-admin-js', 'wp-color-picker', 'chosen'), null, true);
			
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('caviar-admin-js');
		}

		public function caviar_add_color_picker( $hook ) {
			if( is_admin() ) { 
			// Add the color picker css file       
				wp_enqueue_style( 'wp-color-picker' ); 

	    		// Include our custom jQuery file with WordPress Color Picker dependency
				// wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
			}
		}

		public function each_repeater($label, $id, $name, $value, $fields){
			$opt = array();
			$counter = 0;
			$control_label;

			if(is_array($value) && count($value) > 0) {
				$repeaterOrder = array();

				foreach($value as $num => $val) {
				 	$repeaterOrder[$num] = $val['repeaterOrder'];

					$opt[] = "<div class='repeatingSection repeater_wrapper' data-counter='".$counter."'>".
						"<label class='repeater-title control-label widefat' id='".$id."' for='".$id."'>".$label." ".$counter."</label>".
						"<div class='accordion-content'>".
			 				$this->each_repeater_fields($id, $name, $val, $fields, $counter).
			 				"<a href='#' class='button button-secondary button-large deleteField'>".esc_html__("Delete" , "caviar")."</a>".
			 			"</div>".
			 			$this->text('', $id.'['.$counter.'][repeaterOrder]', array('type' => 'hidden' , 'name' => $name.'['.$counter.'][repeaterOrder]', 'class' => 'widefat repeaterOrder', 'echo' => false, 'value' => $val['repeaterOrder'])).
		 			"</div>";
		 			$counter++;
				}
				
				/* Order repeater by $repeaterOrder value */
				array_multisort($repeaterOrder, SORT_ASC, $value);

				return implode(" ", $opt);
			} 
		}

		public function each_repeater_fields($id, $name, $value, $fields, $counter){
			$opt = array();

			foreach($fields as $key => $set) {
				$defaults	= array(
					'title'		=> esc_html__("Title", "caviar"),
					'options'	=> array(),
					'args'		=> array(),
					'type'		=> 'text',
					'taxonomy'	=> 'category',
				);

				$set 	= wp_parse_args( $set, $defaults );
				$type 	= $set['type'];

				$field_name = $name.'['.$counter.']'.'['.$key.']';
				$basicField = Basic_Fields::getInstance();

				switch($type) :
					case 'text'		:
					case 'textarea'	:  $opt[] = $basicField->$type($set['title'], $id, array("echo" => false, "class" => "widefat repeatedField", "value" => $value[$key], "name" => $field_name));
					  break;
				 	case 'upload'   :  $opt[] = $this->$type($set['title'], $counter, array("echo" => false, "class" => "widefat repeatedField", "value" => $value[$key], "name" => $field_name, 'data_parent' => $id), null);
				 		break;
				 	case 'radioimage' :
				 	case 'radiopill' : $opt[] = $this->$type($set['title'], $id, array("echo" => false, "class" => "widefat repeatedField", "value" => $value[$key], "name" => $field_name), $set['options']);
				 		break; 
				 	case 'select' :
				 	case 'checkbox' :
				 	case 'radio'   :  $opt[] = $basicField->$type($set['title'], $id, array("echo" => false, "class" => "widefat repeatedField", "value" => $value[$key], "name" => $field_name), $set['options']);
				 		break;
				endswitch;
			}

			return implode(" ", $opt);
		}

		/**
		 * WordPress Editor
		 * 
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args  Field options
		 * @return string        Field markup
		 */
		public function editor( $title, $id, $args = array(), $settings = array()){
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Validation for every control attributes must have value */
			// $control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, "name='$name'", 'name="'.$id.'"');
			$control_class       = self::must_exists( $class, "class='$class'", "class='widefat'");
			$control_type        = self::must_exists( $type, "type='$type'", "type='text'");
			$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );

			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label;

			/* Echo field or return the markup */
			if( $echo === false){
				return $input.
				wp_editor( $value, $id, $settings ).

				/* Print control info text */
				$control_info.

				/* Print markup after control*/
				$after_control;
			} 
			else {
				echo $input;
				wp_editor( $value, $id, $settings ).

				/* Print control info text */
				$control_info.

				/* Print markup after control*/
				$after_control;
			}
			
		}

		/**
		 * Return radio pills loop
		 * @param  [type] $control_name [description]
		 * @param  [type] $options      [description]
		 * @param  [type] $value        [description]
		 * @return [type]               [description]
		 */
		public static function each_pill($control_name, $options, $value, $control_attr){
			$opt = array();
			if( count( $options ) > 0) {
				foreach($options as $key => $radio_label) {
					$checked 	= ($key == $value) ? "checked='checked'" : "";

					$opt[] = "<label class='tab-label'>
						<input id='$key' type='radio' $control_name value='$key' $checked $control_attr/>
						<div class='checkable-item' id='$key'>$radio_label</div>
					</label>";
				}
			} 

			return implode(' ', $opt);
		}

		/**
		 * Return radio images loop
		 * @param  [type] $control_name [description]
		 * @param  [type] $options      [description]
		 * @param  [type] $value        [description]
		 * @return [type]               [description]
		 */
		public static function each_image($control_name, $options, $value, $control_attr){
			$opt = array();
			if( count( $options ) > 0) {
				foreach($options as $key => $radio_label) {
					$checked 	= ($key == $value) ? "checked='checked'" : "";

					$opt[] = "<label class='tab-label'>
						<input id='$key' type='radio' $control_name value='$key' $checked $control_attr/>
						<div class='selected-element'>
							<img class='image-selected $id' src='$radio_label' alt='$key' id='$key'/>
						</div>
					</label>";
				}
			} 

			return implode(' ', $opt);
		}

		/**
		 * Generate selectable Radio Pill
		 * @param  [type] $title   [description]
		 * @param  [type] $id      [description]
		 * @param  array  $args    [description]
		 * @param  array  $options [description]
		 * @return [type]          [description]
		 */
		public function radiopill($title, $id, $args = array(), $options = array()) {
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, 'name="'.$name.'"', 'name="'.$id.'"');
			$control_value       = self::must_exists( $value, "value='$value'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label' for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );
			$control_attr        = self::each_attr($attr);

			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label.

			"<div class='radio-tabs radio-only $class' $control_id>
				<div class='checkable-element clearfix radio-pills'>".

					self::each_pill($control_name, $options, $value, $control_attr).

			"	</div>
			</div>".

			/* Print control info text */
			$control_info.

			/* Print markup after control*/
			$after_control;

			/* Echo field or return the markup */
			if( $echo === false){
				return $input;
			} 
			else {
				echo $input;
			}
		}

		/**
		 * Generate selectable Radio Image
		 * @param  [type] $title   [description]
		 * @param  [type] $id      [description]
		 * @param  array  $args    [description]
		 * @param  array  $options [description]
		 * @return [type]          [description]
		 */
		public function radioimage($title, $id, $args = array(), $options = array()) {
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, 'name="'.$name.'"', 'name="'.$id.'"');
			$control_value       = self::must_exists( $value, "value='$value'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label' for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );
			$control_attr        = self::each_attr($attr);

			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label.

			"<div class='radio-tabs radio-images radio-only $class' $control_id>
				<div class='checkable-element clearfix radio-pills'>".

					self::each_image($control_name, $options, $value, $control_attr).

			"	</div>
			</div>".

			/* Print control info text */
			$control_info.

			/* Print markup after control*/
			$after_control;

			/* Echo field or return the markup */
			if( $echo === false){
				return $input;
			} 
			else {
				echo $input;
			}
		}

		/**
		 * Generate color picker control
		 *
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args field options
		 * @return string       field markup
		 */
		public function colorpicker( $title, $id, $args = array() ){
			/* Add color picker specific class*/
			$args['class'] = $args['class'].' wp-color-picker';
			$input = parent::text($title, $id, $args);

			/* Echo field or return the markup */
			if( $echo === false){
				return $input;
			} 
			else {
				echo $input;
			}	
		}

		/**
		 * Generate taxonomy control
		 *
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args field options
		 * @return string       field markup
		 */
		public function taxonomy( $title, $id, $args = array(), $taxonomy, $tax_args = array()){
			$terms 		= get_terms( ($taxonomy ? $taxonomy : 'category'), $tax_args );
			$options 	= array();

			if( !empty($terms) && !is_wp_error($terms)) :
				foreach ( $terms as $term ) :
					$options[$term->term_id] = $term->name;
				endforeach;
			endif;

			/* Create taxonomy with specific field, default select field*/	
			if( $args['type'] ) {	
				$input = parent::$args['type']($title, $id, $args, $options);
			} 
			else {
				$input = parent::select($title, $id, $args, $options);
			}
			

			/* Echo field or return the markup */
			if( $echo === false){
				return $input;
			} 
			else {
				echo $input;
			}	
		}

		/**
		 * Generate Upload Image Field
		 *
		 * @param  string $title Field label
		 * @param string $id    Field id
		 * @param  array  $args field options
		 * @return string       field markup
		 */
		public function upload( $title, $id, $args = array() ){
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, "name='$name'", 'name="'.$id.'"');
			$control_parent		 = $data_parent;
			$control_type        = self::must_exists( $type, "type='$type'", "type='text'");
			$control_value       = self::must_exists( $value, "value='$value'", '');
			$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );

			$thumb = wp_get_attachment_image_src( $value, 'thumbnail' );
			$default_image       = ( $default_image == '' || is_null( $default_image ) || empty( $default_image ) ? get_template_directory_uri().'/vendor/caviar/images/upload-icon-large.png' :  $default_image );
			$srcValue = ( $value !== '' )  ? $value : $default_image;
			$txtUrlValue = ( $thumb !== false) ? $thumb[0] : $value;
			

			// Localize the script with new data
			$translation_array = array(
				'some_string' => esc_html__( 'Some string to translate', 'plugin-domain' ),
				'a_value' => '10',
				'upid' => $id,
			);
			wp_localize_script( 'caviar-admin-js', 'object_name', $translation_array );
		
			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label.

			"<div id='$id' class='uploadImage upload-controls $class'>".
				"<div class='upload-wrapper'>".
					"<figure class='upload-preview column'>".
						"<section class='upload-button-group clearfix'>".
							"<a class='button uploadSingleImage upImage-$id u-pull-left' href='#' title='".esc_html__( 'Upload', 'caviar' )."' data-target='$id' data-parent='$control_parent' data-size='medium'><i class='fa fa-cloud-upload pr-small'></i> ".esc_html__( 'Upload', 'caviar' )."</a>".
							"<a class='button clearSingleImage $id u-pull-left' data-parent='$control_parent'  href='#' title='".esc_html__( 'Remove', 'caviar' )."' data-target='$id'><i class='fa fa-eraser pr-small'></i> ".esc_html__( 'Remove', 'caviar' )."</a>".
						"</section>".
						// Use Image between manually inputted to input url or selected from media library
						(($thumb == false) ? "<img id='image-$id' class='thumb-preview' src='$srcValue' data-placeimg='$default_image' alt='thumby'>" : "<img id='image-$id' class='thumb-preview' src='$thumb[0]' data-placeimg='$default_image' alt='thumbx'>").
					"</figure>".
					"<div class='column'>".
						"<input type='url' class='value-hidden image-url widefat mb-small' id='imageUrl-$id' $control_name  value='".$txtUrlValue."' data-target='$id' $control_placeholder/>".
							/* Print control info text */
						$control_info.
					"</div>".
				"</div>".
			"</div>".

			/* Print markup after control*/
			$after_control;

			/* Echo field or return the markup */
			if( $echo === false){
				return $input;
			} 
			else {
				echo $input;
			}	
		}
		
		/**
		 * Repeatable Field
		 *
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args field options
		 * @return string       field markup
		 */
		public function repeaterField( $title, $id, $args = array(), $fields = array()){
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, "name='$name'", 'name="'.$id.'"');
			$control_class       = self::must_exists( $class, "class='$class'", "class='widefat'");
			$control_type        = self::must_exists( $type, "type='$type'", "type='text'");
			$control_value       = self::must_exists( $value, "value='$value'", '');
			$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label  main-label' for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );

			/* Print markup before control*/
			echo $before_control;

			/* Print label before control */
			echo $control_label;

			wp_enqueue_style('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css');
			
			echo "<div id='caviar-".$id."' class='repeater-field dynamicAccordion-".$id."' data-id='".$id."' data-name='".$name."' data-fields='".json_encode($fields)."' data-fields-count='".count($value)."'>";
	 		echo self::each_repeater($title, $id, $name, $value, $fields).
	 		 	'<div class="widget-separator"> <span id="'.$id.'-clone"></span> </div>';
		 	echo "</div>";
		 	echo "<div class='formRowRepeatingSection'>
	 			<a href='#' class='button button-primary button-large addField'>".esc_html__('Add Field' , 'caviar')."</a>
	 		</div>";
		 	

			/* Print control info text */
			echo $control_info;

			/* Print markup after control*/
			echo $after_control;

			// /* Echo field or return the markup */
			// if( $echo === false){
			// 	return $input;
			// } 
			// else {
			// 	echo $input;
			// }	
		}

	}

	Field_Controls::getInstance();
}
?>