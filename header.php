<!DOCTYPE html>
<?php tha_html_before(); ?>

<html <?php language_attributes( 'html' ); ?>>

<head>

<?php tha_head_top(); ?>

<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>

<?php tha_head_bottom(); ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>
	
	<?php tha_body_top(); ?>

	<div id="container" class="container-fluid">
		
		<?php tha_header_before(); ?>
		
		<header <?php hybrid_attr( 'header' ); ?>>

			<?php tha_header_top(); ?>

			<?php do_action('epic_base_header_content'); ?>

			<?php tha_header_bottom(); ?>

		</header><!-- #header -->
		
		<?php tha_header_after(); ?>
		
		<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>

		<div id="main" class="main">