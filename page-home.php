<?php

/**
 * Template Name: Home Page
 *
 * The landing page (Figma: Landing page UI V1). Every section is editable via
 * the "Home Page" field group (Secure Custom Fields), with Figma-matching
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
 * Render the "Get Your Free HVAC Estimate" card. Uses a form shortcode when
 * provided, otherwise a styled placeholder form.
 */
if (! function_exists('hvac_estimate_form')) {
	function hvac_estimate_form($title, $subtitle, $shortcode)
	{
?>
		<div class="estimate-form">
			<?php if ($title) : ?>
				<h3 class="estimate-form-title"><?php echo esc_html($title); ?></h3>
			<?php endif; ?>
			<?php if ($subtitle) : ?>
				<p class="estimate-form-subtitle"><?php echo esc_html($subtitle); ?></p>
			<?php endif; ?>

			<?php if ($shortcode) : ?>
				<?php echo do_shortcode($shortcode); ?>
			<?php else : ?>
				<form class="estimate-form-fields" method="post" action="#" novalidate>
					<label class="screen-reader-text" for="ef-name"><?php esc_html_e('Full Name', 'hvac'); ?></label>
					<input id="ef-name" type="text" name="full_name" placeholder="<?php esc_attr_e('Full Name', 'hvac'); ?>">

					<label class="screen-reader-text" for="ef-phone"><?php esc_html_e('Phone Number', 'hvac'); ?></label>
					<input id="ef-phone" type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'hvac'); ?>">

					<label class="screen-reader-text" for="ef-service"><?php esc_html_e('Service Type', 'hvac'); ?></label>
					<select id="ef-service" name="service_type">
						<option value=""><?php esc_html_e('Service Type', 'hvac'); ?></option>
						<option><?php esc_html_e('AC Repair', 'hvac'); ?></option>
						<option><?php esc_html_e('Heating Repair', 'hvac'); ?></option>
						<option><?php esc_html_e('Furnace Installation', 'hvac'); ?></option>
						<option><?php esc_html_e('HVAC Maintenance', 'hvac'); ?></option>
						<option><?php esc_html_e('Other', 'hvac'); ?></option>
					</select>

					<label class="screen-reader-text" for="ef-location"><?php esc_html_e('Location', 'hvac'); ?></label>
					<select id="ef-location" name="location">
						<option value=""><?php esc_html_e('Select Location', 'hvac'); ?></option>
						<option><?php esc_html_e('Austin', 'hvac'); ?></option>
						<option><?php esc_html_e('Round Rock', 'hvac'); ?></option>
						<option><?php esc_html_e('Cedar Park', 'hvac'); ?></option>
						<option><?php esc_html_e('Georgetown', 'hvac'); ?></option>
						<option><?php esc_html_e('Other', 'hvac'); ?></option>
					</select>

					<label class="screen-reader-text" for="ef-date"><?php esc_html_e('Preferred Date', 'hvac'); ?></label>
					<input id="ef-date" type="date" name="preferred_date">

					<button type="submit" class="btn estimate-form-submit"><?php esc_html_e('Get My Free Estimate', 'hvac'); ?> &rarr;</button>
				</form>
			<?php endif; ?>
		</div>
<?php
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

get_header();
?>

<?php
/* =============================== HERO =============================== */
$hero_eyebrow = ($hvac_acf && have_rows('hero_eyebrow')) ? get_field('hero_eyebrow') : array();
if (empty($hero_eyebrow)) {
	$hero_eyebrow = array(
		array('text' => __('Book Repair', 'hvac')),
		array('text' => __('Replacement', 'hvac')),
		array('text' => __('Emergency Service', 'hvac')),
	);
}
$hero_bg_img  = get_field('hero_background_image');
$hero_heading  = hvac_hf('hero_heading', 'Trusted HVAC Solutions Across the USA');
$hero_subtext  = hvac_hf('hero_subtext', 'Expert heating and cooling repair, installation, and emergency solutions designed to keep your home comfortable with dependable service and quality workmanship.');
$hero_features = ($hvac_acf && have_rows('hero_features')) ? get_field('hero_features') : array();
if (empty($hero_features)) {
	$hero_features = array(
		array('feature' => __('Free On-Site Inspections', 'hvac')),
		array('feature' => __('No Pressure Quotes', 'hvac')),
		array('feature' => __('Same-Day Service Available', 'hvac')),
	);
}
?>
<section class="home-hero" style="background: url(<?php echo is_array($hero_bg_img) ? $hero_bg_img['url'] : ''; ?>)">
	<div class="container home-hero-inner">
		<div class="home-hero-content">
			<?php if (! empty($hero_eyebrow)) : ?>
				<ul class="hero-eyebrow-list">
					<?php $eb_first = true; ?>
					<?php foreach ($hero_eyebrow as $eb) : ?>
						<?php if (empty($eb['text'])) : continue;
						endif; ?>
						<li class="hero-eyebrow-item">
							<span class="hero-eyebrow-disc<?php echo $eb_first ? ' is-first' : ''; ?>" aria-hidden="true"></span>
							<?php echo esc_html($eb['text']); ?>
						</li>
						<?php $eb_first = false; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<h1 class="hero-heading"><?php echo ($hero_heading); ?></h1>
			<?php if ($hero_subtext) : ?>
				<p class="hero-subtext"><?php echo esc_html($hero_subtext); ?></p>
			<?php endif; ?>

			<?php if (! empty($hero_features)) : ?>
				<ul class="hero-features">
					<?php foreach ($hero_features as $hf) : ?>
						<?php if (empty($hf['feature'])) : continue;
						endif; ?>
						<li>
							<span class="hero-feature-check" aria-hidden="true">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#FD7933" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M9 12L11 14L15 10" stroke="#FD7933" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
								</svg>

							</span>
							<?php echo esc_html($hf['feature']); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="home-hero-form">
			<?php hvac_estimate_form(hvac_hf('hero_form_title', 'Get Your Free HVAC Estimate'), hvac_hf('hero_form_subtitle', 'Fast response. No spam. No obligation.'), hvac_hf('hero_form_shortcode', '')); ?>
		</div>
	</div>
</section>

<?php
/* =============================== TRUST BAR =============================== */
$trust_items = ($hvac_acf && have_rows('trust_items')) ? get_field('trust_items') : array();
if (empty($trust_items)) {
	$trust_items = array(
		array('label' => __('Highly Rated Service', 'hvac')),
		array('label' => __('Licensed & Insured', 'hvac')),
		array('label' => __('25+ Years Experience', 'hvac')),
		array('label' => __('Workmanship Warranty', 'hvac')),
		array('label' => __('Financing Available', 'hvac')),
		array('label' => __('Certified Installers', 'hvac')),
	);
}
?>
<section class="home-trust">
	<div class="container">
		<ul class="trust-list">
			<?php foreach ($trust_items as $ti) : ?>
				<?php if (empty($ti['label'])) : continue;
				endif; ?>
				<li>
					<?php if (!empty($ti['icon'])) : ?>
						<span class="trust-icon" aria-hidden="true"><?php hvac_acf_image($ti['icon'], 'thumbnail', 'trust-icon-img'); ?></span>
					<?php else : ?>
						<span class="trust-check" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
								<polyline points="20 6 9 17 4 12" />
							</svg>
						</span>
					<?php endif; ?>
					<?php echo esc_html($ti['label']); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
/* =============================== ABOUT =============================== */
$about_eyebrow = hvac_hf('about_eyebrow', 'About Us');
$about_heading = hvac_hf('about_heading', 'Trusted HVAC Solutions,<br> Built Around Your Needs.');
$about_text    = hvac_hf('about_text', '');
$about_image   = $hvac_acf ? get_field('about_image') : false;
if (! $about_text) {
	$about_text = wpautop(__('HVAC Relief Pros helps homeowners across the USA find reliable heating and cooling solutions for repairs, installations, tune-ups, and more. We focus on making every step simple, from understanding your comfort needs to getting the right professionals for the job. Whether you\'re dealing with a sudden breakdown, an aging system, or planning a full replacement, we\'re here to help. Our goal is to deliver dependable service, quality workmanship, and lasting comfort for your home.', 'hvac'));
}
?>
<section class="home-about">
	<div class="container home-about-inner">
		<div class="home-about-content">
			<?php if ($about_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($about_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo ($about_heading); ?></h2>
			<div class="home-about-text"><?php echo wp_kses_post($about_text); ?></div>
		</div>
		<div class="home-about-media">
			<?php hvac_acf_image($about_image, 'large', 'home-about-image'); ?>
		</div>
	</div>
</section>

<?php
/* =============================== SERVICES =============================== */
$services_eyebrow = hvac_hf('services_eyebrow', 'Our Services');
$services_heading = hvac_hf('services_heading', 'Complete HVAC Solutions for Every Home');
$services_subtext = hvac_hf('services_subtext', 'From minor repairs to complete system replacements, we help homeowners find reliable HVAC solutions designed to keep their homes comfortable for years to come.');
$services = ($hvac_acf && have_rows('services')) ? get_field('services') : array();
if (empty($services)) {
	$services = array(
		array(
			'title' => __('Fast & Reliable AC Repair', 'hvac'),
			'text'  => __('Fix refrigerant leaks, faulty compressors, and other cooling problems before they become costly repairs.', 'hvac'),
		),
		array(
			'title' => __('Complete Furnace & Heating Installation', 'hvac'),
			'text'  => __('Upgrade your home with a durable new heating system designed for lasting comfort, performance, and efficiency.', 'hvac'),
		),
		array(
			'title' => __('Emergency HVAC Service', 'hvac'),
			'text'  => __('Get help with sudden heating or cooling breakdowns caused by extreme weather with fast, dependable solutions.', 'hvac'),
		),
		array(
			'title' => __('Professional HVAC Inspection', 'hvac'),
			'text'  => __('Identify hidden wear, leaks, and potential efficiency issues with a thorough inspection of your heating and cooling system.', 'hvac'),
		),
	);
}
?>
<section class="home-services">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($services_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($services_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($services_heading); ?></h2>
			<?php if ($services_subtext) : ?><p class="section-subtext"><?php echo esc_html($services_subtext); ?></p><?php endif; ?>
		</div>

		<div class="services-grid">
			<?php foreach ($services as $svc) : ?>
				<article class="service-card">
					<div class="service-card-media">
						<?php hvac_acf_image(isset($svc['image']) ? $svc['image'] : false, 'large', 'service-card-image'); ?>
					</div>
					<div class="service-card-body">
						<?php if (! empty($svc['title'])) : ?><h3 class="service-card-title"><?php echo esc_html($svc['title']); ?></h3><?php endif; ?>
						<?php if (! empty($svc['text'])) : ?><p class="service-card-text"><?php echo esc_html($svc['text']); ?></p><?php endif; ?>
						<?php
						$svc_link = isset($svc['link']) ? $svc['link'] : false;
						$svc_url  = ! empty($svc_link['url']) ? $svc_link['url'] : '#';
						$svc_tgt  = ! empty($svc_link['target']) ? $svc_link['target'] : '';
						$svc_txt  = ! empty($svc_link['title']) ? $svc_link['title'] : __('Learn More', 'hvac');
						?>
						<a class="service-card-link" href="<?php echo esc_url($svc_url); ?>" <?php echo hvac_link_target_attrs($svc_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																								?>><?php echo esc_html($svc_txt); ?> <svg width="22" height="11" viewBox="0 0 22 11" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M16.0414 0.261337C15.7066 0.60859 15.7079 1.17026 16.0443 1.51587L19.0591 4.6129L0.859374 4.6129C0.384742 4.6129 -2.88012e-07 5.01006 -2.64454e-07 5.5C-2.40896e-07 5.98994 0.384742 6.3871 0.859374 6.3871L19.0591 6.3871L16.0443 9.48413C15.7079 9.82974 15.7066 10.3914 16.0414 10.7387C16.3762 11.086 16.9204 11.0872 17.2568 10.7417L21.7472 6.12877C21.7475 6.12851 21.7477 6.1282 21.7479 6.12793C22.0835 5.78232 22.0846 5.21883 21.748 4.87207C21.7477 4.8718 21.7475 4.87149 21.7472 4.87123L17.2568 0.25832C16.9204 -0.0872037 16.3763 -0.0860068 16.0414 0.261337Z" fill="#FE6310" />
							</svg>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== STATS =============================== */
$stats_eyebrow = hvac_hf('stats_eyebrow', 'Why Choose Us');

$stats_heading = hvac_hf('stats_heading', 'Trusted HVAC Support Across the USA');
$stats = ($hvac_acf && have_rows('stats')) ? get_field('stats') : array();
if (empty($stats)) {
	$stats = array(
		array('value' => '50+', 'label' => __('States Covered', 'hvac')),
		array('value' => '24/7', 'label' => __('HVAC Support', 'hvac')),
		array('value' => '100%', 'label' => __('Customer-Focused Service', 'hvac')),
	);
}
?>
<section class="home-stats stats-center-eybrow">
	<div class="container">
		<?php if ($stats_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($stats_eyebrow); ?></span><?php endif; ?>
		<?php if ($stats_heading) : ?><h2 class="home-stats-heading"><?php echo esc_html($stats_heading); ?></h2><?php endif; ?>
		<div class="stats-grid">
			<?php foreach ($stats as $st) : ?>
				<div class="stat-item">
					<span class="stat-value"><?php echo ($st['value']); ?></span>
					<span class="stat-label"><?php echo esc_html($st['label']); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== SERVICE AREAS =============================== */
$areas_eyebrow = hvac_hf('areas_eyebrow', 'Service Areas');
$areas_heading = hvac_hf('areas_heading', 'Reliable HVAC Services Across the USA.');
$areas_text    = hvac_hf('areas_text', 'HVAC Relief Pros connects homeowners across the USA with dependable heating and cooling solutions. From major cities to growing communities, we make it easier to find trusted help for repairs, installations, tune-ups, and emergency HVAC needs.');
$areas_button  = $hvac_acf ? get_field('areas_button') : false;
$areas_image   = $hvac_acf ? get_field('areas_image') : false;
?>
<section class="home-areas">
	<div class="container home-areas-inner">
		<div class="home-areas-content">
			<?php if ($areas_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($areas_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($areas_heading); ?></h2>
			<?php if ($areas_text) : ?><p class="home-areas-text"><?php echo ($areas_text); ?></p><?php endif; ?>
			<?php if (! empty($areas_button['url'])) : ?>
				<a class="btn" href="<?php echo esc_url($areas_button['url']); ?>" <?php echo hvac_link_target_attrs(! empty($areas_button['target']) ? $areas_button['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?>><?php echo esc_html(! empty($areas_button['title']) ? $areas_button['title'] : __('Explore Service Areas', 'hvac')); ?> <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0.75 6.75H13.25M7.25 12.75L13.25 6.75L7.25 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			<?php else : ?>
				<a class="btn" href="#"><?php esc_html_e('Explore Service Areas', 'hvac'); ?> <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0.75 6.75H13.25M7.25 12.75L13.25 6.75L7.25 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			<?php endif; ?>
		</div>
		<div class="home-areas-media">
			<?php hvac_acf_image($areas_image, 'large', 'home-areas-image'); ?>
		</div>
	</div>
</section>

<?php
/* =============================== BLOG / TIPS =============================== */
$blog_eyebrow = hvac_hf('blog_eyebrow', 'From Our Blog');
$blog_heading = hvac_hf('blog_heading', 'HVAC Tips & Insights for a Comfortable Home');
$blog_subtext = hvac_hf('blog_subtext', 'Get practical HVAC advice, maintenance tips, and expert insights to help keep your home comfortable and make smarter system decisions.');
$blog_source  = $hvac_acf ? get_field('blog_source') : 'latest';

// Build a normalised list of cards.
$blog_cards = array();
if ('manual' === $blog_source) {
	$manual = ($hvac_acf && have_rows('blog_cards')) ? get_field('blog_cards') : array();
	foreach ((array) $manual as $mc) {
		$blog_cards[] = array(
			'image'    => isset($mc['image']) ? $mc['image'] : false,
			'category' => isset($mc['category']) ? $mc['category'] : '',
			'title'    => isset($mc['title']) ? $mc['title'] : '',
			'url'      => ! empty($mc['link']['url']) ? $mc['link']['url'] : '#',
			'target'   => ! empty($mc['link']['target']) ? $mc['link']['target'] : '',
		);
	}
} else {
	$q = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ($q->have_posts()) {
		while ($q->have_posts()) {
			$q->the_post();
			$cats     = get_the_category();
			$blog_cards[] = array(
				'image_id' => get_post_thumbnail_id(),
				'category' => ! empty($cats) ? $cats[0]->name : '',
				'title'    => get_the_title(),
				'url'      => get_permalink(),
				'target'   => '',
			);
		}
	}
	wp_reset_postdata();
}

// Fallback demo cards if nothing available.
if (empty($blog_cards)) {
	$blog_cards = array(
		array('category' => __('HVAC Maintenance', 'hvac'), 'title' => __('5 Warning Signs Your HVAC System Needs Immediate Attention', 'hvac'), 'url' => '#', 'target' => ''),
		array('category' => __('Emergency Service', 'hvac'), 'title' => __('What to Do When Your AC or Furnace Breaks Down', 'hvac'), 'url' => '#', 'target' => ''),
		array('category' => __('HVAC Guide', 'hvac'), 'title' => __('How to Choose the Right HVAC System for Your Home', 'hvac'), 'url' => '#', 'target' => ''),
		array('category' => __('System Replacement', 'hvac'), 'title' => __('Repair or Replace? How to Know What\'s Right for Your HVAC System', 'hvac'), 'url' => '#', 'target' => ''),
	);
}
?>
<section class="home-blog">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($blog_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($blog_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($blog_heading); ?></h2>
			<?php if ($blog_subtext) : ?><p class="section-subtext"><?php echo esc_html($blog_subtext); ?></p><?php endif; ?>
		</div>

		<?php $blog_is_slider = ( count( $blog_cards ) > 3 ); ?>
		<div class="blog-slider<?php echo $blog_is_slider ? ' is-slider' : ''; ?>" data-blog-slider>
		<div class="blog-grid" data-blog-track>
			<?php foreach ($blog_cards as $bc) : ?>
				<article class="blog-card">
					<a class="blog-card-media" href="<?php echo esc_url($bc['url']); ?>" <?php echo hvac_link_target_attrs($bc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																							?>>
						<?php
						if (! empty($bc['image_id'])) {
							echo wp_get_attachment_image($bc['image_id'], 'medium_large', false, array('class' => 'blog-card-image'));
						} else {
							hvac_acf_image(isset($bc['image']) ? $bc['image'] : false, 'medium_large', 'blog-card-image');
						}
						?>
					</a>
					<div class="blog-card-body">
						<?php if (! empty($bc['category'])) : ?><span class="blog-card-cat"><?php echo esc_html($bc['category']); ?></span><?php endif; ?>
						<h3 class="blog-card-title">
							<a href="<?php echo esc_url($bc['url']); ?>" <?php echo hvac_link_target_attrs($bc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																			?>><?php echo esc_html($bc['title']); ?></a>
						</h3>
						<a class="blog-card-link" href="<?php echo esc_url($bc['url']); ?>" <?php echo hvac_link_target_attrs($bc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																							?>><?php esc_html_e('Read Blog', 'hvac'); ?> <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 5.71429V4.28571H9L6 1.42857L6.75 0L12 5L6.75 10L6 8.57143L9 5.71429H0Z" fill="#FE6310" />
							</svg>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<?php if ( $blog_is_slider ) : ?>
			<div class="blog-nav">
				<button class="blog-nav-btn blog-nav-prev" type="button" data-blog-prev aria-label="<?php esc_attr_e( 'Previous posts', 'hvac' ); ?>">
					<svg width="77" height="18" viewBox="0 0 77 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M76.5 10.2857V7.71429H5.38096L10.7619 2.57143L9.41667 0L0 9L9.41667 18L10.7619 15.4286L5.38096 10.2857H76.5Z" fill="currentColor"/></svg>
				</button>
				<button class="blog-nav-btn blog-nav-next" type="button" data-blog-next aria-label="<?php esc_attr_e( 'Next posts', 'hvac' ); ?>">
					<svg width="77" height="18" viewBox="0 0 77 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 10.2857V7.71429H71.119L65.7381 2.57143L67.0833 0L76.5 9L67.0833 18L65.7381 15.4286L71.119 10.2857H0Z" fill="currentColor"/></svg>
				</button>
			</div>
		<?php endif; ?>
		</div><!-- .blog-slider -->
	</div>
</section>

<?php
/* =============================== FAQ =============================== */
$faq_eyebrow = hvac_hf('faq_eyebrow', 'FAQ');
$faq_heading = hvac_hf('faq_heading', 'HVAC Questions? We\'ve Got You Covered.');
$faqs = ($hvac_acf && have_rows('faqs')) ? get_field('faqs') : array();
if (empty($faqs)) {
	$faqs = array(
		array('question' => __('How do I know if my HVAC system needs repair or replacement?', 'hvac'), 'answer' => __('Frequent breakdowns, rising energy bills, uneven heating or cooling, unusual noises, or an aging system can signal a bigger problem. A professional inspection can help determine whether a repair is enough or a full replacement is the better long-term option.', 'hvac')),
		array('question' => __('How long does a furnace or AC replacement take?', 'hvac'), 'answer' => __('Most residential HVAC replacements take one to two days depending on the system type, home size, and any ductwork changes needed.', 'hvac')),
		array('question' => __('How much does a new HVAC system typically cost?', 'hvac'), 'answer' => __('Costs vary based on system size, efficiency rating, and complexity. We provide a clear, itemised estimate after a free on-site inspection.', 'hvac')),
		array('question' => __('Do you provide free HVAC estimates?', 'hvac'), 'answer' => __('Yes. Every estimate is free and comes with honest recommendations and no obligation.', 'hvac')),
		array('question' => __('Can you help with emergency heating or cooling issues?', 'hvac'), 'answer' => __('Absolutely. We offer fast emergency response and work quickly to restore comfort to your home, day or night.', 'hvac')),
	);
}
$faq_count = count($faqs);
$faq_split = (int) floor($faq_count / 2); // left column gets the smaller half (e.g. 2 of 5)
$faq_cols  = array(array_slice($faqs, 0, $faq_split), array_slice($faqs, $faq_split));
$faq_first = true; // the very first item stays open by default
?>
<section class="home-faq">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($faq_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($faq_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($faq_heading); ?></h2>
		</div>
		<div class="faq-grid">
			<?php foreach ($faq_cols as $col) : ?>
				<div class="faq-col">
					<?php foreach ($col as $fq) : ?>
						<?php if (empty($fq['question'])) : continue;
						endif; ?>
						<details class="faq-item"<?php echo $faq_first ? ' open' : ''; ?>>
							<summary class="faq-question">
								<span class="faq-icon" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.75" stroke-linecap="round" stroke-linejoin="round"><line class="faq-icon-v" x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
								</span>
								<span class="faq-question-text"><?php echo esc_html($fq['question']); ?></span>
							</summary>
							<?php if (! empty($fq['answer'])) : ?>
								<div class="faq-answer"><?php echo wp_kses_post(wpautop($fq['answer'])); ?></div>
							<?php endif; ?>
						</details>
						<?php $faq_first = false; ?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* =============================== FINAL CTA =============================== */
$cta_eyebrow = hvac_hf('cta_eyebrow', 'Ready to Get Started?');

$cta_heading = hvac_hf('cta_heading', 'Not Sure What Your HVAC System Needs?');
$cta_text    = hvac_hf('cta_text', 'Schedule a professional HVAC inspection and get clear, honest recommendations from our HVAC experts — free, no obligation.');
$cta_phone   = hvac_hf('cta_phone', '(512) 555-0199');
$cta_tel     = preg_replace('/[^0-9+]/', '', $cta_phone);
?>
<section class="home-cta">
	<div class="container home-cta-inner">
		<div class="home-cta-content">
			<?php if ($cta_eyebrow) : ?><span class="section-eyebrow"><?php echo esc_html($cta_eyebrow); ?></span><?php endif; ?>

			<h2 class="home-cta-heading"><?php echo esc_html($cta_heading); ?></h2>
			<?php if ($cta_text) : ?><p class="home-cta-text"><?php echo esc_html($cta_text); ?></p><?php endif; ?>
			<?php if ($cta_phone) : ?>
				<p class='cta-phone-instruction'>Prefer to talk? Available 24/7 for emergencies.</p>
				<a class="home-cta-phone" href="tel:<?php echo esc_attr($cta_tel); ?>">
					<span class="header-cta-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
						</svg>
					</span>
					<?php echo esc_html($cta_phone); ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="home-cta-form">
			<?php hvac_estimate_form(hvac_hf('cta_form_title', 'Get Your Free HVAC Estimate'), hvac_hf('cta_form_subtitle', 'Fast response. No spam. No obligation.'), hvac_hf('cta_form_shortcode', '')); ?>
		</div>
	</div>
</section>

<?php
get_footer();
