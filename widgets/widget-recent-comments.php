<?php
/**
 * Display recent comments widget with more configurable control.
 */

class Epic_Base_Recent_Comments extends WP_Widget{
    //Init Widget
  public function __construct(){
    parent::__construct(
      'recent_comments',
      __('Epic Base: Recent Comments' , 'epic-base'),
      array('description' => __(' Display recent comments','epic-base'))
    );
  }

    // Out put Widget Option to the Back-end
  public function  form($instance) {
    $defautls = array(
      'title'          => __('Recent Comments', 'epic-base'),
      'comments_number'       => 5,
      'comments_order'        => 'ASC',
      'comments_show_avatar'  => true,
    );

    $instance = wp_parse_args((array) $instance, $defautls);
    ?>
    
      <?php 
        $form_controls = new Form_Control();
        $id    = $this->get_field_id('title');
        $name  = $this->get_field_name('title');
        $value = esc_attr($instance['title']);
        $form_controls->text( __('Title', 'epic-base'), $id,  array('class' => 'widefat', 'name' => $name, 'value' => $value) ); 
      ?>

      <?php 
        $form_controls->text(  __('How many comment displayed?', 'epic-base'), $this->get_field_id('comments_number'), array( 'class' => 'widefat', 'name' => $this->get_field_name('comments_number'), 'value' => esc_attr($instance['comments_number']) )); 
      ?>

      <?php 
        $id            = $this->get_field_id('comments_order');
        $name          = $this->get_field_name('comments_order');
        $selected      = esc_attr($instance['comments_order']);

        $form_controls->select( __('Comment Order?', 'epic-base'), $id,
          /* Select html attributes*/
          array(
            'multiple' => false,
            'class' => 'widefat', 
            'name'  => $name,
            'value' => $selected
          ),
          /* The Options / value of select control*/
          array(
            'asc'  => __('Ascending' , 'epic-base'),
            'desc' => __('Descending' , 'epic-base')
        )); 
      ?>

      <?php 
        $id            = $this->get_field_id('comments_show_avatar');
        $name          = $this->get_field_name('comments_show_avatar');
        $selected      = esc_attr($instance['comments_show_avatar']);

        $form_controls->select( __('Show comment author avatar?', 'epic-base'), $id,
          /* Select html attributes*/
          array(
            'multiple' => false,
            'class'    => 'widefat', 
            'name'     => $name,
            'value'    => $selected
          ),
          /* The Options / value of select control*/
          array(
           'show' => __('Show' , 'epic-base'), 
           'hide' => __('Hide' , 'epic-base'), 
        )); 
      ?>

    <?php
  }

  //Process widget options for saving
  public function  update($new_instance, $old_instance) {
   $instance = $old_instance;

   $instance['title']                 = strip_tags($new_instance['title']);
   $instance['comments_number']       = strip_tags($new_instance['comments_number']);
   $instance['comments_order']        = strip_tags($new_instance['comments_order']);
   $instance['comments_show_avatar']  = strip_tags($new_instance['comments_show_avatar']);

   return $instance;
  }

    // Displays widget on the Front-end
  public function  widget($args, $instance) {
    extract($args);

    $title                 = apply_filters('widget-title', $instance['title']);
    $comments_number       = $instance['comments_number'];
    $comments_order        = $instance['comments_order'];
    $comments_show_avatar  = $instance['comments_show_avatar'];

    echo $before_widget;

    if($title){
      echo $before_title . $title . $after_title;
    }

    $args = array (
      'order'    > $comments_order,
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
            <?php if($comments_show_avatar === 'show' ) : ?>
              <figure class="featured-thumb pull-left">
                <?php echo get_avatar( $comment, 60 ); ?>
              </figure>
            <?php endif; ?>

            <div class="rcomment pull-right <?php echo ( ($comments_show_avatar === 'hide' ) ? 'u-full-width' : '' ); ?>">
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