<?php
/**
 * Display recent comments widget with more configurable control.
 */

class Epic_Base_Recent_Comments extends WP_Widget{
    //Init Widget
  public function __construct(){
    parent::__construct(
      'recent_comments',
      __('Recent Comments' , 'epic-base'),
      array('description' => __(' Display recent comments','epic-base'))
    );
  }

    // Out put Widget Option to the Back-end
  public function  form($instance) {
    $defautls = array(
      'title'          => __('Recent Comments', 'epic-base'),
      'comments_number'       => 5,
    );

    $instance = wp_parse_args((array) $instance, $defautls);
    ?>

      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'epic-base'); ?></label>
        <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('comments_number'); ?>"><?php _e('How many comment displayed?', 'epic-base'); ?></label>
        <input class="widefat" type="text" id="<?php echo $this->get_field_id('comments_number'); ?>" name="<?php echo $this->get_field_name('comments_number'); ?>" value="<?php echo esc_attr($instance['comments_number']); ?>"/>
      </p>

    <?php
  }

  //Process widget options for saving
  public function  update($new_instance, $old_instance) {
   $instance = $old_instance;

   $instance['title']                 = strip_tags($new_instance['title']);
   $instance['comments_number']       = strip_tags($new_instance['comments_number']);

   return $instance;
  }

    // Displays widget on the Front-end
  public function  widget($args, $instance) {
    extract($args);

    $title                 = apply_filters('widget-title', $instance['title']);
    $comments_number       = $instance['comments_number'];

    echo $before_widget;

    if($title){
      echo $before_title . $title . $after_title;
    }

    $args = array (
      'number'  => $comments_number,
      'status'  => 'approve',
    );
    ?>
    
    <ul class="recent-comments">

      <?php
        $comments = get_comments( $args );
        if(is_array($comments) && count($comments) > 0) :
         foreach($comments as $comment) :
          $id         = $comment->comment_post_ID;
          $auth       = $comment->comment_author;
          $title      = get_the_title($id);
          $content    = $comment->comment_content;
          $link       = get_permalink($id);
          $end_dotted = (strlen($content) > 80 ) ? '...' : ''; ?>

          <li>
            <figure class="featured-thumb pull-left">
              <?php echo get_avatar( $comment, 60 ); ?>
            </figure>

            <div class="rcomment pull-right">
              <b class="author-name"><a href="<?php echo $link;?>"><?php echo $auth;?></a></b>
              <p class="comment-excerpt"><?php echo substr($content, 0, 80); ?> <?php echo $end_dotted; ?></p>
            </div> 
          </li>

         <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <?php echo $after_widget;
  }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Epic_Base_Recent_Comments");' ) );

?>