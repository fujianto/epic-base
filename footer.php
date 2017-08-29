		</div><!-- #main -->
		
		
		<footer <?php hybrid_attr( 'footer' ); ?>>

			<?php tha_footer_top(); ?>
			
			<?php hybrid_get_sidebar( 'subsidiary' ); // Loads the sidebar/subsidiary.php template.                           ?>
			
			<?php tha_footer_bottom(); ?>
		</footer><!-- #footer -->
		
		<?php tha_footer_after(); ?>
	</div><!-- #container -->
	
	<?php tha_body_bottom(); ?>
	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer.                           ?>

</body>
</html>
