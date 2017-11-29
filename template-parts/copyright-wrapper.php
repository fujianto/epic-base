<div class="copyright-wrapper">
	<div class="row">
		<p class="credit">
			<?php printf(
				/* Translators: 1 is current year, 2 is site name/link, 3 is WordPress name/link, and 4 is theme name/link. */
				esc_html__( 'Copyright &#169; %1$s %2$s. Powered by %3$s and %4$s.', 'epic-base' ),
				date_i18n( 'Y' ), hybrid_get_site_link(), hybrid_get_wp_link(), hybrid_get_theme_link()
			); ?>
		</p><!-- .credit -->
	</div>
</div>
<!-- /.copyright-wrapper -->
