<div class="flex-row">
	<div class="flex-col col-3 col-branding" <?php hybrid_attr( 'branding' ); ?>>

		<div class="branding-wrapper">
			<?php if ( get_custom_logo() == "" || get_custom_logo() == null  ) : // If custom logo exist. ?>

				<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

					<?php hybrid_site_title(); ?>
					<?php hybrid_site_description(); ?>

				<?php endif; // End check for header text. ?>
				
			<?php else: ?>
				
				<?php if ( function_exists( 'the_custom_logo' ) ): ?>
					<?php the_custom_logo(); ?>
				<?php endif; // End check for header text. ?>

			<?php endif; // End check for header text. ?>
		</div>		

	</div>
	
	<div class="flex-col col-7 col-header-right ta-right">
		<?php do_action('epic_base_header_right');?>
	</div>
	<!-- End right header section -->
</div>