<?php

/**
 * Template Name: Home Page
 *
 * The landing page (Figma: Landing page UI V2 Final). Every section is editable
 * via the "Home Page" field group (Secure Custom Fields), with Figma-matching
 * fallbacks so the page renders fully before any content is entered.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

/**
 * Target/rel attributes for an ACF link "target" value.
 */
if (! function_exists('hvac_link_target_attrs')) {
	function hvac_link_target_attrs($target)
	{
		return ('_blank' === $target) ? ' target="_blank" rel="noopener noreferrer"' : '';
	}
}

/**
 * Small helper: value from ACF or a fallback.
 */
if (! function_exists('hvac_hf')) {
	function hvac_hf($name, $fallback = '')
	{
		if (function_exists('get_field')) {
			$val = get_field($name);
			if (! empty($val)) {
				return $val;
			}
		}
		return $fallback;
	}
}

/**
 * Render an image from an ACF image array, or a placeholder box.
 */
if (! function_exists('hvac_acf_image')) {
	function hvac_acf_image($image, $size = 'large', $class = '')
	{
		if (! empty($image['ID'])) {
			echo wp_get_attachment_image($image['ID'], $size, false, array('class' => $class));
		} elseif (! empty($image['url'])) {
			printf('<img class="%1$s" src="%2$s" alt="%3$s">', esc_attr($class), esc_url($image['url']), esc_attr(! empty($image['alt']) ? $image['alt'] : ''));
		} else {
			printf('<span class="img-placeholder %s" aria-hidden="true"></span>', esc_attr($class));
		}
	}
}

/**
 * A small "wave" eyebrow icon (matches the Figma tilde/wave motif).
 */
if (! function_exists('hvac_wave_icon')) {
	function hvac_wave_icon()
	{
		return '<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.64379 3.75726C3.39079 2.25726 4.77079 1.07126 8.51579 3.18726C10.3148 4.20326 11.7658 4.58726 12.9728 4.58526C15.0878 4.58526 16.4588 3.40926 17.6438 2.39226C17.8472 2.21532 17.9737 1.96612 17.9965 1.69749C18.0192 1.42886 17.9365 1.16192 17.7658 0.953261C17.6825 0.850869 17.5796 0.766217 17.463 0.704312C17.3464 0.642407 17.2187 0.604506 17.0872 0.592852C16.9557 0.581197 16.8233 0.596026 16.6976 0.636461C16.572 0.676895 16.4558 0.742115 16.3558 0.828261C14.6098 2.33026 13.2288 3.51626 9.48379 1.39826C4.53579 -1.39474 2.21779 0.595261 0.355789 2.19526C0.15254 2.37234 0.0262366 2.62161 0.00364913 2.89024C-0.0189384 3.15886 0.0639655 3.42572 0.234789 3.63426C0.318112 3.73648 0.421092 3.82094 0.537636 3.88265C0.65418 3.94436 0.78192 3.98207 0.913294 3.99354C1.04467 4.00501 1.17701 3.99 1.30248 3.94942C1.42796 3.90884 1.54402 3.84349 1.64379 3.75726ZM16.3558 5.93526C14.6098 7.43526 13.2288 8.62326 9.48379 6.50526C4.53579 3.71026 2.21779 5.70126 0.355789 7.30026C0.15254 7.47734 0.0262366 7.72661 0.00364913 7.99524C-0.0189384 8.26386 0.0639655 8.53072 0.234789 8.73926C0.317968 8.84162 0.420838 8.92625 0.53731 8.98815C0.653782 9.05004 0.781487 9.08794 0.912867 9.09959C1.04425 9.11125 1.17663 9.09642 1.30218 9.056C1.42773 9.01558 1.54389 8.95038 1.64379 8.86426C3.39079 7.36326 4.77079 6.17726 8.51579 8.29226C10.3148 9.31026 11.7658 9.69226 12.9728 9.69226C15.0878 9.69226 16.4588 8.51626 17.6438 7.49726C17.8473 7.32063 17.974 7.07157 17.9968 6.80303C18.0195 6.53449 17.9367 6.26766 17.7658 6.05926C17.6825 5.95682 17.5796 5.87215 17.463 5.81025C17.3464 5.74836 17.2185 5.71051 17.087 5.69894C16.9555 5.68738 16.823 5.70234 16.6974 5.74293C16.5718 5.78353 16.4556 5.84893 16.3558 5.93526ZM16.3558 11.0413C14.6098 12.5433 13.2288 13.7293 9.48379 11.6133C4.53579 8.81826 2.21779 10.8083 0.355789 12.4083C0.15254 12.5853 0.0262366 12.8346 0.00364913 13.1032C-0.0189384 13.3719 0.0639655 13.6387 0.234789 13.8473C0.31803 13.9496 0.420978 14.0342 0.537524 14.096C0.654071 14.1577 0.781842 14.1955 0.913256 14.207C1.04467 14.2184 1.17705 14.2034 1.30254 14.1627C1.42803 14.1221 1.54408 14.0566 1.64379 13.9703C3.39079 12.4703 4.77079 11.2853 8.51579 13.4003C10.3148 14.4163 11.7658 14.8003 12.9728 14.8003C15.0878 14.8003 16.4588 13.6223 17.6438 12.6053C17.8472 12.4283 17.9737 12.1791 17.9965 11.9105C18.0192 11.6419 17.9365 11.3749 17.7658 11.1663C17.6823 11.0642 17.5792 10.9799 17.4627 10.9182C17.3461 10.8566 17.2184 10.8188 17.0871 10.8071C16.9557 10.7955 16.8234 10.8102 16.6978 10.8504C16.5722 10.8906 16.4559 10.9555 16.3558 11.0413Z" fill="#F6F237"/>
</svg>
';
	}
}

get_header();
?>

<?php
/* =============================== HERO =============================== */
$hero_eyebrow  = hvac_hf('hero_eyebrow', 'Stay Cool, Worry-Free');
$hero_heading  = hvac_hf('hero_heading', 'Reliable AC Service Anytime, Anywhere');
$hero_tagline  = hvac_hf('hero_tagline', 'Expert Repairs | Quick Maintenance | Hassle-Free Cooling');
$hero_subtext  = hvac_hf('hero_subtext', 'Keep your home cool and comfortable with fast, professional AC repair, maintenance, and installation you can rely on.');
$hero_bg_img   = $hvac_acf ? get_field('hero_background_image') : false;
$hero_button   = $hvac_acf ? get_field('hero_button') : false;

