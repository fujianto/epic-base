<?php

/* Display a single Image banner */

class Epic_Base_Test extends WP_Widget{
    //Init Widget
  public function __construct(){
    parent::__construct(
      'test',
      __('Test Widget ' , 'epic-base'),
      array('description' => __(' Display Banner Image','epic-base'))
    );
  }

    // Out put Widget Option to the Back-end
  public function  form($instance) {
    $defautls = array(
      'title'           => __('Banner', 'epic-base'),
      'feature_list'    => array(),
    );

    $instance = wp_parse_args((array) $instance, $defautls);

    $form_controls = new Field_Controls();
    $fieldx  = array(
        'name' => array(
            'title' => 'Name',
            'type'  => 'text',
        ),
        'gender' => array(
            'title' => 'Feature',
            'type'  => 'radio',
            'options' => array(
                '1' => 'Male',
                '2' => 'Female',
            ),
        ),
    );
    $form_controls->text( __('Title', 'epic-base'),  $this->get_field_id('title'), array('class' => 'widefat', 'name' => $this->get_field_name('title'), 'value' => esc_attr($instance['title']) ));  
    $form_controls->repeaterField('Personal data', $this->get_field_id('feature_list'), array('name' => $this->get_field_name('feature_list'), 'value' => $instance['feature_list']), $fieldx);
  }

  //Process widget options for saving
  public function  update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title']  = strip_tags($new_instance['title']);

    if ( isset( $new_instance['feature_list'] ) ) {
        foreach ( $new_instance['feature_list'] as $list ) {
                $instance['feature_list'][] = $list;
        }
    }

   return $instance;
  }

    // Displays widget on the Front-end
  public function  widget($args, $instance) {
    extract($args);

    $title = apply_filters('widget-title', $instance['title']);
    $feature_list      = $instance['feature_list'];

    echo $before_widget;

    if($title){
      echo $before_title . $title . $after_title;
    } 

    echo $after_widget;
  }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Epic_Base_Test");' ) );

?>