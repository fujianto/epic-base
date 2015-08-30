<?php

/* Display a single Image banner */

class Epic_Base_Banner_Image extends WP_Widget{
    //Init Widget
  public function __construct(){
    parent::__construct(
      'banner_image',
      __('Epic Base: Banner Image ' , 'epic-base'),
      array('description' => __(' Display Banner Image','epic-base'))
    );
  }

    // Out put Widget Option to the Back-end
  public function  form($instance) {
    $defautls = array(
      'title'     => __('Banner', 'epic-base'),
      'ad_img'    => '',
      'ad_link'   => home_url(),
      'ad_width'  => '100%',
      'ad_height' => 'auto'
    );

    $instance = wp_parse_args((array) $instance, $defautls);

    $form_controls = new Form_Control();
    $form_controls->text( __('Banner Title', 'epic-base'),  $this->get_field_id('title'), array('class' => 'widefat', 'name' => $this->get_field_name('title'), 'value' => esc_attr($instance['title']) ));  
    
    $counter = 0;
    $form_controls->upload( __('Image Banner' , 'epic-base'), $this->get_field_id('ad_img'), 
      array(
        'class'       => 'upload-controls single previewImage', 
        'name'        => $this->get_field_name('ad_img'), 
        'value'       => esc_attr($instance['ad_img']),
        'placeholder' => __('Image URL' , 'epic-base'),
        'info'        => __('Upload image from Media library or enter image URL to the URL textbox above.' , 'epic-base')
        ),
      null
      );

    $form_controls->text( __('Banner URL?', 'epic-base'), $this->get_field_id('ad_link'), array('class' => 'widefat', 'name' => $this->get_field_name('ad_link'), 'value' => esc_attr($instance['ad_link']) )); 

    $form_controls->text( __('Banner Width?', 'epic-base'), $this->get_field_id('ad_width'), array('class' => 'widefat', 'name' => $this->get_field_name('ad_width'), 'value' => esc_attr($instance['ad_width']) )); 

    $form_controls->text( __('Banner Height?', 'epic-base'), $this->get_field_id('ad_height'), array('class' => 'widefat', 'name' => $this->get_field_name('ad_height'), 'value' => esc_attr($instance['ad_height']) )); 

    $id = explode("-", $this->get_field_id("widget_id"));
    $widget_id =  $id[1] . "-" . $id[2];
  }

  //Process widget options for saving
  public function  update($new_instance, $old_instance) {
   $instance = $old_instance;

   $instance['title']      = strip_tags($new_instance['title']);
   $instance['ad_img']     = strip_tags($new_instance['ad_img']);
   $instance['ad_link']    = strip_tags($new_instance['ad_link']);
   $instance['ad_width']   = strip_tags($new_instance['ad_width']);
   $instance['ad_height']  = strip_tags($new_instance['ad_height']);

   return $instance;
  }

    // Displays widget on the Front-end
  public function  widget($args, $instance) {
    extract($args);

    $title = apply_filters('widget-title', $instance['title']);

    $ad_img      = $instance['ad_img'];
    $ad_link     = $instance['ad_link'];
    $ad_width    = $instance['ad_width'];
    $ad_height   = $instance['ad_height'];
    $ad_img      = $instance['ad_img'];

    echo $before_widget;

    if($title){
      echo $before_title . $title . $after_title;
    } 

    if( $ad_img ): ?>

      <figure>
        <a href="<?php echo $ad_link; ?>" title="<?php echo $title; ?>">
          <img src="<?php echo $ad_img; ?>" alt="<?php echo $title; ?>" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" style="width: <?php echo $ad_width; ?>; height: <?php echo $ad_height; ?>;" />
        </a>
      </figure>

    <?php endif; ?>

    <?php echo $after_widget;
  }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Epic_Base_Banner_Image");' ) );

?>