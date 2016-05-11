<?php 

/**
 * Pagination for Post / Page Archive
 * @return [type] [description]
 */
function epic_base_main_pagination(){
	$args = array (
		'prev_text'          => __('&laquo'),
		'next_text'          => __('&raquo'),
		'type'               => 'plain',
	); 

	echo '<nav class="pagination-wrapper">';
	echo paginate_links( $args );
	echo '</nav>';
}

/**
 * Content column width based on theme layout options
 * 
 * @return string entry wrapper class
 */
function epic_base_entry_col_width(){
	$class = '';
	/* If one column layout choosen, .col-md-12 will be added to entry-wrapper */
	if ('1c' === hybrid_get_theme_layout() ) {
		return 'col-md-10 col-md-offset-1 col-sm-12';
	} else{
		return 'col-md-8';
	}
}

/**
 * Set custom comment form arguments 
 * 
 * @since 1.0
 * @return array of custom comment form arguments
 */
function epic_base_comments_args(){
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$valid_email = '';

	$comments_args = array(
		'id_submit'=>'btn-comment-submit',
		'name_submit' => 'submit',
		'comment_notes_after' => '',
   	'fields' => apply_filters('comment_form_default_fields',  array( 
     		'author' =>
	      '<div class="form-group">' .
	      	'<label for="name" class="label_title">' . __( 'Name', 'epic-base' ) . '' . ( $req ? '*' : '' ) . '</label> 
	      	 <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="'. __('Fill your name ' , 'epic-base') .' ' . ( $req ? __('(required)', 'epic-base')  : '' ) . '" size="30"' . $aria_req . ' />
	      </div>',

      	'email' =>
	      '<div class="form-group">' .
	      	'<label for="email" class="label_title">' . __( 'Email', 'epic-base' ) . ' ' . ( $req ? '*' : '' ) . '</label>
	      	 <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="'.__('Fill your email' , 'epic-base').' ' . ( $req ? __('(required)', 'epic-base')  : '' ) . '" size="30"' . $aria_req . ' />
	      </div>',

      	'url' =>
	      '<div class="form-group">' .
	      	'<label for="url" class="label_title">' . __( 'Website', 'epic-base' ) . '</label>
	      	<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  placeholder="'.__('Fill your Website url' , 'epic-base').'" size="30" />
	      </div>'
   	)),
        // redefine your own textarea (the comment body)
    'comment_field' => 
    	'<div class="form-group"> 
  			<label for="message" class="label_title">' . __( 'Comments', 'epic-base' ) . '</label>
  			<textarea id="comment" name="comment" aria-required="true" cols="30" rows="10"></textarea> 
    	</div>'
	
	);

	return $comments_args;
}

/**
 * Get theme entry byline markup
 * @return Void
 */
function epic_base_entry_byline(){?>
	<div class="entry-byline">
		<?php// hybrid_post_format_link(); ?>
		
		<span <?php hybrid_attr( 'entry-author' ); ?>><?php esc_html_e( "By", "epic-base" ); ?> <?php the_author_posts_link(); ?></span>
		<time <?php hybrid_attr( 'entry-published' ); ?>><?php esc_html_e( "On", "epic-base" ); ?> <?php echo get_the_date(); ?></time>
		<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ). ' Comment', '% Comments', 'comments-link', '' ); ?>
		<?php edit_post_link(); ?>
	</div><!-- .entry-byline -->
<?php }

/**
 * [epic_base_entry_footer description]
 * @return Void
 */
function epic_base_entry_footer(){?>
	<footer class="entry-footer">
		<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => esc_html__( 'Posted in %s', 'epic-base' ) ) ); ?>
		<?php hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'text' => esc_html__( 'Tagged %s', 'epic-base' ), 'before' => '<br />' ) ); ?>
	</footer><!-- .entry-footer -->
<?php }

