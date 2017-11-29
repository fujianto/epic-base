<?php
/**
 * Display recent posts widget with more configurable control.
 */

class Epic_Base_Recent_Posts extends WP_Widget {
	// Init Widget
	public function __construct() {
		parent::__construct(
			'recent_posts',
			esc_html__( 'Epic Base Recent Posts ' , 'epic-base' ),
			array(
				'description' => esc_html__( ' Display recent posts','epic-base' ),
			)
		);
	}

	// Out put Widget Option to the Back-end
	public function form( $instance ) {
		$defautls = array(
			'title'          => esc_html__( 'Recent Posts', 'epic-base' ),
			'posts_number'   => absint( 5 ),
		);

		$instance = wp_parse_args( (array) $instance, $defautls );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'epic-base' ); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo sanitize_text_field( esc_attr( $instance['title'] ) ); ?>"/>
	  </p>

	  <p>
		<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php _e( 'How many Post?', 'epic-base' ); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo absint( esc_attr( $instance['posts_number'] ) ); ?>"/>
	  </p>
		<?php
	}

	// Process widget options for saving
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']          = sanitize_title( strip_tags( $new_instance['title'] ) );
		$instance['posts_number']   = sanitize_text_field( absint( strip_tags( $new_instance['posts_number'] ) ) );

		return $instance;
	}

	// Displays widget on the Front-end
	public function widget( $args, $instance ) {
		extract( $args );

		$posts_number   = $instance['posts_number'];
		echo $before_widget;

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$args = array(
			'posts_per_page'  => absint( $posts_number ),
			'post__not_in'    => get_option( 'sticky_posts' ),
		);
		?>

			<ul class="recent-posts">
		<?php
		// query_posts($args);
		$wp_query = new WP_Query();
		$wp_query->query( $args );

		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) :
				$wp_query->the_post();

				$thumb   = get_post_thumbnail_id();
				$img_url = esc_url( wp_get_attachment_url( $thumb,'full' ) ); // get img URL
				$image   = get_the_post_thumbnail(); // resize & crop img
			?>

						 <li>
				<?php if ( $image !== '' ) : ?>
				<figure class="featured-thumb pull-left">
					<?php
					get_the_image(
						array(
							'width' => esc_attr( '80px' ),
							'height' => esc_attr( '80px' ),
						)
					);
?>
				</figure>
				<?php endif; ?>

			   <a class="author-name" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			   <p class="title-content"><time><?php the_time( 'F d, Y' ); ?></time></p>
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

function epc_base_register_recent_posts_widget() {
	register_widget( 'Epic_Base_Recent_Posts' );
}

add_action( 'widgets_init', 'epc_base_register_recent_posts_widget' );

?>
