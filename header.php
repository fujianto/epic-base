<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>

<head>
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

<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div id="container">

		<div class="skip-link">
			<a href="#content" class="sr-only screen-reader-text"><?php _e( 'Skip to content', 'epic-base' ); ?></a>
		</div><!-- .skip-link -->

		<header <?php hybrid_attr( 'header' ); ?>>
			<div class="row">
				<div class="col-md-6" <?php hybrid_attr( 'branding' ); ?>>
					<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

						<?php hybrid_site_title(); ?>
						<?php hybrid_site_description(); ?>

					<?php endif; // End check for header text. ?>
				</div>
				<!-- End branding -->
				<div class="col-md-6 share-section">
					<ul class="social">
						<li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
					</ul>
				</div>
				<!-- End share section -->
			</div>
		</header><!-- #header -->
		
		<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>
		
		<div class="wide-banner">
			<?php if ( get_header_image() && !display_header_text() ) : // If there's a header image but no header text. ?>

				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>

			<?php elseif ( get_header_image() ) : // If there's a header image. ?>

				<img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />

			<?php endif; // End check for header image. ?>
		</div>
		<!-- /.wide-banner -->

		<div id="main" class="main">
