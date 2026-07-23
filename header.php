<?php

/**
 * The header for our theme.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">

		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'hvac'); ?></a>

		<?php
		// Header content is managed under Theme Options > Header (ACF). Fall back to
		// sensible Figma defaults so the header renders even if ACF is inactive.
		$hvac_acf            = function_exists('get_field');

		// Top utility bar.
		$hvac_show_topbar    = $hvac_acf ? get_field('header_show_topbar', 'option') : true;
		$hvac_topbar_message = $hvac_acf ? get_field('header_topbar_message', 'option') : __('Get a discount of up to 50% for use our service this month!', 'hvac');
		$hvac_topbar_email   = $hvac_acf ? get_field('header_topbar_email', 'option') : 'support@hvacreliablepro.com';
		$hvac_topbar_phone   = $hvac_acf ? get_field('header_topbar_phone', 'option') : '+62 864 6444 2222';
		$hvac_topbar_socials = $hvac_acf ? get_field('header_topbar_socials', 'option') : array();

		// Main navigation actions.
		$hvac_call_label     = $hvac_acf ? get_field('header_hours_label', 'option') : __('Open Hours', 'hvac');
		$hvac_header_hours   = $hvac_acf ? get_field('header_hvac_hours', 'option') : 'Monday-Saturday 9AM - 6PM';
		$hvac_book_label     = $hvac_acf ? get_field('header_book_label', 'option') : __('Book Now', 'hvac');
		$hvac_book_link      = $hvac_acf ? get_field('header_book_link', 'option') : '';

		if (! is_array($hvac_topbar_socials)) {
			$hvac_topbar_socials = array();
		}
		?>

		<header id="masthead" class="site-header<?php echo ( function_exists( 'hvac_is_transparent_header' ) && hvac_is_transparent_header() ) ? ' is-transparent' : ''; ?>">

			<?php if ($hvac_show_topbar && ($hvac_topbar_message || $hvac_topbar_email || $hvac_topbar_phone || $hvac_topbar_socials)) : ?>
				<div class="site-topbar">
					<div class="container site-topbar-inner">
						<?php if ($hvac_topbar_message) : ?>
							<p class="topbar-message">
								<span class="topbar-message-icon" aria-hidden="true">
									<svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12.1289 0.351562L16.5938 4.88672C18.457 6.75 18.457 9.73828 16.5938 11.6016L12.6562 15.5742C12.3398 15.9258 11.8125 15.9258 11.4609 15.6094C11.1445 15.2578 11.1445 14.7305 11.4609 14.4141L15.3984 10.4062C16.5938 9.21094 16.5938 7.27734 15.3984 6.08203L10.8984 1.51172C10.582 1.19531 10.582 0.667969 10.9336 0.316406C11.25 0 11.7773 0 12.1289 0.351562ZM0 7.03125V1.75781C0 0.84375 0.738281 0.0703125 1.6875 0.0703125H6.92578C7.52344 0.0703125 8.08594 0.316406 8.50781 0.738281L14.4141 6.64453C15.293 7.52344 15.293 8.96484 14.4141 9.84375L9.73828 14.5195C8.85938 15.3984 7.41797 15.3984 6.53906 14.5195L0.632812 8.61328C0.210938 8.19141 0 7.62891 0 7.03125ZM5.0625 4.00781C5.0625 3.41016 4.53516 2.88281 3.9375 2.88281C3.30469 2.88281 2.8125 3.41016 2.8125 4.00781C2.8125 4.64062 3.30469 5.13281 3.9375 5.13281C4.53516 5.13281 5.0625 4.64062 5.0625 4.00781Z" fill="#FAFAFA" />
									</svg>

								</span>
								<?php echo esc_html($hvac_topbar_message); ?>
							</p>
						<?php endif; ?>

						<?php if ($hvac_topbar_email || $hvac_topbar_phone || $hvac_topbar_socials) : ?>
							<div class="topbar-meta">

								<?php if (! empty($hvac_topbar_socials)) : ?>
									<ul class="topbar-socials">
										<?php foreach ($hvac_topbar_socials as $hvac_social) : ?>
											<?php
											$hvac_social_link = isset($hvac_social['link']) ? $hvac_social['link'] : array();
											if (empty($hvac_social_link['url'])) {
												continue;
											}
											$hvac_icon          = hvac_social_icon($hvac_social['network']);
											$hvac_social_target = ! empty($hvac_social_link['target']) ? $hvac_social_link['target'] : '_blank';
											?>
											<li>
												<a href="<?php echo esc_url($hvac_social_link['url']); ?>" <?php echo hvac_link_target_attrs($hvac_social_target); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled attribute string. 
																											?> aria-label="<?php echo esc_attr(ucfirst((string) $hvac_social['network'])); ?>">
													<?php echo $hvac_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. 
													?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>

								<?php if (($hvac_topbar_email || $hvac_topbar_phone) && ! empty($hvac_topbar_socials)) : ?>
									<span class="topbar-divider" aria-hidden="true"></span>
								<?php endif; ?>

								<?php if ($hvac_topbar_email || $hvac_topbar_phone) : ?>
									<div class="topbar-contact">
										<?php if ($hvac_topbar_email) : ?>
											<a href="mailto:<?php echo esc_attr($hvac_topbar_email); ?>">
												<svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.6875 0H16.3125C17.2266 0 18 0.773438 18 1.6875C18 2.25 17.7188 2.74219 17.2969 3.05859L9.66797 8.78906C9.24609 9.10547 8.71875 9.10547 8.29688 8.78906L0.667969 3.05859C0.246094 2.74219 0 2.25 0 1.6875C0 0.773438 0.738281 0 1.6875 0ZM0 3.9375L7.62891 9.70312C8.4375 10.3008 9.52734 10.3008 10.3359 9.70312L18 3.9375V11.25C18 12.5156 16.9805 13.5 15.75 13.5H2.25C0.984375 13.5 0 12.5156 0 11.25V3.9375Z" fill="#FAFAFA" />
												</svg>

												<?php echo esc_html($hvac_topbar_email); ?>
											</a>
										<?php endif; ?>
										<?php if ($hvac_topbar_phone) : ?>
											<?php $hvac_tb_tel = preg_replace('/[^0-9+]/', '', $hvac_topbar_phone); ?>
											<a href="tel:<?php echo esc_attr($hvac_tb_tel); ?>">
												<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M5.76562 0.984375L7.17188 4.35938C7.41797 4.92188 7.27734 5.58984 6.78516 5.97656L5.0625 7.41797C6.22266 9.87891 8.22656 11.8828 10.6875 13.043L12.1289 11.3203C12.5156 10.8281 13.1836 10.6875 13.7461 10.9336L17.1211 12.3398C17.7891 12.5859 18.1055 13.3242 17.9297 13.9922L17.0859 17.0859C16.9102 17.6836 16.3828 18.1055 15.75 18.1055C7.03125 18.1055 0 11.0742 0 2.35547C0 1.72266 0.421875 1.19531 1.01953 1.01953L4.11328 0.175781C4.78125 0 5.51953 0.316406 5.76562 0.984375Z" fill="#FAFAFA" />
												</svg>

												<?php echo esc_html($hvac_topbar_phone); ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="container site-header-inner">

				<div class="site-branding">
					<?php
					if (has_custom_logo()) {
						the_custom_logo();
					} else {
					?>
						<div class="site-title-wrap">
							<?php if (is_front_page() && is_home()) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
							<?php endif; ?>
							<?php
							$hvac_description = get_bloginfo('description', 'display');
							if ($hvac_description || is_customize_preview()) :
							?>
								<p class="site-description"><?php echo $hvac_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
															?></p>
							<?php endif; ?>
						</div>
					<?php
					}
					?>
				</div>

				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary', 'hvac'); ?>">
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
					<?php if ($hvac_header_hours) : ?>
						<div class="header-open-hours">

							<?php if ($hvac_call_label) : ?>
								<h5 class="header-call-label"><?php echo esc_html($hvac_call_label); ?></h5>
							<?php endif; ?>
							<h6 class="header-call-number"><?php echo esc_html($hvac_header_hours); ?></h6>
						</div>
					<?php endif; ?>

					<?php
					if ($hvac_book_label) :
						$hvac_book_url    = ! empty($hvac_book_link['url']) ? $hvac_book_link['url'] : '#';
						$hvac_book_target = ! empty($hvac_book_link['target']) ? $hvac_book_link['target'] : '';
					?>
						<a class="header-book" href="<?php echo esc_url($hvac_book_url); ?>" <?php echo hvac_link_target_attrs($hvac_book_target); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled attribute string. 
																								?>>
							<?php echo esc_html($hvac_book_label); ?>
						</a>
					<?php endif; ?>

					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="screen-reader-text"><?php esc_html_e('Menu', 'hvac'); ?></span>
						<span class="menu-toggle-icon" aria-hidden="true"></span>
					</button>
				</div>

			</div>
		</header>

		<div id="content" class="site-content">