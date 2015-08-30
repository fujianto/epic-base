<?php
/**
 * Adds Dynamic_Tester.
 */
class Dynamic_Tester extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
      parent::__construct(
            'dynamic_tester', // Base ID
            __('Dynamic Tester', 'text_domain'), // Name
            array( 'description' => __( 'Menampilkan radio player', 'text_domain' ), ) // Args
            );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

      $title = apply_filters( 'widget-title', $instance['title'] );

      echo $args['before_widget'];

      if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

      $stream_sources = isset( $instance['stream_sources'] ) ? $instance['stream_sources'] : array();

      echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
      if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
      }

      $options  = array(
        'title' => array(
          'title' => 'Feature',
          'type'  => 'text',
          ),
        'price' => array(
          'title' => 'Price',
          'type'  => 'textarea',
        ),
        'info' => array(
          'title' => 'Info',
          'type'  => 'upload',
        )  
      );

      $form_control = new Form_Control();
      ?>
      
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Judul:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>

      <?php 
      $stream_sources = isset( $instance['stream_sources'] ) ? $instance['stream_sources'] : array();
      var_dump($stream_sources);
      $form_control->repeaterField('Theme Feature', $this->get_field_id( 'stream_sources' ), array('name' => $this->get_field_name( 'stream_sources'), 'value' => $stream_sources), $options);
      ?>
      <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
      $instance = $old_instance;

      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

      $instance['stream_sources'] = array();

      if ( isset( $new_instance['stream_sources'] ) )
      {
        foreach ( $new_instance['stream_sources'] as $stream_source )
        {
          if ( '' !== trim( $stream_source['title'] ) )
            $instance['stream_sources'][] = $stream_source;
        }
      }

      return $instance;
    }

} // class Dynamic_Tester

// register Dynamic_Tester widget
function register_dynamic_tester() {
  register_widget( 'Dynamic_Tester' );
}
add_action( 'widgets_init', 'register_dynamic_tester' );