$hero_form_eyebrow  = hvac_hf('hero_form_eyebrow', 'Effortless Cooling, Anytime');
$hero_form_title    = hvac_hf('hero_form_title', 'Booking For Your Comfort');
$hero_form_subtitle = hvac_hf('hero_form_subtitle', 'Keep your air conditioner running at peak performance with expert repairs.');
$hero_form_button   = hvac_hf('hero_form_button', 'Book Now');
$hero_form_shortcode = hvac_hf('hero_form_shortcode', '');
$hero_form_services = hvac_hf('hero_form_services', "AC Repair\nAC Installation\nAC Maintenance\nEmergency Service\nDuct Cleaning");
$hero_service_opts  = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $hero_form_services)));

$hero_features = ($hvac_acf && have_rows('hero_features')) ? get_field('hero_features') : array();

$hero_checklist = ($hvac_acf && have_rows('hero_checklist')) ? get_field('hero_checklist') : array();
if (empty($hero_checklist)) {
	$hero_checklist = array(
		array('text' => __('Licensed & Certified HVAC Professionals', 'hvac')),
		array('text' => __('Free Estimates on Eligible HVAC Projects', 'hvac')),
		array('text' => __('Heating & Cooling Installation, Replacement & Repair', 'hvac')),
		array('text' => __('Residential & Commercial HVAC Services', 'hvac')),
		array('text' => __('Reliable Workmanship & Professional Service', 'hvac')),
	);
}

