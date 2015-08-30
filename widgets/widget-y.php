<?php
/**
 * Adds TMD_Radio_Player.
 */
class TMD_Radio_Player extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'tmd_radio_player', // Base ID
            __('Dynamic buster', 'text_domain'), // Name
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

        $features = isset( $instance['features'] ) ? $instance['features'] : array();

        // Your code here

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
        else {
            $title = __( 'Radio Player', 'text_domain' );
        };

        $options  = array(
            'title' => array(
              'title' => 'Feature',
              'type'  => 'text',
              ),
            'price' => array(
              'title' => 'Price',
              'type'  => 'text',
            ),
            'picture' => array(
              'title' => 'picture',
              'type'  => 'upload',
            )  
        );

        $id               = $this->get_field_id('features');
        $name             = $this->get_field_name('features');
        $value_features   = $instance['features'];
        $counter          = 0;
        // var_dump($value_features);

        ?>
        <div class="repeater_wrapper <?php echo $id; ?>">
          <?php
          for ($i = 0; $i < count($value_features); $i++) {?>
            <br>
            <button class="button btnDelete-<?php echo $id; ?>"><span class="dashicons dashicons-no"></span></button>
            <button class="button btnMove-<?php echo $id; ?>"><span class="dashicons dashicons-editor-expand"></span></button> 
            <br>

            <span class="control-label">Title</span>
            <input type="text" class="widefat" name="<?php echo $name.'['.$counter.'][title]'; ?>" value="<?php echo $value_features[$i]['title']?>"> 

            <span class="control-label">Price</span>
            <input type="text" class="widefat" name="<?php echo $name.'['.$counter.'][price]'; ?>" value="<?php echo $value_features[$i]['price']?>"> 

            <span class="control-label">Detail</span>
            <div id='uploadImage <?php echo $id; ?>' class="uploadImage">
              <section class='upload-button-group clearfix'> 
                <a class='button uploadSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( ' Upload ', 'caviar ' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-cloud-upload pr-small'></i> <?php _e( 'Upload', 'caviar' ); ?></a>  
                <a class='button clearSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( ' Remove ', 'caviar ' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-eraser pr-small'></i> <?php _e( 'Remove', 'caviar' ); ?></a> 
              </section>
              <input type="url" class="widefat" name="<?php echo $name.'['.$counter.'][picture]'; ?>" value="<?php echo $value_features[$i]['picture']?>"> 
            </div>

          <?php 
            ++$counter; 
          }

          echo '<br>';  
          echo '<span id="'.$id.'-clone"></span>';
          echo '<input class="button '.$id.'-add button-primary button-large addField" type="button" value="' . __( 'Add Field', 'caviar' ) . '" id="add_field" />';
          ?>
    
        </div>

        <script type="text/javascript">
          jQuery(document).ready(function($){
            var fieldname = <?php echo json_encode( $name ) ?>;
            var fieldnum = <?php echo json_encode( $counter-1 ) ?>;
            var count = fieldnum;

            function addField(){
              var arrFields = <?php echo json_encode($options); ?>;
              var arrHTML = new Array();

              $('.addField').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                  url: "<?php echo admin_url('admin-ajax.php'); ?>",
                  type: "POST",
                  data: {},
                  success : function(response){
                    $.each(arrFields, function(index, key){
                      // console.log(key['index']);
                      switch (key['type']){
                        // case 'upload':
                        case 'text':
                          $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <input type='text' name='"+fieldname+"["+(count+1)+"]["+index+"]' value='' class='widefat'>");
                        break;

                        case 'textarea':
                          $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <textarea name='"+fieldname+"["+(count+1)+"]["+index+"]' class='widefat'></textarea>");
                        break;

                        case 'upload':
                           $("#<?php echo $id;?>-clone").append("<span class='control-label'>"+key['title']+"</span> <div id='uploadImage <?php echo $id; ?>' class='uploadImage'> <section class='upload-button-group clearfix'> <a class='button uploadSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Upload', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-cloud-upload pr-small'></i> <?php _e( 'Upload', 'caviar' ); ?></a> <a class='button clearSingleImage <?php echo $id; ?> u-pull-left' href='#' title='<?php _e( 'Remove', 'caviar' ); ?>' data-target='<?php echo $id; ?>'><i class='fa fa-eraser pr-small'></i> <?php _e( 'Remove', 'caviar' ); ?></a> </section> <input type='url' class='value-hidden image-url widefat mb-small <?php echo $id; ?>' name='"+fieldname+"["+(count+1)+"]["+index+"]' value='' <?php echo $placeholder; ?>/></div>");
                        break;
                        default:
                        break;
                      }
                    });

                    count++;
                  }
                })
              });
            }

            function removeField(){
              jQuery('.btnDelete-<?php echo $id; ?>').on('click', function(e){
                e.preventDefault();
                jQuery(this).parent().remove();
              });
            }

            function uploadImage(){
              $('.uploadImage').each(function(index, element){
                var $upBtn = $(element).find('.uploadSingleImage');
                console.log(index);
                
                // $upBtn.on('click', function(){
                //   alert($(this).parent().next().attr('name'));
                // });
              });
              // $(document).on('click', '.uploadSingleImage', function (e) {
              //   e.preventDefault();
              //   var theTarget = jQuery(this).attr('data-target');

              //   var custom_uploader = wp.media({
              //     title: 'Get Image',
              //     button: {
              //       text: 'Use Image'
              //     },
              //       multiple: false // Set this to true to allow multiple files to be selected
              //     })
              //     .on('select', function () {
              //       var attachment = custom_uploader.state().get('selection').first().toJSON();

              //       jQuery('#' + theTarget).val(attachment.id);
              //       var divTarget = '#uploadImage-' + theTarget;

              //       if (jQuery(divTarget + ' img').length) {
              //         jQuery(divTarget + ' img').attr('src', attachment.url);
              //         jQuery('.image-url').val(attachment.url);
              //       } else {
              //         jQuery(divTarget).append("<img src='" + attachment.url + "' alt='thumb' title='thumb' />");
              //       }
              //     }).open();
              // });
            }

            function removeImage(){
              $('.clearSingleImage.<?php echo $id;?>').live('click', function (e) {
                e.preventDefault();
                var theTarget = jQuery(this).attr('data-target');
                var placeImg = jQuery('.thumb-preview').data('placeimg');

                confirmed = confirm("Are you sure want to remove the image?");

                if (confirmed) {
                  jQuery(this).parent().next().attr('src', placeImg);
                  jQuery(this).parent().parent().next().val('');
                }
              });
            }

            removeField();
            addField();
            uploadImage();
            removeImage();
          });
        </script>
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

        $instance['features'] = array();

        if ( isset( $new_instance['features'] ) )
        {
            foreach ( $new_instance['features'] as $feature )
            {
                if ( '' !== trim( $feature['title'] ) )
                    $instance['features'][] = $feature;
            }
        }

        return $instance;
    }

} // class TMD_Radio_Player

// register TMD_Radio_Player widget
function register_tmd_radio_player() {
    register_widget( 'TMD_Radio_Player' );
}
add_action( 'widgets_init', 'register_tmd_radio_player' );