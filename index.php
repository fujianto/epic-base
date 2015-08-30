<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<div class="row">
		<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>
		<div class="entry-wrapper <?php echo epic_base_entry_col_width(); ?> first">

			<?php if ( !is_front_page() && !is_singular() && !is_404() ) : // If viewing a multi-post page ?>

				<?php locate_template( array( 'misc/loop-meta.php' ), true ); // Loads the misc/loop-meta.php template. ?>

			<?php endif; // End check for multi-post page. ?>

			<?php if ( have_posts() ) : // Checks if any posts were found. ?>

				<?php while ( have_posts() ) : // Begins the loop through found posts. ?>

					<?php the_post(); // Loads the post data. ?>

					<?php hybrid_get_content_template(); // Loads the content/*.php template. ?>

					<?php if ( is_singular() ) : // If viewing a single post/page/CPT. ?>

						<?php comments_template( '', true ); // Loads the comments.php template. ?>

					<?php endif; // End check for single post. ?>

				<?php endwhile; // End found posts loop. ?>
				
				<!-- Pagination for older / newer post -->

				<!-- EXPERIMENT! REMOVE WHEN FINISH! -->
				<div class="load-hey">
					<div class="delay-hey" style="display: none;">Loading...</div>
				</div>
				<a href="#" data-url="<?php echo home_url(); ?>" class="load-more">Load More</a>
				<script>
				jQuery(document).ready(function($){
					var startPage = 1;
					$('.load-more').on('click', function(e){
						e.preventDefault();
						jQuery.ajax({
							type: 'GET',
							url: "<?php echo home_url(); ?>/page/"+parseInt(startPage+1),
							data: {},
							beforeSend: function(response){
								jQuery('.delay-hey').show();
							},
							success: function(response){
								jQuery('.delay-hey').hide();
								jQuery(response).find('article.post').each(function(){
									$('.load-hey').append($(this).html());
								});
							}
						});
						startPage++;
					});
				});
				</script>
				<?php //locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>
		
			<?php else : // If no posts were found. ?>

				<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

			<?php endif; // End check for posts. ?>
		</div>

		<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
		<!-- /.entry-wrapper -->
	</div>
</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>