$hero_feature_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.1-2.1 2.8-2.8z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>',
);
?>
<section class="home-hero" <?php echo (is_array($hero_bg_img) && ! empty($hero_bg_img['url'])) ? ' style="background-image:url(' . esc_url($hero_bg_img['url']) . ')"' : ''; ?>>
	<div class="container home-hero-inner">
		<div class="home-hero-content">
			<?php if ($hero_eyebrow) : ?>
				<span class="hero-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?><?php echo esc_html($hero_eyebrow); ?></span>
			<?php endif; ?>
			<h1 class="hero-heading"><?php echo esc_html($hero_heading); ?></h1>
			<?php if ($hero_tagline) : ?><p class="hero-tagline"><?php echo esc_html($hero_tagline); ?></p><?php endif; ?>
			<?php if ($hero_subtext) : ?><p class="hero-subtext"><?php echo esc_html($hero_subtext); ?></p><?php endif; ?>
			<?php
			$hero_btn_url = ! empty($hero_button['url']) ? $hero_button['url'] : '#';
			$hero_btn_txt = ! empty($hero_button['title']) ? $hero_button['title'] : __('Get Started', 'hvac');
			$hero_btn_tgt = ! empty($hero_button['target']) ? $hero_button['target'] : '';
			?>
			<a class="btn hero-btn" href="<?php echo esc_url($hero_btn_url); ?>" <?php echo hvac_link_target_attrs($hero_btn_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?>><?php echo esc_html($hero_btn_txt); ?></a>

			<?php if (! empty($hero_checklist)) : ?>
				<ul class="location-checklist hero-checklist">
					<?php foreach ($hero_checklist as $hc) : ?>
						<?php if (empty($hc['text'])) : continue;
						endif; ?>
						<li>
							<span class="location-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg></span>
							<?php echo esc_html($hc['text']); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if (! empty($hero_features)) : ?>
				<div class="hero-features-wrapper">
					<ul class="hero-features-cards">
						<?php $hf_i = 0; ?>
						<?php foreach ($hero_features as $hf) : ?>
							<?php if (empty($hf['title']) && empty($hf['text'])) : continue;
							endif; ?>
							<li class="hero-feature-card">
								<span class="hero-feature-icon" aria-hidden="true">
									<?php
									if (! empty($hf['icon'])) {
										hvac_acf_image($hf['icon'], 'thumbnail', 'hero-feature-icon-img');
									} else {
										echo $hero_feature_icons[$hf_i % 3]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
									?>
								</span>
								<?php if (! empty($hf['title'])) : ?><h3 class="hero-feature-title"><?php echo esc_html($hf['title']); ?></h3><?php endif; ?>
								<?php if (! empty($hf['text'])) : ?><p class="hero-feature-text"><?php echo esc_html($hf['text']); ?></p><?php endif; ?>
							</li>
							<?php $hf_i++; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>

		<div class="home-hero-form">
			<div class="booking-form">
				<?php if ($hero_form_eyebrow) : ?>
					<span class="booking-form-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
														?><?php echo esc_html($hero_form_eyebrow); ?></span>
				<?php endif; ?>
				<?php if ($hero_form_title) : ?><h2 class="booking-form-title"><?php echo esc_html($hero_form_title); ?></h2><?php endif; ?>
				<?php if ($hero_form_subtitle) : ?><p class="booking-form-subtitle"><?php echo esc_html($hero_form_subtitle); ?></p><?php endif; ?>

				<?php if ($hero_form_shortcode) : ?>
					<?php echo do_shortcode($hero_form_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
					?>
				<?php else : ?>
					<form class="booking-form-fields" method="post" action="#" novalidate>
						<label class="screen-reader-text" for="bf-name"><?php esc_html_e('Your Name', 'hvac'); ?></label>
						<input id="bf-name" type="text" name="name" placeholder="<?php esc_attr_e('Your Name', 'hvac'); ?>">

						<label class="screen-reader-text" for="bf-service"><?php esc_html_e('Choose services', 'hvac'); ?></label>
						<select id="bf-service" name="service">
							<option value=""><?php esc_html_e('Choose services', 'hvac'); ?></option>
							<?php foreach ($hero_service_opts as $opt) : ?>
								<option><?php echo esc_html($opt); ?></option>
							<?php endforeach; ?>
						</select>

						<div>
							<label class="screen-reader-text" for="bf-phone"><?php esc_html_e('Phone Number', 'hvac'); ?></label>
							<input id="bf-phone" type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'hvac'); ?>">
						</div>
						<div>
							<label class="screen-reader-text" for="bf-email"><?php esc_html_e('Email Address', 'hvac'); ?></label>
							<input id="bf-email" type="email" name="email" placeholder="<?php esc_attr_e('Email Address', 'hvac'); ?>">
						</div>

						<button type="submit" class="btn-accent booking-form-submit"><?php echo esc_html($hero_form_button); ?></button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>


</section>

<?php
/* =============================== ABOUT =============================== */
$about_image   = $hvac_acf ? get_field('about_image') : false;
$about_eyebrow = hvac_hf('about_eyebrow', 'About Us');
$about_heading = hvac_hf('about_heading', 'Trusted Heating & Cooling Professionals');
$about_text    = hvac_hf('about_text', '');
$about_button  = $hvac_acf ? get_field('about_button') : false;
if (! $about_text) {
	$about_text = wpautop(__('Your HVAC system plays an important role in keeping your home or business comfortable throughout the year. When equipment stops working or reaches the end of its service life, choosing the right HVAC contractor can make a significant difference in comfort, reliability, and long-term performance. We provide professional heating and cooling solutions designed around the needs of your property- from replacing an aging furnace or air conditioner to installing a new heat pump or ductless system- with a focus on proper system selection, professional installation, dependable repairs, and quality workmanship.', 'hvac'));
}
?>
<section class="home-about">
	<div class="container home-about-inner">
		<div class="home-about-media">
			<?php hvac_acf_image($about_image, 'large', 'home-about-image'); ?>
		</div>
		<div class="home-about-content">
			<?php if ($about_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																		?><?php echo esc_html($about_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($about_heading); ?></h2>
			<div class="home-about-text"><?php echo wp_kses_post($about_text); ?></div>
			<?php if (! empty($about_button['url'])) : ?>
				<a class="btn" href="<?php echo esc_url($about_button['url']); ?>" <?php echo hvac_link_target_attrs(! empty($about_button['target']) ? $about_button['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?>><?php echo esc_html(! empty($about_button['title']) ? $about_button['title'] : __('Learn More', 'hvac')); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/* =============================== SERVICES =============================== */
$services_eyebrow = hvac_hf('services_eyebrow', 'Our Services');
$services_heading = hvac_hf('services_heading', 'Our HVAC Services');
$services_subtext = hvac_hf('services_subtext', 'Every property has different heating and cooling requirements. We provide a range of HVAC installation, replacement, and repair services to help keep your property comfortable and your systems operating reliably.');

// Services now come from the "Service" CPT. An optional relationship curates
// which services show (and their order); otherwise the latest N are shown.
$svc_selected = $hvac_acf ? get_field('home_services_selected') : array();
$svc_selected = is_array($svc_selected) ? array_map('intval', array_filter($svc_selected)) : array();
$svc_count    = (int) hvac_hf('services_count', 6);
if ($svc_count < 1) {
	$svc_count = 6;
}
$svc_args = array(
	'post_type'           => 'service',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if (! empty($svc_selected)) {
	$svc_args['post__in']       = $svc_selected;
	$svc_args['orderby']        = 'post__in';
	$svc_args['posts_per_page'] = count($svc_selected);
} else {
	$svc_args['posts_per_page'] = $svc_count;
}
$svc_q = new WP_Query($svc_args);

// Decorative icon shown inside each service badge.
$hvac_badge_icon = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="40" height="40" rx="12" fill="#002B2C" />
										<path d="M20 22.85C21.574 22.85 22.85 21.574 22.85 20C22.85 18.426 21.574 17.15 20 17.15C18.426 17.15 17.15 18.426 17.15 20C17.15 21.574 18.426 22.85 20 22.85Z" fill="#4DFFF4" />
										<path d="M20 23.85C19 23.85 18 23.45 17.3 22.75C16.6 22.05 16.2 21.05 16.2 20.05C16.2 19.05 16.6 18.05 17.3 17.35C18 16.65 19 16.25 20 16.25C21 16.25 22 16.65 22.7 17.35C23.4 18.05 23.8 19.05 23.8 20.05C23.8 21.05 23.4 22.05 22.7 22.75C22 23.45 21 23.85 20 23.85ZM20 18.15C19.5 18.15 19.05 18.35 18.7 18.7C18.35 19.05 18.15 19.5 18.15 20C18.15 20.5 18.35 20.95 18.7 21.3C19.4 22 20.6 22 21.3 21.3C21.65 20.95 21.85 20.5 21.85 20C21.85 19.5 21.65 19.05 21.3 18.7C20.95 18.35 20.5 18.15 20 18.15Z" fill="#4DFFF4" />
										<path d="M25.8 30.8C25.25 30.8 24.8 30.35 24.8 29.8V25.8C24.8 25.25 25.25 24.8 25.8 24.8H29.8C30.35 24.8 30.8 25.25 30.8 25.8C30.8 26.35 30.35 26.8 29.8 26.8H26.8V29.8C26.8 30.35 26.35 30.8 25.8 30.8Z" fill="#4DFFF4" />
										<path d="M14.2 15.2H10.2C9.65 15.2 9.2 14.75 9.2 14.2C9.2 13.65 9.65 13.2 10.2 13.2H13.2V10.2C13.2 9.65 13.65 9.2 14.2 9.2C14.75 9.2 15.2 9.65 15.2 10.2V14.2C15.2 14.75 14.75 15.2 14.2 15.2Z" fill="#4DFFF4" />
										<path d="M29.8 15.2H25.8C25.25 15.2 24.8 14.75 24.8 14.2V10.2C24.8 9.65 25.25 9.2 25.8 9.2C26.35 9.2 26.8 9.65 26.8 10.2V13.2H29.8C30.35 13.2 30.8 13.65 30.8 14.2C30.8 14.75 30.35 15.2 29.8 15.2Z" fill="#4DFFF4" />
										<path d="M14.2 30.8C13.65 30.8 13.2 30.35 13.2 29.8V26.8H10.2C9.65 26.8 9.2 26.35 9.2 25.8C9.2 25.25 9.65 24.8 10.2 24.8H14.2C14.75 24.8 15.2 25.25 15.2 25.8V29.8C15.2 30.35 14.75 30.8 14.2 30.8Z" fill="#4DFFF4" />
										<path d="M20 12.85C19.75 12.85 19.5 12.75 19.3 12.55L16.45 9.7C16.05 9.3 16.05 8.7 16.45 8.3C16.85 7.9 17.45 7.9 17.85 8.3L19.95 10.4L22.05 8.3C22.45 7.9 23.05 7.9 23.45 8.3C23.85 8.7 23.85 9.3 23.45 9.7L20.6 12.55C20.5 12.75 20.25 12.85 20 12.85Z" fill="#4DFFF4" />
										<path d="M22.85 32C22.6 32 22.35 31.9 22.15 31.7L20.05 29.6L17.95 31.7C17.55 32.1 16.95 32.1 16.55 31.7C16.15 31.3 16.15 30.7 16.55 30.3L19.4 27.45C19.8 27.05 20.4 27.05 20.8 27.45L23.65 30.3C24.05 30.7 24.05 31.3 23.65 31.7C23.35 31.9 23.1 32 22.85 32Z" fill="#4DFFF4" />
										<path d="M9 23.85C8.75 23.85 8.5 23.75 8.3 23.55C7.9 23.15 7.9 22.55 8.3 22.15L10.4 20.05L8.3 17.95C7.9 17.55 7.9 16.95 8.3 16.55C8.7 16.15 9.3 16.15 9.7 16.55L12.55 19.4C12.95 19.8 12.95 20.4 12.55 20.8L9.7 23.65C9.5 23.75 9.25 23.85 9 23.85Z" fill="#4DFFF4" />
										<path d="M31 23.85C30.75 23.85 30.5 23.75 30.3 23.55L27.45 20.7C27.05 20.3 27.05 19.7 27.45 19.3L30.3 16.45C30.7 16.05 31.3 16.05 31.7 16.45C32.1 16.85 32.1 17.45 31.7 17.85L29.6 19.95L31.7 22.05C32.1 22.45 32.1 23.05 31.7 23.45C31.5 23.75 31.25 23.85 31 23.85Z" fill="#4DFFF4" />
										<path d="M20 18.15C19.45 18.15 19 17.7 19 17.15V11.85C19 11.3 19.45 10.85 20 10.85C20.55 10.85 21 11.3 21 11.85V17.2C21 17.7 20.55 18.15 20 18.15Z" fill="#4DFFF4" />
										<path d="M20 29.15C19.45 29.15 19 28.7 19 28.15V22.85C19 22.3 19.45 21.85 20 21.85C20.55 21.85 21 22.3 21 22.85V28.2C21 28.7 20.55 29.15 20 29.15Z" fill="#4DFFF4" />
										<path d="M22 19C21.75 19 21.5 18.9 21.3 18.7C20.9 18.3 20.9 17.7 21.3 17.3L25.1 13.5C25.5 13.1 26.1 13.1 26.5 13.5C26.9 13.9 26.9 14.5 26.5 14.9L22.7 18.7C22.5 18.9 22.25 19 22 19Z" fill="#4DFFF4" />
										<path d="M14.2 26.8C13.95 26.8 13.7 26.7 13.5 26.5C13.1 26.1 13.1 25.5 13.5 25.1L17.3 21.3C17.7 20.9 18.3 20.9 18.7 21.3C19.1 21.7 19.1 22.3 18.7 22.7L14.9 26.5C14.75 26.7 14.5 26.8 14.2 26.8Z" fill="#4DFFF4" />
										<path d="M28.15 21H22.85C22.3 21 21.85 20.55 21.85 20C21.85 19.45 22.3 19 22.85 19H28.2C28.75 19 29.2 19.45 29.2 20C29.2 20.55 28.7 21 28.15 21Z" fill="#4DFFF4" />
										<path d="M17.15 21H11.85C11.3 21 10.85 20.55 10.85 20C10.85 19.45 11.3 19 11.85 19H17.2C17.75 19 18.2 19.45 18.2 20C18.2 20.55 17.7 21 17.15 21Z" fill="#4DFFF4" />
										<path d="M25.8 26.8C25.55 26.8 25.3 26.7 25.1 26.5L21.3 22.7C20.9 22.3 20.9 21.7 21.3 21.3C21.7 20.9 22.3 20.9 22.7 21.3L26.5 25.1C26.9 25.5 26.9 26.1 26.5 26.5C26.3 26.7 26.05 26.8 25.8 26.8Z" fill="#4DFFF4" />
										<path d="M18 19C17.75 19 17.5 18.9 17.3 18.7L13.5 14.9C13.1 14.5 13.1 13.9 13.5 13.5C13.9 13.1 14.5 13.1 14.9 13.5L18.7 17.3C19.1 17.7 19.1 18.3 18.7 18.7C18.5 18.9 18.25 19 18 19Z" fill="#4DFFF4" />
									</svg>';

// Fallback demo cards shown only when no Service posts exist yet.
$svc_fallback = array(
	array('badge' => __('Cooling Systems', 'hvac'), 'title' => __('AC Installation & Replacement', 'hvac'), 'text' => __('Upgrade your property\'s cooling system with professional AC installation and replacement, properly sized for your space.', 'hvac')),
	array('badge' => __('Heating Systems', 'hvac'), 'title' => __('Furnace Replacement', 'hvac'), 'text' => __('Replace an aging or failing furnace with a properly selected system for dependable, restored indoor comfort.', 'hvac')),
	array('badge' => __('Year-Round Comfort', 'hvac'), 'title' => __('Heat Pump Installation & Replacement', 'hvac'), 'text' => __('Heat pumps provide both heating and cooling from one system for efficient year-round comfort.', 'hvac')),
	array('badge' => __('No Ductwork Needed', 'hvac'), 'title' => __('Ductless / Mini-Split Installation', 'hvac'), 'text' => __('Flexible heating and cooling without traditional ductwork- ideal for additions, garages, and individual rooms.', 'hvac')),
	array('badge' => __('Business Solutions', 'hvac'), 'title' => __('Commercial HVAC', 'hvac'), 'text' => __('Dependable HVAC installation, replacement, and repair for offices, retail spaces, and other commercial properties.', 'hvac')),
	array('badge' => __('24/7 Response', 'hvac'), 'title' => __('Emergency HVAC Repair', 'hvac'), 'text' => __('Fast diagnosis and repair when your heating or cooling system stops working unexpectedly.', 'hvac')),
);
?>
<section class="home-services">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($services_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($services_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($services_heading); ?></h2>
			<?php if ($services_subtext) : ?><p class="section-subtext"><?php echo esc_html($services_subtext); ?></p><?php endif; ?>
		</div>

		<div class="services-grid">
			<?php if ($svc_q->have_posts()) : ?>
				<?php while ($svc_q->have_posts()) : $svc_q->the_post(); ?>
					<?php $badge = $hvac_acf ? get_field('service_badge') : ''; ?>
					<article class="service-card">
						<a class="service-card-media" href="<?php the_permalink(); ?>">
							<?php
							if (has_post_thumbnail()) {
								the_post_thumbnail('large', array('class' => 'service-card-image'));
							} else {
								echo '<span class="img-placeholder service-card-image" aria-hidden="true"></span>';
							}
							?>
							<?php if ($badge) : ?>
								<span class="service-card-badge">
									<span class="service-card-badge-icon" aria-hidden="true"><?php echo $hvac_badge_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<?php echo esc_html($badge); ?>
								</span>
							<?php endif; ?>
						</a>
						<div class="service-card-body">
							<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php $svc_excerpt = get_the_excerpt(); ?>
							<?php if ($svc_excerpt) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($svc_excerpt, 20)); ?></p><?php endif; ?>
						</div>
					</article>
				<?php endwhile;
				wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ($svc_fallback as $svc) : ?>
					<article class="service-card">
						<div class="service-card-media">
							<span class="img-placeholder service-card-image" aria-hidden="true"></span>
							<?php if (! empty($svc['badge'])) : ?>
								<span class="service-card-badge">
									<span class="service-card-badge-icon" aria-hidden="true"><?php echo $hvac_badge_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<?php echo esc_html($svc['badge']); ?>
								</span>
							<?php endif; ?>
						</div>
						<div class="service-card-body">
							<h3 class="service-card-title"><?php echo esc_html($svc['title']); ?></h3>
							<p class="service-card-text"><?php echo esc_html($svc['text']); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/* =============================== WHY CHOOSE US =============================== */
$whyus_eyebrow = hvac_hf('whyus_eyebrow', 'Why Choose Us');
$whyus_heading = hvac_hf('whyus_heading', 'Why Choose HVAC Reliable Pros?');
$whyus_subtext = hvac_hf('whyus_subtext', 'Choosing the right HVAC contractor can affect your system\'s performance, reliability, and lifespan. We combine professional HVAC knowledge, quality workmanship, and dependable service to help customers make informed decisions.');
$whyus_items = ($hvac_acf && have_rows('whyus_items')) ? get_field('whyus_items') : array();
if (empty($whyus_items)) {
	$whyus_items = array(
		array('title' => __('Experienced HVAC Professionals', 'hvac'), 'text' => __('Our technicians have the knowledge and experience needed to work with residential and commercial heating and cooling systems.', 'hvac')),
		array('title' => __('Professional System Installation', 'hvac'), 'text' => __('We focus on correct equipment selection, installation, and system setup based on your property\'s requirements.', 'hvac')),
		array('title' => __('Heating & Cooling Expertise', 'hvac'), 'text' => __('Our services cover both heating and cooling, including air conditioners, furnaces, heat pumps, and ductless systems.', 'hvac')),
		array('title' => __('Residential & Commercial Service', 'hvac'), 'text' => __('HVAC solutions designed around the size, use, and requirements of each property, from homes to commercial buildings.', 'hvac')),
		array('title' => __('Clear Communication', 'hvac'), 'text' => __('Clear information about your HVAC options, project requirements, and next steps from inquiry through completion.', 'hvac')),
		array('title' => __('Quality Workmanship', 'hvac'), 'text' => __('Careful installation, replacement, and repair work for dependable HVAC solutions and long-lasting comfort.', 'hvac')),
	);
}
$whyus_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.1-2.1 2.8-2.8z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
);
?>
<section class="service-whyus">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($whyus_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($whyus_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($whyus_heading); ?></h2>
			<?php if ($whyus_subtext) : ?><p class="section-subtext whyus-lead"><?php echo esc_html($whyus_subtext); ?></p><?php endif; ?>
		</div>
		<div class="whyus-grid">
			<?php $wu_i = 0; ?>
			<?php foreach ($whyus_items as $wu) : ?>
				<?php if (empty($wu['title']) && empty($wu['text'])) : continue;
				endif; ?>
				<article class="whyus-card">
					<span class="whyus-card-icon" aria-hidden="true"><?php echo $whyus_icons[$wu_i % 6]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if (! empty($wu['title'])) : ?><h3 class="whyus-card-title"><?php echo esc_html($wu['title']); ?></h3><?php endif; ?>
					<?php if (! empty($wu['text'])) : ?><p class="whyus-card-text"><?php echo esc_html($wu['text']); ?></p><?php endif; ?>
				</article>
				<?php $wu_i++; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== HOW IT WORKS =============================== */
$how_image   = $hvac_acf ? get_field('how_image') : false;
$how_eyebrow = hvac_hf('how_eyebrow', 'Our Process');
$how_heading = hvac_hf('how_heading', 'Our HVAC Process');
$how_subtext = hvac_hf('how_subtext', 'A successful HVAC project starts with understanding your property\'s needs and choosing the right solution- from consultation to completion.');
$how_steps = ($hvac_acf && have_rows('how_steps')) ? get_field('how_steps') : array();
if (empty($how_steps)) {
	$how_steps = array(
		array('title' => __('Consultation & Estimate', 'hvac'), 'text' => __('We learn about your heating or cooling needs, assess your property\'s requirements, and provide an estimate based on the project.', 'hvac')),
		array('title' => __('System Assessment & Recommendations', 'hvac'), 'text' => __('Our team evaluates your existing HVAC system or installation requirements and recommends an appropriate solution.', 'hvac')),
		array('title' => __('Professional Installation or Repair', 'hvac'), 'text' => __('Once you approve the work, our technicians complete the installation, replacement, or repair using professional techniques and equipment.', 'hvac')),
		array('title' => __('System Check & Completion', 'hvac'), 'text' => __('We check the system and confirm the project is properly completed so you can get back to reliable heating and cooling.', 'hvac')),
	);
}
?>
<section class="home-how">
	<div class="container home-how-inner">
		<div class="home-how-media">
			<?php hvac_acf_image($how_image, 'large', 'home-how-image'); ?>
		</div>
		<div class="home-how-content">
			<?php if ($how_eyebrow) : ?><span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																							?><?php echo esc_html($how_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($how_heading); ?></h2>
			<?php if ($how_subtext) : ?><p class="home-how-subtext"><?php echo esc_html($how_subtext); ?></p><?php endif; ?>

			<ol class="how-steps">
				<?php $step_n = 1; ?>
				<?php foreach ($how_steps as $step) : ?>
					<?php if (empty($step['title'])) : continue;
					endif; ?>
					<li class="how-step">
						<span class="how-step-num" aria-hidden="true"><?php echo esc_html(str_pad((string) $step_n, 2, '0', STR_PAD_LEFT)); ?></span>
						<div class="how-step-body">
							<h3 class="how-step-title"><?php echo esc_html($step['title']); ?></h3>
							<?php if (! empty($step['text'])) : ?><p class="how-step-text"><?php echo esc_html($step['text']); ?></p><?php endif; ?>
						</div>
					</li>
					<?php $step_n++; ?>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>

<?php
/* =============================== WHY IT MATTERS =============================== */
$matters_eyebrow = hvac_hf('matters_eyebrow', 'Why It Matters');
$matters_heading = hvac_hf('matters_heading', 'Why Professional HVAC Service Matters');
$matters_subtext = hvac_hf('matters_subtext', 'Your HVAC system is responsible for maintaining indoor comfort throughout changing seasons. Professional installation, replacement, and repair help ensure your system is properly suited to your property.');
$matters_items = ($hvac_acf && have_rows('matters_items')) ? get_field('matters_items') : array();
if (empty($matters_items)) {
	$matters_items = array(
		array('title' => __('Improve Indoor Comfort', 'hvac'), 'text' => __('A properly selected and professionally installed HVAC system provides consistent heating and cooling throughout your property.', 'hvac')),
		array('title' => __('Replace Aging Equipment', 'hvac'), 'text' => __('Older HVAC systems can become increasingly unreliable- replacing outdated equipment restores dependable performance.', 'hvac')),
		array('title' => __('Address HVAC Problems', 'hvac'), 'text' => __('When a system stops working properly, professional diagnosis and repair helps identify the cause and the right solution.', 'hvac')),
		array('title' => __('Support System Performance', 'hvac'), 'text' => __('Proper installation and repair help ensure your HVAC equipment is correctly set up and operating as intended.', 'hvac')),
		array('title' => __('Find the Right HVAC Solution', 'hvac'), 'text' => __('Different properties require different systems- professional guidance helps you select the right solution for your needs.', 'hvac')),
	);
}
?>
<section class="services-benefits">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($matters_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($matters_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($matters_heading); ?></h2>
			<?php if ($matters_subtext) : ?><p class="section-subtext"><?php echo esc_html($matters_subtext); ?></p><?php endif; ?>
		</div>
		<ul class="benefits-grid">
			<?php foreach ($matters_items as $mi) : ?>
				<?php if (empty($mi['title']) && empty($mi['text'])) : continue;
				endif; ?>
				<li class="benefit-card">
					<span class="benefit-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a7 7 0 0 0-7 7c0 3 2 5 2 8h10c0-3 2-5 2-8a7 7 0 0 0-7-7z"/><line x1="9" y1="21" x2="15" y2="21"/></svg></span>
					<?php if (! empty($mi['title'])) : ?><h3 class="benefit-title"><?php echo esc_html($mi['title']); ?></h3><?php endif; ?>
					<?php if (! empty($mi['text'])) : ?><p class="benefit-text"><?php echo esc_html($mi['text']); ?></p><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
/* =============================== SYSTEM OPTIONS =============================== */
$options_eyebrow = hvac_hf('options_eyebrow', 'System Options');
$options_heading = hvac_hf('options_heading', 'Heating & Cooling System Options');
$options_subtext = hvac_hf('options_subtext', 'We provide professional services for several types of heating and cooling equipment.');
$options_items = ($hvac_acf && have_rows('options_items')) ? get_field('options_items') : array();
if (empty($options_items)) {
	$options_items = array(
		array('title' => __('Central Air Conditioning', 'hvac'), 'text' => __('Central AC systems cool your property through a connected air distribution system. We install, replace, and repair central air conditioning systems.', 'hvac')),
		array('title' => __('Furnaces', 'hvac'), 'text' => __('Furnaces provide heating during colder weather. When an existing furnace reaches the end of its life, professional replacement restores dependable heating.', 'hvac')),
		array('title' => __('Heat Pumps', 'hvac'), 'text' => __('Heat pumps provide heating and cooling from one system, making them a flexible option for year-round comfort.', 'hvac')),
		array('title' => __('Ductless Mini-Splits', 'hvac'), 'text' => __('Ductless systems provide targeted heating and cooling without traditional ductwork- suitable for certain rooms, additions, and garages.', 'hvac')),
	);
}
$options_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/><circle cx="12" cy="12" r="4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.1-2.1 2.8-2.8z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="14" height="10" rx="1"/><path d="M16 10l6-3v10l-6-3"/></svg>',
);
?>
<section class="service-whyus">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($options_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($options_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($options_heading); ?></h2>
			<?php if ($options_subtext) : ?><p class="section-subtext whyus-lead"><?php echo esc_html($options_subtext); ?></p><?php endif; ?>
		</div>
		<div class="whyus-grid">
			<?php $op_i = 0; ?>
			<?php foreach ($options_items as $op) : ?>
				<?php if (empty($op['title']) && empty($op['text'])) : continue;
				endif; ?>
				<article class="whyus-card">
					<span class="whyus-card-icon" aria-hidden="true"><?php echo $options_icons[$op_i % 4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if (! empty($op['title'])) : ?><h3 class="whyus-card-title"><?php echo esc_html($op['title']); ?></h3><?php endif; ?>
					<?php if (! empty($op['text'])) : ?><p class="whyus-card-text"><?php echo esc_html($op['text']); ?></p><?php endif; ?>
				</article>
				<?php $op_i++; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== RECENT PROJECTS =============================== */
$projects_eyebrow = hvac_hf('projects_eyebrow', 'Our Work');
$projects_heading = hvac_hf('projects_heading', 'Recent HVAC Projects');
$projects_subtext = hvac_hf('projects_subtext', 'Our completed HVAC projects demonstrate the quality, attention to detail, and professional workmanship customers can expect from HVAC Reliable Pros.');
$projects_items = ($hvac_acf && have_rows('projects_items')) ? get_field('projects_items') : array();
if (empty($projects_items)) {
	$projects_items = array(
		array('title' => __('Residential AC Replacement', 'hvac'), 'text' => __('We replaced an aging residential air conditioning system with a properly selected replacement designed around the property\'s cooling requirements.', 'hvac')),
		array('title' => __('Furnace Replacement', 'hvac'), 'text' => __('We replaced an outdated furnace with a new heating system to provide dependable heating and improved comfort.', 'hvac')),
		array('title' => __('Heat Pump Installation', 'hvac'), 'text' => __('Our team installed a new heat pump system designed to provide heating and cooling for year-round residential comfort.', 'hvac')),
		array('title' => __('Commercial HVAC Installation', 'hvac'), 'text' => __('We completed a commercial HVAC installation designed around the property\'s heating and cooling requirements and day-to-day use.', 'hvac')),
	);
}
?>
<section id="project-gallery" class="home-projects">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($projects_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($projects_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($projects_heading); ?></h2>
			<?php if ($projects_subtext) : ?><p class="section-subtext"><?php echo esc_html($projects_subtext); ?></p><?php endif; ?>
		</div>
		<div class="services-grid">
			<?php foreach ($projects_items as $pj) : ?>
				<?php if (empty($pj['title']) && empty($pj['text'])) : continue;
				endif; ?>
				<article class="service-card">
					<div class="service-card-media">
						<?php hvac_acf_image(isset($pj['image']) ? $pj['image'] : false, 'large', 'service-card-image'); ?>
					</div>
					<div class="service-card-body">
						<?php if (! empty($pj['title'])) : ?><h3 class="service-card-title"><?php echo esc_html($pj['title']); ?></h3><?php endif; ?>
						<?php if (! empty($pj['text'])) : ?><p class="service-card-text"><?php echo esc_html($pj['text']); ?></p><?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== TESTIMONIALS =============================== */
$testi_eyebrow = hvac_hf('testi_eyebrow', 'Reviews');
$testi_heading = hvac_hf('testi_heading', 'What Our Customers Say');
$testi_subtext = hvac_hf('testi_subtext', 'Customers choose HVAC Reliable Pros for professional heating and cooling installation, replacement, and repair services.');
$testimonials  = hvac_get_testimonials(
	$hvac_acf ? get_field('testimonials_selected') : array(),
	(int) hvac_hf('testimonials_count', 3)
);
?>
<?php if (! empty($testimonials)) : ?>
<section id="reviews" class="home-testimonials">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($testi_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
																		?><?php echo esc_html($testi_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($testi_heading); ?></h2>
			<?php if ($testi_subtext) : ?><p class="section-subtext"><?php echo esc_html($testi_subtext); ?></p><?php endif; ?>
		</div>

		<div class="testimonials-grid">
			<?php foreach ($testimonials as $t) : ?>
				<article class="testimonial-card">
					<div class="testimonial-media">
						<?php hvac_acf_image(isset($t['image']) ? $t['image'] : false, 'large', 'testimonial-image'); ?>
					</div>
					<div class="testimonial-body">
						<div class="testimonial-quite-wrapper">
							<div class="testimonial-person">
								<div class="headshot-wrapper">
									<?php hvac_acf_image(isset($t['headshot']) ? $t['headshot'] : false, 'thumbnail', 'testimonial-headshot'); ?>

								</div>
								<div class="details">
									<?php if (! empty($t['name'])) : ?><span class="testimonial-name"><?php echo esc_html($t['name']); ?></span><?php endif; ?>
									<?php if (! empty($t['role'])) : ?><span class="testimonial-role"><?php echo esc_html($t['role']); ?></span><?php endif; ?>
								</div>

							</div>
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon.png" alt="Icon">
						</div>

						<?php if (! empty($t['quote'])) : ?><blockquote class="testimonial-quote"><?php echo esc_html($t['quote']); ?></blockquote><?php endif; ?>
						<?php
						$rating = isset($t['rating']) ? (int) $t['rating'] : 5;
						if ($rating < 1) {
							$rating = 5;
						}
						?>
						<span class="testimonial-stars" aria-label="<?php echo esc_attr(sprintf(_n('%d star', '%d stars', $rating, 'hvac'), $rating)); ?>">
							<?php for ($s = 0; $s < $rating; $s++) : ?>
								<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<path d="M12 2l3 6.3 6.9.9-5 4.8 1.2 6.8L12 17.8 5.9 20.8 7.1 14 2.1 9.2 9 8.3 12 2z" />
								</svg>
							<?php endfor; ?>
						</span>

					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
/* =============================== NEWS / INSIGHTS =============================== */
$news_eyebrow = hvac_hf('news_eyebrow', 'Blog & News');
$news_heading = hvac_hf('news_heading', 'HVAC Tips & Resources');
$news_subtext = hvac_hf('news_subtext', 'Explore our latest resources to help you understand your heating and cooling options and make informed decisions.');
$news_source  = $hvac_acf ? get_field('news_source') : 'latest';

$news_cards = array();
if ('manual' === $news_source) {
	$manual = ($hvac_acf && have_rows('news_cards')) ? get_field('news_cards') : array();
	foreach ((array) $manual as $mc) {
		$news_cards[] = array(
			'image'    => isset($mc['image']) ? $mc['image'] : false,
			'category' => isset($mc['category']) ? $mc['category'] : '',
			'title'    => isset($mc['title']) ? $mc['title'] : '',
			'date'     => isset($mc['date']) ? $mc['date'] : '',
			'excerpt'  => isset($mc['excerpt']) ? $mc['excerpt'] : '',
			'url'      => ! empty($mc['link']['url']) ? $mc['link']['url'] : '#',
			'target'   => ! empty($mc['link']['target']) ? $mc['link']['target'] : '',
		);
	}
} else {
	$q = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true));
	if ($q->have_posts()) {
		while ($q->have_posts()) {
			$q->the_post();
			$cats = get_the_category();
			$news_cards[] = array(
				'image_id' => get_post_thumbnail_id(),
				'category' => ! empty($cats) ? $cats[0]->name : '',
				'title'    => get_the_title(),
				'date'     => get_the_date(),
				'excerpt'  => wp_trim_words(get_the_excerpt(), 26),
				'url'      => get_permalink(),
				'target'   => '',
			);
		}
	}
	wp_reset_postdata();
}

if (empty($news_cards)) {
	$news_cards = array(
		array('category' => __('Cost Guide', 'hvac'), 'date' => '', 'title' => __('How Much Does HVAC Replacement Cost?', 'hvac'), 'excerpt' => __('Learn about the factors that can affect HVAC replacement costs, including system type, property size, equipment requirements, and installation complexity.', 'hvac'), 'url' => '#', 'target' => ''),
		array('category' => __('Maintenance', 'hvac'), 'date' => '', 'title' => __('When Should You Replace Your HVAC System?', 'hvac'), 'excerpt' => __('Learn about common signs that an aging heating or cooling system may be approaching the end of its useful life and when replacement may make sense.', 'hvac'), 'url' => '#', 'target' => ''),
		array('category' => __('Heat Pumps', 'hvac'), 'date' => '', 'title' => __('Heat Pump vs. Traditional HVAC Systems', 'hvac'), 'excerpt' => __('Understand how heat pumps compare with traditional heating and cooling systems and what factors to consider when choosing a system.', 'hvac'), 'url' => '#', 'target' => ''),
	);
}

$news_featured = array_shift($news_cards);
$news_rest     = array_slice($news_cards, 0, 2);

if (! function_exists('hvac_news_image')) {
	function hvac_news_image($card, $size, $class)
	{
		if (! empty($card['image_id'])) {
			echo wp_get_attachment_image($card['image_id'], $size, false, array('class' => $class));
		} else {
			hvac_acf_image(isset($card['image']) ? $card['image'] : false, $size, $class);
		}
	}
}
?>
<section class="home-news">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($news_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																		?><?php echo esc_html($news_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($news_heading); ?></h2>
				<?php if ($news_subtext) : ?><p class="section-subtext"><?php echo esc_html($news_subtext); ?></p><?php endif; ?>
		</div>

		<div class="news-layout">
			<?php if ($news_featured) : ?>
				<article class="news-featured">
					<a class="news-featured-media" href="<?php echo esc_url($news_featured['url']); ?>" <?php echo hvac_link_target_attrs($news_featured['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																										?>>
						<?php hvac_news_image($news_featured, 'large', 'news-featured-image'); ?>
					</a>
					<h3 class="news-featured-title">
						<a href="<?php echo esc_url($news_featured['url']); ?>" <?php echo hvac_link_target_attrs($news_featured['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																				?>><?php echo esc_html($news_featured['title']); ?></a>
					</h3>
					<?php if (! empty($news_featured['date']) || ! empty($news_featured['category'])) : ?>
						<p class="news-meta">
							<?php echo esc_html(trim(implode(' · ', array_filter(array($news_featured['date'], $news_featured['category']))))); ?>
						</p>
					<?php endif; ?>
					<?php if (! empty($news_featured['excerpt'])) : ?><p class="news-featured-excerpt"><?php echo esc_html($news_featured['excerpt']); ?></p><?php endif; ?>
				</article>
			<?php endif; ?>

			<?php if (! empty($news_rest)) : ?>
				<div class="news-list">
					<?php foreach ($news_rest as $nc) : ?>
						<article class="news-card">
							<a class="news-card-media" href="<?php echo esc_url($nc['url']); ?>" <?php echo hvac_link_target_attrs($nc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																									?>>
								<?php hvac_news_image($nc, 'medium', 'news-card-image'); ?>
							</a>
							<div class="news-card-body">
								<h3 class="news-card-title">
									<a href="<?php echo esc_url($nc['url']); ?>" <?php echo hvac_link_target_attrs($nc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?>><?php echo esc_html($nc['title']); ?></a>
								</h3>
								<?php if (! empty($nc['date'])) : ?><p class="news-meta"><?php echo esc_html($nc['date']); ?></p><?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/* =============================== AREAS WE SERVE =============================== */
$areas_eyebrow = hvac_hf('areas_eyebrow', 'Service Areas');
$areas_heading = hvac_hf('areas_heading', 'Areas We Serve');
$areas_subtext = hvac_hf('areas_subtext', 'HVAC Reliable Pros provides professional heating and cooling installation, replacement, and repair services throughout California, Ohio, Washington, and Florida.');
$areas_items = ($hvac_acf && have_rows('areas_items')) ? get_field('areas_items') : array();
if (empty($areas_items)) {
	$areas_items = array(
		array('title' => __('California', 'hvac'), 'text' => __('Professional HVAC solutions for residential and commercial properties, including AC installation and replacement, HVAC repair, heat pumps, and ductless systems.', 'hvac'), 'link' => array()),
		array('title' => __('Ohio', 'hvac'), 'text' => __('Heating and cooling services including furnace replacement, AC installation and replacement, heat pump solutions, and HVAC repair.', 'hvac'), 'link' => array()),
		array('title' => __('Washington', 'hvac'), 'text' => __('Professional heating and cooling solutions including heat pump installation, furnace replacement, AC services, ductless systems, and HVAC repair.', 'hvac'), 'link' => array()),
		array('title' => __('Florida', 'hvac'), 'text' => __('HVAC services for Florida homes and businesses, including AC installation and replacement, HVAC repair, heat pump solutions, and other heating and cooling services.', 'hvac'), 'link' => array()),
	);
}
?>
<section id="areas-we-serve" class="services-benefits home-areas">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($areas_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($areas_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($areas_heading); ?></h2>
			<?php if ($areas_subtext) : ?><p class="section-subtext"><?php echo esc_html($areas_subtext); ?></p><?php endif; ?>
		</div>
		<ul class="benefits-grid">
			<?php foreach ($areas_items as $ar) : ?>
				<?php if (empty($ar['title']) && empty($ar['text'])) : continue;
				endif; ?>
				<?php
				$ar_link = isset($ar['link']) ? $ar['link'] : array();
				$ar_url  = ! empty($ar_link['url']) ? $ar_link['url'] : '#';
				$ar_tgt  = ! empty($ar_link['target']) ? $ar_link['target'] : '';
				?>
				<li class="benefit-card">
					<span class="benefit-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
					<?php if (! empty($ar['title'])) : ?><h3 class="benefit-title"><?php echo esc_html($ar['title']); ?></h3><?php endif; ?>
					<?php if (! empty($ar['text'])) : ?><p class="benefit-text"><?php echo esc_html($ar['text']); ?></p><?php endif; ?>
					<a class="service-card-link" href="<?php echo esc_url($ar_url); ?>" <?php echo hvac_link_target_attrs($ar_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html(sprintf(__('Explore HVAC Services in %s', 'hvac'), ! empty($ar['title']) ? $ar['title'] : '')); ?>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12" /><polyline points="12 5 19 12 12 19" /></svg>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
/* =============================== CTA BANNER =============================== */
$cta_heading  = hvac_hf('cta_heading', 'Ready for Reliable Heating & Cooling?');
$cta_subtext  = hvac_hf('cta_subtext', 'Whether your property needs a new HVAC system, replacement equipment, or professional repair, HVAC Reliable Pros provides dependable heating and cooling solutions for homes and businesses. Schedule your estimate today and take the next step toward reliable year-round comfort.');
$cta_checklist = ($hvac_acf && have_rows('cta_checklist')) ? get_field('cta_checklist') : array();
if (empty($cta_checklist)) {
	$cta_checklist = array(
		array('text' => __('Free Estimates on Eligible HVAC Projects', 'hvac')),
		array('text' => __('Licensed & Certified HVAC Professionals', 'hvac')),
		array('text' => __('Heating & Cooling Services', 'hvac')),
		array('text' => __('Residential & Commercial HVAC', 'hvac')),
		array('text' => __('Installation, Replacement & Repair', 'hvac')),
		array('text' => __('Professional Workmanship', 'hvac')),
		array('text' => __('Reliable Customer Service', 'hvac')),
	);
}
$cta_button  = $hvac_acf ? get_field('cta_button') : false;
$cta_bg      = $hvac_acf ? get_field('cta_background_image') : false;
$cta_btn_url = ! empty($cta_button['url']) ? $cta_button['url'] : '#';
$cta_btn_txt = ! empty($cta_button['title']) ? $cta_button['title'] : __('Get Your Free HVAC Estimate', 'hvac');
$cta_btn_tgt = ! empty($cta_button['target']) ? $cta_button['target'] : '';
?>
<section class="home-cta">
	<div class="container">
		<div class="home-cta-banner" <?php echo (is_array($cta_bg) && ! empty($cta_bg['url'])) ? ' style="background-image:url(' . esc_url($cta_bg['url']) . ')"' : ''; ?>>
			<div class="location-cta-text">
				<?php if ($cta_heading) : ?><h2 class="home-cta-heading"><?php echo esc_html($cta_heading); ?></h2><?php endif; ?>
				<?php if ($cta_subtext) : ?><p class="location-cta-sub"><?php echo esc_html($cta_subtext); ?></p><?php endif; ?>
				<?php if (! empty($cta_checklist)) : ?>
					<ul class="location-checklist">
						<?php foreach ($cta_checklist as $cc) : ?>
							<?php if (empty($cc['text'])) : continue;
							endif; ?>
							<li>
								<span class="location-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg></span>
								<?php echo esc_html($cc['text']); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<a class="btn-accent home-cta-btn" href="<?php echo esc_url($cta_btn_url); ?>" <?php echo hvac_link_target_attrs($cta_btn_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
																							?>><?php echo esc_html($cta_btn_txt); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
