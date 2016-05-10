<?php
if( ! class_exists('Basic_Fields')) {

	class Basic_Fields{
		public $default;
		public $id;
		public $title;
		public $taxonomy;
		public $options = array();
		public $args 		= array(
			'name'           => '',
			'echo'			 => true,
			'value'          => '',
			'class'			 => '',
			'placeholder'	 => '',
			'type'			 => 'text',
			'info'			 => '',
			'help'		     => NULL,
			'hidden'		 => false,
			'preview'	     => true,
			'featured'	     => false,
			'tab'			 => false,
			'multiple'		 => false,
			'hide_empty'	 => false,
			'required'		 => false,
			'error'			 => '',
			'before_control' => '',
			'after_control'  => '',
			'attr' 	         => array(),
		);

		public function __construct(){}

		/**
		 * Check if variable not empty or null
		 * @param  [type] $var     validated variable
		 * @param  [type] $content return value
		 * @param  [type] $contentEmpty custom return value when not exist
		 * @return string / empty          
		 */
		public static function must_exists( $var, $content, $contentEmpty){
			if ($var === '' || empty($var) || !isset($var) || is_null($var)) {
				if($contentEmpty === '' || empty($contentEmpty) || !isset($contentEmpty) || is_null($contentEmpty)){	
					$content = '';
				} else {
					$content = $contentEmpty;	
				}
			} 

			return $content;
		}

		/**
		 * Return array of field attribute into string 
		 * @param  array $attr Field attribute. e.g: data-validate, data-* etc.
		 * @return String      [data-validate = 'true' data-* = 'data'
		 */
		public static function each_attr( $attr ){
			$control_attr        = array();

			if( is_array($attr) && count($attr) > 0) {
				foreach ($attr as $attrName => $attrValue) {
					$control_attr[] = $attrName.' = '.'"'.$attrValue.'"';
				}

				$field_attr = implode(' ', $control_attr);
			}

			return $field_attr;
		}

		/**
		 * Return select option loop
		 * @param  array $options array of select option
		 * @return String         option markup
		 */
		public static function each_opt($options, $multiple, $value){
			$opt = array();

			foreach ($options as $key => $detail) {
				$selected 	= ( ($multiple && is_array($value) && in_array($key,$value)) || (!is_array($value) && $key == $value)
							) ? "selected='selected'" : "";
				$opt[] = '<option value="'.$key.'" '.$selected.'>'.$detail.'</option> ';
			}

			return implode(' ', $opt);
		}

		/**
		 * Return select option loop with optgroup
		 * @param  array $options array of select option
		 * @return String         option markup
		 */
		public static function each_optGroup($options, $multiple, $value){
			$opt = array();
			$val = array();

			foreach($options as $key => $detail) {
				if(is_array($detail) && count($detail) > 0) {
					$opt[] = '<optgroup label="'.$key.'">'.
					$val = self::each_opt($detail, $multiple, $value)
					.'</optgroup>';
				}
			}
		
			return implode(' ', $opt);
		} 

		/**
		 * Determine which option should be used, single or with optgroup
		 * @param  [type] $options  [description]
		 * @param  [type] $multiple [description]
		 * @param  [type] $value    [description]
		 * @return [type]           [description]
		 */
		public static function each_options($options, $multiple, $value){
			$bool = false;
			foreach ($options as $key => $detail) {
				if(is_array($detail) && count($detail) > 0) {
					$bool = true;
				}
			}

			if($bool === true){
				return self::each_optGroup($options, $multiple, $value);
			} else {
				return self::each_opt($options, $multiple, $value);
			}

		}

		/**
		 * Return checkbox Loop
		 * @param  [type] $options [description]
		 * @param  [type] $checked [description]
		 * @param  [type] $value   [description]
		 * @return [type]          [description]
		 */
		public static function each_checkbox($control_name, $options, $value, $control_attr){
			$opt = array();

			foreach ($options as $key => $detail) {
				$checked 	= ( (is_array($value) && in_array($key, $value)) || (!is_array($value) && $key == $value)
							) ? "checked='checked'" : "";
				$opt[] = "<input id='$key' type='checkbox' $control_name value='$key' $checked $control_attr/>".
						"<label class='radio-label' for='$key'>$detail</label>";
			}

			return implode(' ', $opt);
		}

		/**
		 * Return radio loop
		 * @param  [type] $control_name [description]
		 * @param  [type] $options      [description]
		 * @param  [type] $value        [description]
		 * @return [type]               [description]
		 */
		public static function each_radio($control_name, $options, $value, $control_attr){
			$opt = array();
			if( count( $options ) > 0) {
				foreach($options as $key => $radio_label) {
					$checked 	= ($key == $value) ? "checked='checked'" : "";

					$opt[] = "<input id='$key' type='radio' $control_name value='$key' $checked $control_attr/>".
					"<label class='radio-label' for='$key'>$radio_label</label>";
				}
			} 

			return implode(' ', $opt);
		}
		

		/**
		 * Generate input type text / email / url 
		 *
		 * @param  string $title Field label
		 * @param string $id    Field id
		 * @param  array  $args field options
		 * @return string       field markup
		 */
		public function text( $title, $id, $args = array() ){
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
			$control_label       = self::must_exists( $title, "<label class='control-label' for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );
			$control_attr        = self::each_attr($attr);

			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label.

			"<input $control_type $control_id $control_name $control_value $control_class $control_placeholder $control_attr /> ".

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
		 * Text Area Field
		 * 
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args  Field options
		 * @return string        Field markup
		 */
		public function textarea( $title, $id, $args = array() ){
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
			$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'", '');
			$control_label       = self::must_exists( $title, "<label class='control-label' for='$id'>$title</label>", '');
			$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>", '');
			$before_control 	 = self::must_exists( $before_control, $before_control,  "<div class='widget-separator'>" );
			$after_control 	 	 = self::must_exists( $after_control, $after_control,  "</div>" );
			$control_attr        = self::each_attr($attr);

			/* Print markup before control*/
			$input = $before_control.

			/* Print label before control */
			$control_label.

			"<textarea rows='5' cols='30' $control_id $control_name  $control_class $control_placeholder $control_attr> $value </textarea>".

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
		 * Select Field
		 * 
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args  Field options
		 * @param  array $options List of slect options
		 * @return string        Field markup
		 */
		public function select( $title, $id, $args = array(), $options = array()){
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Using single or multiple select type */
			$multiple	= ($multiple) ? "multiple='multiple'" : false;

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, ( $multiple == false ? 'name="'.$name.'"' :  'name="'.$name.'[]"'), 'name="'.$id.'"');
			$control_class       = self::must_exists( $class, "class='$class'", "class='widefat'");
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

			"<select $control_class $control_name  $control_id  $multiple $control_placeholder $control_attr>".
				self::each_options($options, $multiple, $value).
			"</select>".

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
		 * Checkbox Field
		 * 
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args  Field options
		 * @param  array $options List of slect options
		 * @return string        Field markup
		 */
		public function checkbox( $title, $id, $args = array(), $options = array()){
			$this->title = $title;
			$this->id    = $id;
			$this->args  = $args;

			/* Make $args array key into variable */
			extract($this->args);

			/* Using single or multiple select type */
			$multiple	= ($multiple) ? "multiple='multiple'" : false;

			/* Validation for every control attributes must have value */
			$control_id          = self::must_exists( $id, "id='$id'", '');
			$control_name        = self::must_exists( $name, 'name="'.$name.'[]"', 'name="'.$id.'[]"');
			$control_class       = self::must_exists( $class, "class='$class'", "class='widefat'");
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

			"<div class='checkbox-wrapper widefat $class' $control_id >".

			self::each_checkbox($control_name, $options, $value, $control_attr).

			"</div>".

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
		 * Radio Field
		 * 
		 * @param  string $title Field label
		 * @param  string $id    Field id
		 * @param  array  $args  Field options
		 * @param  array $options List of slect options
		 * @return string        Field markup
		 */
		public function radio( $title, $id, $args = array(), $options = array()){
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

			"<div class='radio-wrapper widefat $class' $control_id >".

			self::each_radio($control_name, $options, $value, $control_attr).

			"</div>".

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
	}

	$basicField = new Basic_Fields();
}
?>