<?php
/**
 * The header for our theme.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hvac' ); ?></a>

	<?php
	// Header content is managed under Theme Options > Header (ACF). Fall back to
	// sensible defaults so the header renders even if ACF is inactive.
	$hvac_acf            = function_exists( 'get_field' );
	$hvac_show_topbar    = $hvac_acf ? get_field( 'header_show_topbar', 'option' ) : true;
	$hvac_topbar_message = $hvac_acf ? get_field( 'header_topbar_message', 'option' ) : __( 'HVAC Services Available Across the USA', 'hvac' );
	$hvac_topbar_rating  = $hvac_acf ? get_field( 'header_topbar_rating', 'option' ) : __( '4.9 Google Rating', 'hvac' );
	$hvac_topbar_hl      = $hvac_acf ? get_field( 'header_topbar_highlight', 'option' ) : __( '24/7 Emergency', 'hvac' );
	$hvac_header_phone   = $hvac_acf ? get_field( 'header_phone', 'option' ) : '(512) 555-0199';
	$hvac_cta_label      = $hvac_acf ? get_field( 'header_cta_label', 'option' ) : __( 'Call', 'hvac' );

	// Rating star icon (repeated five times below).
	$hvac_star_svg = '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.72289 1.33875C6.74845 1.2871 6.78794 1.24363 6.8369 1.21323C6.88586 1.18284 6.94234 1.16673 6.99997 1.16673C7.0576 1.16673 7.11408 1.18284 7.16304 1.21323C7.212 1.24363 7.25149 1.2871 7.27705 1.33875L8.62455 4.06817C8.71332 4.24781 8.84436 4.40324 9.00642 4.5211C9.16848 4.63896 9.35671 4.71573 9.55497 4.74483L12.5685 5.18583C12.6256 5.19411 12.6792 5.21819 12.7233 5.25537C12.7675 5.29254 12.8003 5.34132 12.8181 5.39619C12.836 5.45105 12.8381 5.50982 12.8243 5.56584C12.8105 5.62186 12.7813 5.67289 12.74 5.71317L10.5606 7.83533C10.4169 7.97539 10.3094 8.14828 10.2473 8.33912C10.1852 8.52995 10.1704 8.73302 10.2042 8.93083L10.7187 11.9292C10.7288 11.9862 10.7226 12.045 10.7009 12.0987C10.6792 12.1525 10.6428 12.199 10.596 12.2331C10.5491 12.2671 10.4935 12.2873 10.4357 12.2914C10.3779 12.2954 10.3201 12.2831 10.269 12.2558L7.57514 10.8395C7.39764 10.7463 7.20016 10.6976 6.99968 10.6976C6.7992 10.6976 6.60172 10.7463 6.42422 10.8395L3.73097 12.2558C3.67983 12.2829 3.62212 12.2951 3.5644 12.291C3.50668 12.2869 3.45127 12.2667 3.40448 12.2326C3.35768 12.1986 3.32137 12.1521 3.29969 12.0985C3.278 12.0448 3.27181 11.9862 3.2818 11.9292L3.79572 8.93142C3.82967 8.73351 3.81496 8.53032 3.75287 8.33936C3.69078 8.14841 3.58316 7.97542 3.4393 7.83533L1.25997 5.71375C1.21832 5.67352 1.1888 5.6224 1.17478 5.56621C1.16077 5.51002 1.16281 5.45103 1.18068 5.39594C1.19856 5.34086 1.23154 5.29191 1.27588 5.25466C1.32022 5.21741 1.37413 5.19336 1.43147 5.18525L4.44439 4.74483C4.64287 4.71596 4.83136 4.63928 4.99365 4.52141C5.15593 4.40353 5.28713 4.24799 5.37597 4.06817L6.72289 1.33875Z" fill="#FD7933" stroke="#FD7933" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/></svg>';
	?>

	<header id="masthead" class="site-header">

		<?php if ( $hvac_show_topbar && ( $hvac_topbar_message || $hvac_topbar_rating || $hvac_topbar_hl ) ) : ?>
			<div class="site-topbar">
				<div class="container site-topbar-inner">
					<?php if ( $hvac_topbar_message ) : ?>
						<p class="topbar-message">
							<span class="topbar-message-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
							</span>
							<?php echo esc_html( $hvac_topbar_message ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $hvac_topbar_rating || $hvac_topbar_hl ) : ?>
						<div class="topbar-meta">
							<?php if ( $hvac_topbar_rating ) : ?>
								<span class="topbar-rating">
									<span class="topbar-stars" aria-hidden="true"><?php echo str_repeat( $hvac_star_svg, 5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. ?></span>
									<?php echo esc_html( $hvac_topbar_rating ); ?>
								</span>
							<?php endif; ?>
							<?php if ( $hvac_topbar_hl ) : ?>
								<span class="topbar-highlight"><?php echo esc_html( $hvac_topbar_hl ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="container site-header-inner">

			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<div class="site-title-wrap">
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
						<?php
						$hvac_description = get_bloginfo( 'description', 'display' );
						if ( $hvac_description || is_customize_preview() ) :
							?>
							<p class="site-description"><?php echo $hvac_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div>
					<?php
				}
				?>
			</div>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'hvac' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>

			<div class="header-actions">
				<?php if ( $hvac_header_phone ) : ?>
					<?php $hvac_tel = preg_replace( '/[^0-9+]/', '', $hvac_header_phone ); ?>
					<a class="header-cta" href="tel:<?php echo esc_attr( $hvac_tel ); ?>">
						<span class="header-cta-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
						</span>
						<span class="header-cta-text"><?php echo esc_html( trim( $hvac_cta_label . ' ' . $hvac_header_phone ) ); ?></span>
					</a>
				<?php endif; ?>

				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'hvac' ); ?></span>
					<span class="menu-toggle-icon" aria-hidden="true"></span>
				</button>
			</div>

		</div>
	</header>

	<div id="content" class="site-content">
