<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<div class="row">
		
		<div class="entry-wrapper <?php echo epic_base_entry_col_width(); ?> first">
			
			<?php if ( ! is_front_page()) : // If Not viewing on Frontpage ?>

				<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>

			<?php endif; // End check for Not viewing on Frontpage. ?>


			<?php if ( ! is_front_page() && hybrid_is_plural() ) : // If viewing a multi-post page ?>

				<?php locate_template( array( 'misc/archive-header.php' ), true ); // Loads the misc/archive-header.php template. ?>

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

				<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>
		
			<?php else : // If no posts were found. ?>

				<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

			<?php endif; // End check for posts. ?>
		</div>

		<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
		<!-- /.entry-wrapper -->
	</div>
</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>