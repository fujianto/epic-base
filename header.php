<?php tha_html_before(); ?>

<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>

<head>
<?php tha_head_top(); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Favicon and App Icon -->
<!-- <link rel="shortcut icon" type="image/x-icon" href="" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="" /> -->

<!-- Mobile Meta -->
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="529">

<?php tha_head_bottom(); ?>
<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>
	
	<?php tha_body_top(); ?>

	<div id="container" class="container-fluid">

		<div class="skip-link">
			<a href="#content" class="sr-only screen-reader-text"><?php esc_html_e( 'Skip to content', 'epic-base' ); ?></a>
		</div><!-- .skip-link -->
		
		<?php tha_header_before(); ?>

		<header <?php hybrid_attr( 'header' ); ?>>
			<?php tha_header_top(); ?>

			<div class="row">
				<div class="col-md-4 col-sm-4" <?php hybrid_attr( 'branding' ); ?>>

					<div class="branding-wrapper">
						<?php if ( get_custom_logo() == "" || get_custom_logo() == null  ) : // If custom logo exist. ?>

							<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

								<?php hybrid_site_title(); ?>
								<?php hybrid_site_description(); ?>

							<?php endif; // End check for header text. ?>
						
						<?php else: ?>
							
							<?php if ( function_exists( 'the_custom_logo' ) ): ?>
								<?php echo the_custom_logo(); ?>
							<?php endif; // End check for header text. ?>

						<?php endif; // End check for header text. ?>
					</div>		

				</div>
				<!-- End branding -->
				
				<?php do_action('epic_base_header_right');?>
				<!-- End right header section -->
			</div>

			<?php tha_header_bottom(); ?>
		</header><!-- #header -->
		
		<?php tha_header_after(); ?>
		
		<div class="wide-banner">
			<?php if ( get_header_image() && !display_header_text() ) : // If there's a header image but no header text. ?>

				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>

			<?php elseif ( get_header_image() ) : // If there's a header image. ?>
				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
					<img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
				</a>

			<?php endif; // End check for header image. ?>
		</div>
		<!-- /.wide-banner -->
		
		<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>

		<div id="main" class="main">
