<?php
/**
 * Display recent posts widget with more configurable control.
 */

class Epic_Base_Recent_Posts extends WP_Widget{
    //Init Widget
  public function __construct(){
    parent::__construct(
      'recent_posts',
      __('Recent Posts ' , 'epic-base'),
      array('description' => __(' Display recent posts','epic-base'))
    );
  }

    // Out put Widget Option to the Back-end
  public function  form($instance) {
    $defautls = array(
      'title'          => __('Recent Posts', 'epic-base'),
      'posts_number'   => 5,
      'posts_category' => '',
      'posts_order'    => 'ASC',
      'posts_orderby'  => 'Name',
    );

    $instance = wp_parse_args((array) $instance, $defautls);

    $form_controls = new Field_Controls();
    
    /* Title */
    $form_controls->text( __('Title', 'epic-base'), $this->get_field_id('title'),  array('class' => 'widefat', 'name' => $this->get_field_name('title'), 'value' => esc_attr($instance['title'])) ); 

    /* Post Count */
    $form_controls->text(  __('How many Post?', 'epic-base'), $this->get_field_id('posts_number'), array( 'class' => 'widefat', 'name' => $this->get_field_name('posts_number'), 'value' => esc_attr($instance['posts_number']) )); 

    /* Category */
    // $form_controls->taxonomy( __('Which category?', 'epic-base'), $this->get_field_id('posts_category'), array('name' => $this->get_field_name('posts_category'), 'class' => 'widefat', 'value' => esc_attr($instance['posts_category']) ), 'category', '' );

    // $form_controls->radio( __('Posts Order?', 'epic-base'), $this->get_field_id('posts_order'),
    //   /* Select html attributes*/
    //   array(
    //     'type' => 'pills',
    //     'class' => 'widefat', 
    //     'name'  => $this->get_field_name('posts_order'),
    //     'value' => esc_attr($instance['posts_order'])
    //     ),
    //   /* The Options / value of select control*/
    //   array(
    //     'asc'  => __('Ascending' , 'epic-base'),
    //     'desc' => __('Descending' , 'epic-base')
    // )); 

    // $form_controls->select( __('Order by?', 'epic-base'),  $this->get_field_id('posts_orderby'),
    //   /* Select html attributes*/
    //   array(
    //     'multiple' => false,
    //     'class' => 'widefat', 
    //     'name'  => $this->get_field_name('posts_orderby'),
    //     'value' => esc_attr($instance['posts_orderby'])
    //     ),
    //   /* The Options / value of select control*/
    //   array(
    //    'name'       => __('Name' , 'epic-base'), 
    //    'count'      => __('Count' , 'epic-base'), 
    //    'id'         => __('ID' , 'epic-base'), 
    //    'slug'       => __('Slug' , 'epic-base'), 
    //    'term_group' => __('Term Group' , 'epic-base')
    //  )); 
  }

  //Process widget options for saving
  public function  update($new_instance, $old_instance) {
   $instance = $old_instance;

   $instance['title']          = strip_tags($new_instance['title']);
   $instance['posts_number']   = strip_tags($new_instance['posts_number']);
   // $instance['posts_category'] = strip_tags($new_instance['posts_category']);
   // $instance['posts_order']    = strip_tags($new_instance['posts_order']);
   // $instance['posts_orderby']  = strip_tags($new_instance['posts_orderby']);
  
   return $instance;
  }

    // Displays widget on the Front-end
  public function  widget($args, $instance) {
    extract($args);

    $title = apply_filters('widget-title', $instance['title']);

    $posts_number   = $instance['posts_number'];
    // $posts_category = $instance['posts_category'];
    // $posts_order    = $instance['posts_order'];
    // $posts_orderby  = $instance['posts_orderby'];

    echo $before_widget;

    if($title){
      echo $before_title . $title . $after_title;
    }

    $args = array (
      // 'cat'             => $posts_category,
      // 'order'           => $posts_order,
      // 'orderby'         => $posts_orderby,
      'posts_per_page'  => $posts_number,
      'post__not_in'    => get_option('sticky_posts'),
    );
    ?>
    
    <ul class="recent-posts">
      <?php
        // query_posts($args);
        $wp_query = new WP_Query(); 
        $wp_query->query($args);

          if ($wp_query->have_posts ()) :
            while ($wp_query->have_posts ()) : $wp_query->the_post();

              $thumb   = get_post_thumbnail_id();
              $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
              $image   =  get_the_post_thumbnail(); //resize & crop img
            ?>
             
            <li>
              <?php if ( $image !== '' ) :?>
                <figure class="featured-thumb pull-left">
                  <?php get_the_image(array('width' => '80px', 'height' => '80px')); ?>
                </figure>
              <?php endif; ?>

               <a class="author-name" href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
               <p class="title-content"><time><?php the_time('F d, Y') ?></time></p>
           </li>

            <?php
              endwhile;
            endif;
          wp_reset_postdata();
          ?>
    </ul>

    <?php echo $after_widget;
  }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Epic_Base_Recent_Posts");' ) );

?>