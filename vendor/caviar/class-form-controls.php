	<?php

class Form_Control{
	public $default;
	public $id;
	public $title;
	public $taxonomy;
	public $options = array();
	public $args 		= array(
		'name'           => '',
		'value'          => '',
		'class'			     => '',
		'placeholder'	   => '',
		'type'			     => 'text',
		'info'			     => '',
		'help'		       => NULL,
		'hidden'		     => false,
		'preview'	       => true,
		'featured'	     => false,
		'tab'			       => false,
		'multiple'		   => false,
		'hide_empty'	   => false,
		'required'		   => false,
		'error'			     => '',
		'before_control' => '',
		'after_control'  => '',
	);

	public function __construct(){ }

	/**
	 * Check if variable not empty or null
	 * @param  [type] $var     [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public static function must_exists( $var, $content){
		if ($var === '' || empty($var) || !isset($var) || is_null($var)) {
			$content = '';
		} 

		return $content;
	}

	/**
	 * Generate input type text / email / url 
	 * @param  array  $args [description]
	 * @return [type]       [description]
	 */
	public function text( $title, $id, $args = array() ){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;

		/* Make $args array key into variable */
		extract($this->args);

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_type        = (($type === '' || empty($type) || !isset($type) || is_null($type)) ? "type='text'" : "type='$type'");
		$control_value       = self::must_exists( $value, "value='$value'");
		$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");

		/* Print label before control */
		echo $control_label;

		echo "<input $control_type $control_id $control_name $control_value $control_class $control_placeholder /> ";

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function textarea( $title, $id, $args = array()){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;

		/* Make $args array key into variable */
		extract($this->args);

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_value       = self::must_exists( $value, $value);
		$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");

		/* Print label before control */
		echo $control_label;

		echo "<textarea rows='10' cols='30' $control_id $control_name  $control_class $control_placeholder> $control_value </textarea>";
		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function select( $title, $id, $args = array(), $options = array()){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;
		/* Make $args array key input into variable */
		extract($this->args);

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_placeholder = self::must_exists( $placeholder, "data-placeholder='$placeholder'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");

		/* Using single or multiple select type */
		$multiple	= ($multiple) ? "multiple='multiple'" : false;

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Print label before control */
		echo $control_label;

		echo "<select $control_class $control_name  $control_id  $multiple $control_placeholder>";
			foreach($options as $key => $detail) {
				if(is_array($detail) && count($detail) > 0) {
					echo "<optgroup label='$key'>";

						foreach($detail as $keyy => $detaill) {
							$selected 	= ( ($multiple && is_array($value) &&  in_array($keyy,$value)) || (!is_array($value) && $keyy == $value)
							) ? "selected='selected'" : "";

							echo "<option value='$keyy' $selected>$detaill</option>";
						}

					echo "</optgroup>";
				} else {
					$selected 	= ( ($multiple && is_array($value) && in_array($key,$value)) || (!is_array($value) && $key == $value)
						) ? "selected='selected'" : "";
					echo "<option value='$key' $selected>$detail</option>";
				}
			}

		echo "</select>";

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function radio( $title, $id, $args = array(), $options = array()){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;
		/* Make $args array key input into variable */
		extract($this->args);

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");
		$control_value       = self::must_exists( $value, "value='$value'");

		/* Using single or multiple select type */
		$multiple	= ($multiple) ? "multiple='multiple'" : false;

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Print label before control */
		echo $control_label;

		if( $type === 'pills') {

			echo "
				<div class='radio-tabs radio-only $class' $control_id>
					<div class='checkable-element clearfix radio-pills'>";
						if( count( $options ) > 0) {
							foreach($options as $key => $radio_label) {
								$checked 	= ($key == $value) ? "checked='checked'" : "";
								echo "
									<label class='tab-label'>
										<input id='$key' type='radio' $control_name value='$key' $checked />
										<div class='checkable-item' id='$key'>$radio_label</div>
									</label>";
							}
						}
			echo "</div>
				</div>";

		} else if ( $type === 'images' ) {

			echo "
				<div class='radio-tabs radio-images radio-only $class' $control_id>
					<div class='checkable-element clearfix radio-pills'>";
						if( count( $options ) > 0) {
							foreach($options as $key => $radio_label) {
								$checked 	= ($key == $value) ? "checked='checked'" : "";
								echo "
									<label class='tab-label'>
										<input id='$key' type='radio' $control_name value='$key' $checked />
										<div class='selected-element'>
											<img class='image-selected $id' src='$radio_label' alt='$key' id='$key'/>
										</div>
									</label>";
							}
						}
			echo "</div>
				</div>";

		} else {

			echo "<div class='radio-wrapper widefat $class' $control_id >";

			if( count( $options ) > 0) {
				foreach($options as $key => $radio_label) {
					$checked 	= ($key == $value) ? "checked='checked'" : "";

					echo "<input id='$key' type='radio' $control_name value='$key' $checked />";
					echo "<label class='radio-label' for='$key'>$radio_label</label>";
				}
			} 

			echo "</div>";

		}

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function checkbox( $title, $id, $args = array(), $options = array()){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;
		/* Make $args array key input into variable */
		extract($this->args);

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");
		$control_value       = self::must_exists( $value, "value='$value'");

		/* Using single or multiple select type */
		$multiple	= ($multiple) ? "multiple='multiple'" : false;

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Print label before control */
		echo $control_label;

		echo "<div class='checkbox-wrapper widefat $class' $control_id >";

		if( count( $options ) > 0) {
			foreach($options as $key => $radio_label) {
				$checked 	= ($key == $value) ? "checked='checked'" : "";

				echo "<input id='$key' type='checkbox' $control_name value='$key' $checked />";
				echo "<label class='radio-label' for='$key'>$radio_label</label>";
			}
		} 

		echo "</div>";

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function colorpicker( $title, $id, $args = array() ){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;

		/* Make $args array key into variable */
		extract($this->args);

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='wp-color-picker $class'");
		$control_type        = self::must_exists( $type, "type='$type'");
		$control_value       = self::must_exists( $value, "value='$value'");
		$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");

		/* Print label before control */
		echo $control_label;

		echo "<input $control_type $control_id $control_name $control_value $control_class $control_placeholder /> ";

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function upload( $title, $id, $args = array(), $default_image){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;

		/* Make $args array key into variable */
		extract($this->args);

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_value       = self::must_exists( $value, "value='$value'");
		$control_placeholder = self::must_exists( $placeholder, "placeholder='$placeholder'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");
		$default_image       = ( $default_image === '' || is_null( $default_image ) || empty( $default_image ) ? get_template_directory_uri().'/vendor/caviar/images/upload-icon-large.png' :  $default_image );
		$widget_id =  $id[1] . "-" . $id[2];
	 	$counter = 0;

		/* Print label before control */
		echo $control_label;
		
		?>
		<div id='uploadImage <?php echo $id; ?>' <?php echo $control_class ?>>
			<figure class='upload-preview'>
				<section class='upload-button-group clearfix'>
					
					<a class='button uploadSingleImage-<?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Upload', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-cloud-upload pr-small'></i> <?php _e( 'Upload', 'caviar' ); ?></a>
					<a class='button clearSingleImage-<?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Remove', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-eraser pr-small'></i> <?php _e( 'Remove', 'caviar' ); ?></a>

				</section>
				<?php $thumb = wp_get_attachment_image_src( $value, 'thumbnail' ); ?>
				<?php if( $thumb === false) :  ?>	
					<img class='thumb-preview' src='<?php echo ( $value !== '' )  ? $value : $default_image; ?>' data-placeimg='<?php echo $default_image; ?>' alt='thumby'>
				<?php else : ?>
					<!-- Use images from Media libraray -->
					<img class='thumb-preview' src='<?php echo $thumb[0]; ?>' data-placeimg='<?php echo $default_image; ?>' alt='thumbx'>
				<?php endif; ?>

			</figure>
			
			<!-- If no thumbnail found, Use direct image path value from the url textbox. If no value found, set value empty  -->
			<input type='url' class='value-hidden image-url widefat mb-small' <?php echo $control_id; ?> <?php echo $control_name; ?>  value='<?php echo ( $thumb !== false) ? $thumb[0] : $value; ?>' <?php echo $control_placeholder; ?>/>
		</div>
		<?php 
		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}

	public function taxonomy( $title, $id, $args = array(), $taxonomy, $tax_args = array()){
		$this->title       = $title;
		$this->id          = $id;
		$this->taxonomy    = $taxonomy;
		$this->args        = $args;

		$terms 		= get_terms( $taxonomy, $tax_args );
		$options 	= array();

		if( !empty($terms) && !is_wp_error($terms)) :
	 	foreach ( $terms as $term ) :
	   		$options[$term->term_id] 	= $term->name;
	  endforeach;
		endif;

		if($args['type'] == 'radio') {
			$this->radio($title, $id, $args, $options);
		} 
		else if($args['type'] == 'checkbox') {
			$this->radio($title, $id, $args, $options);
		}
		else {
			$this->select($title, $id, $args, $options);
		}
	}

	public function repeaterField( $title, $id, $args = array(), $options = array()){
		$this->title = $title;
		$this->id    = $id;
		$this->args  = $args;
		$this->options  = $options;

		/* Make $args array key into variable */
		extract($this->args);

		/* Print markup before control*/
		echo ( ($before_control == '') ? "<div class='widget-separator'>" : $before_control );

		/* Validation for every control attributes must have value */
		$control_id          = self::must_exists( $id, "id='$id'");
		$control_name        = self::must_exists( $name, "name='$name'");
		$control_class       = self::must_exists( $class, "class='$class'");
		$control_label       = self::must_exists( $title, "<label class='control-label' $control_id for='$id'>$title</label>");
		$control_info        = self::must_exists( $info, "<span class='control-info'>$info</span>");
		$counter = 0;
		/* Print label before control */
		echo $control_label;

		// var_dump($value);
		$opt = $this->options;

		foreach ($opt as $opt_key => $opt_value) {
			$arr_key[] = $opt_key;
			$arr_value[] =$opt_value;
		}

		$field_number = count($opt);

		$this->dynamicField($id, $name, $value, $options);

		/* Print control info text */
		echo $control_info; 

		/* Print markup after control*/
		echo ( ($after_control == '') ? '</div>' : $after_control );
	}
	/* Icon Picker */

	/* Datepicker */

	public function dynamicField($id, $name, $value, $options){
		$counter = 0;
		$default_image       = ( $default_image === '' || is_null( $default_image ) || empty( $default_image ) ? get_template_directory_uri().'/vendor/caviar/images/upload-icon-large.png' :  $default_image );

		if(is_array($value) && count($value) > 0) {

			foreach($value as $num => $val) {
				$keyID 	= key($val);
				echo '<div class="repeater_wrapper '.$id.'">'; 
				echo '<button class="button btnDelete-'.$id.'"><span class="dashicons dashicons-no"></span></button>';
				echo '<button class="button btnMove-'.$id.'"><span class="dashicons dashicons-editor-expand"></span></button>';
					foreach($options as $key => $set) {
						$defaults	= array(
							'title'		=> __("Title", "caviar"),
							'options'	=> array(),
							'args'		=> array(),
							'type'		=> 'text',
							'taxonomy'	=> 'category',
						);

						$set 	= wp_parse_args( $set, $defaults );
						$type 	= $set['type'];
						$field_name = $name.'['.$counter.']'.'['.$key.']';
						switch($type) :
							case 'text'		:
							case 'textarea'	: $this->$type($set['title'], $id, array("class" => "widefat", "value" => $val[$key], "name" => $field_name));
							  break;
						 	case 'upload' :  $this->$type($set['title'], $counter, array("class" => "widefat", "value" => $val[$key], "name" => $field_name), null);
						 		break;
						endswitch;
					}
					
				echo '</div>';
				++$counter;
			} 
		}

		echo '<span id="'.$id.'-clone"></span>';
    echo '<input class="button '.$id.'-add button-primary button-large addField" type="button" value="' . __( 'Add Field', 'caviar' ) . '" id="add_field" />';
		?>
		<script type="text/javascript">
			// jQuery(document).ready(function($){
			// 	removeField();
			// 	addField();

			// 	function addField(){
			// 		var fieldname = <?php echo json_encode( $name ) ?>;
			// 		var fieldnum = <?php echo json_encode( $counter-1 ) ?>;
			// 		var count = fieldnum;
			// 		var arrFields = <?php echo json_encode($options); ?>;
			// 		var arrHTML = new Array();

			// 		$('.addField').on('click', function(e) {
			// 			e.preventDefault();

   //          $.ajax({
   //          	url: "<?php echo admin_url('admin-ajax.php'); ?>",
   //          	type: "POST",
   //          	data: {},
   //          	success : function(response){
	  //             $.each(arrFields, function(index, key){
	  //               // console.log(key['index']);
	  //               switch (key['type']){
	  //               	// case 'upload':
	  //                 case 'text':
	  //                   $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <input type='text' name='"+fieldname+"["+(count+1)+"]["+index+"]' value='' class='widefat'>");
	  //                 break;

	  //                 case 'textarea':
	  //                   $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <textarea name='"+fieldname+"["+(count+1)+"]["+index+"]' class='widefat'></textarea>");
	  //                 break;

	  //                 case 'upload':
	  //                 	 $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <div id='uploadImage <?php echo $id; ?>' <?php echo $class ?>> <figure class='upload-preview'> <section class='upload-button-group clearfix'> <a class='button uploadSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Upload', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-cloud-upload pr-small'></i> <?php _e( 'Upload', 'caviar' ); ?></a> <a class='button clearSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Remove', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-eraser pr-small'></i> <?php _e( 'Remove', 'caviar' ); ?></a> </section> <img src='<?php echo $default_image;?>' alt='default' /> </figure> <input type='url' class='value-hidden image-url widefat mb-small <?php echo $id; ?>' name='"+fieldname+"["+(count+1)+"]["+index+"]' value='' <?php echo $placeholder; ?>/></div>");
	  //                 break;
	  //                 default:
	  //                 break;
	  //               }
	  //             });

			// 					// console.log($('.uploadImage').find('.uploadSingleImage'));
			// 					// $.each('.uploadSingleImage', function(index, element){
			// 					// 	console.log(index);
			// 					// });

			// 					// $('body').on('click', '.uploadSingleImage', function(){
			// 					// 	alert($(this).text());
			// 					// });

			// 					$('.uploadImage').each(function(element, index){
			// 						console.log($(element).find('.uploadSingleImage'));
			// 						var el = 	$(element).find('.uploadSingleImage');

			// 						el.click(function(){
			// 							alert($(this));
			// 						});
			// 					});

			// 					$('body').on('click', '.uploadSingleImage', function(){
			// 						alert($(this).attr('class'));
			// 					});

	  //             count++;
   //          	}
   //          })
   //        });
			// 	}

			// 	function removeField(){
			// 		jQuery('.btnDelete-<?php echo $id; ?>').on('click', function(e){
			// 			e.preventDefault();
			// 			jQuery(this).parent().remove();
			// 		});
			// 	}
			// });
		</script>
		<?php 
	}

}

$form_controls = new Form_Control();