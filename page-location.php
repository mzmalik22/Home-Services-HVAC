<?php

/**
 * Template Name: Location
 *
 * A location landing page matching the theme's V2 design: hero + estimate form,
 * intro with stats, services, why-us, local insight, projects gallery, reviews,
 * service area with map, and CTA. Every section is editable via the "Location
 * Page" field group (SCF), with California HVAC defaults.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

if (! function_exists('hvac_lc')) {
	function hvac_lc($name, $fallback = '')
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
if (! function_exists('hvac_lc_rows')) {
	function hvac_lc_rows($name)
	{
		return (function_exists('have_rows') && have_rows($name)) ? get_field($name) : array();
	}
}

get_header();

/* ---- data + defaults ---- */
$lc_heading  = hvac_lc('loc_hero_heading', __("California's Trusted Local AC & Heating Experts", 'hvac'));
$lc_subtext  = hvac_lc('loc_hero_subtext', __('From emergency repairs to full system replacements, homeowners across California rely on our licensed local technicians for honest advice, quality workmanship, and cooling built to last.', 'hvac'));
$lc_bg       = $hvac_acf ? get_field('loc_hero_bg') : false;
$lc_badges   = hvac_lc_rows('loc_hero_badges');
if (empty($lc_badges)) {
	$lc_badges = array(array('label' => __('California', 'hvac')), array('label' => __('Free Estimate', 'hvac')), array('label' => __('Locally Trusted', 'hvac')));
}
$lc_points   = hvac_lc_rows('loc_hero_points');
if (empty($lc_points)) {
	$lc_points = array(array('text' => __('Local, Licensed & Insured Technicians', 'hvac')), array('text' => __('Free On-Site Estimates', 'hvac')), array('text' => __('Same-Day & Emergency Service', 'hvac')));
}
$lc_form_head = hvac_lc('loc_form_heading', __('Get Your Free California AC Estimate', 'hvac'));
$lc_form_sub  = hvac_lc('loc_form_subtitle', __('Fast response. No spam. No obligation.', 'hvac'));
$lc_form_btn  = hvac_lc('loc_form_button', __('Get My Free Estimate', 'hvac'));
$lc_form_sc   = hvac_lc('loc_form_shortcode', '');
$lc_form_opts = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) hvac_lc('loc_form_services', "AC Repair\nAC Installation\nAC Maintenance\nEmergency Service\nIndoor Air Quality"))));

$lc_in_eyebrow = hvac_lc('loc_intro_eyebrow', __('AC Services in California', 'hvac'));
$lc_in_heading = hvac_lc('loc_intro_heading', __('Dependable Heating & Cooling in California', 'hvac'));
$lc_in_text    = hvac_lc('loc_intro_text', wpautop(__('For years, California homeowners and businesses have trusted our team for reliable residential and commercial HVAC. As a local company, we know exactly how California\'s climate affects your system — and we service every job to stand up to it. From your first free estimate to the final check, we treat your home like our own and back our work with a solid warranty.', 'hvac')));
$lc_in_image   = $hvac_acf ? get_field('loc_intro_image') : false;
$lc_stats      = hvac_lc_rows('loc_stats');
if (empty($lc_stats)) {
	$lc_stats = array(array('value' => '15+', 'label' => __('Years Serving California', 'hvac')), array('value' => '5,000+', 'label' => __('Systems Serviced', 'hvac')), array('value' => '4.9', 'label' => __('Average Star Rating', 'hvac')));
}

$lc_sv_eyebrow = hvac_lc('loc_services_eyebrow', __('What We Offer', 'hvac'));
$lc_sv_heading = hvac_lc('loc_services_heading', __('Complete AC Services in California', 'hvac'));
$lc_sv_subtext = hvac_lc('loc_services_subtext', __('Whatever your system needs, our local California team has you covered — for homes and businesses alike.', 'hvac'));
// Services are pulled from the "Service" CPT. An optional relationship curates
// which services show (and order); otherwise the latest N are shown.
$lc_sv_selected = $hvac_acf ? get_field('loc_services_selected') : array();
$lc_sv_selected = is_array($lc_sv_selected) ? array_map('intval', array_filter($lc_sv_selected)) : array();
$lc_sv_count    = (int) hvac_lc('loc_services_count', 6);
if ($lc_sv_count < 1) {
	$lc_sv_count = 6;
}
$lc_sv_args = array(
	'post_type'           => 'service',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if (! empty($lc_sv_selected)) {
	$lc_sv_args['post__in']       = $lc_sv_selected;
	$lc_sv_args['orderby']        = 'post__in';
	$lc_sv_args['posts_per_page'] = count($lc_sv_selected);
} else {
	$lc_sv_args['posts_per_page'] = $lc_sv_count;
}
$lc_services_q = new WP_Query($lc_sv_args);

// Fallback demo cards shown only when no Service posts exist yet.
$lc_sv_fallback = array(
	array('title' => __('Emergency AC Repair', 'hvac'), 'text' => __('Breakdowns don\'t wait for business hours. Our 24/7 emergency team restores your comfort fast, any time of day.', 'hvac')),
	array('title' => __('AC Maintenance & Tune-Ups', 'hvac'), 'text' => __('Seasonal tune-ups catch small issues early, improve efficiency, and extend the life of your system.', 'hvac')),
	array('title' => __('AC Repair', 'hvac'), 'text' => __('From weak airflow to refrigerant leaks, we diagnose the real problem and fix it right the first time.', 'hvac')),
	array('title' => __('AC Installation & Replacement', 'hvac'), 'text' => __('A full replacement with the right-sized, high-efficiency system, managed from estimate to final cleanup.', 'hvac')),
	array('title' => __('Indoor Air Quality', 'hvac'), 'text' => __('Improve the air you breathe with filtration, duct cleaning, and humidity control tailored to your home.', 'hvac')),
	array('title' => __('Commercial HVAC', 'hvac'), 'text' => __('Reliable cooling and maintenance programs for businesses and property managers across California.', 'hvac')),
);

$lc_wy_eyebrow = hvac_lc('loc_why_eyebrow', __('Why Choose Us', 'hvac'));
$lc_wy_heading = hvac_lc('loc_why_heading', __('Why California Homeowners Choose Us', 'hvac'));
$lc_wy_subtext = hvac_lc('loc_why_subtext', __('We combine local know-how with certified craftsmanship to make heating and cooling simple, honest, and stress-free.', 'hvac'));
$lc_why        = hvac_lc_rows('loc_why_points');
if (empty($lc_why)) {
	$lc_why = array(
		array('title' => __('25+ Years of Local Experience', 'hvac'), 'text' => __('Decades of HVAC work right here in California means we know exactly what your home needs.', 'hvac')),
		array('title' => __('Certified & Insured Technicians', 'hvac'), 'text' => __('Manufacturer-certified crews who meet the highest standards for quality and reliability.', 'hvac')),
		array('title' => __('Hundreds of 5-Star Reviews', 'hvac'), 'text' => __('California homeowners consistently rate our workmanship, honesty, and service five stars.', 'hvac')),
		array('title' => __('Free, Honest Estimates', 'hvac'), 'text' => __('Straightforward recommendations with no pressure and no obligation — always free.', 'hvac')),
	);
}

$lc_is_eyebrow = hvac_lc('loc_insight_eyebrow', __('Local Insight', 'hvac'));
$lc_is_heading = hvac_lc('loc_insight_heading', __('What Affects Your AC in California', 'hvac'));
$lc_is_text    = hvac_lc('loc_insight_text', __('California\'s climate is tough on cooling systems. Knowing what to watch for helps you protect your comfort before small issues become expensive ones.', 'hvac'));
$lc_insight    = hvac_lc_rows('loc_insight_items');
if (empty($lc_insight)) {
	$lc_insight = array(
		array('title' => __('Intense Heat & Sun', 'hvac'), 'text' => __('Long, hot California summers overwork systems and accelerate wear on key components.', 'hvac')),
		array('title' => __('Coastal Salt Air', 'hvac'), 'text' => __('Near the coast, salty air corrodes condenser coils and outdoor units over time.', 'hvac')),
		array('title' => __('Wildfire Smoke & Dust', 'hvac'), 'text' => __('Smoke and airborne dust clog filters fast and strain airflow and indoor air quality.', 'hvac')),
		array('title' => __('Hard Water & Minerals', 'hvac'), 'text' => __('Mineral buildup affects condensate drainage and efficiency if left unchecked.', 'hvac')),
		array('title' => __('Power Fluctuations', 'hvac'), 'text' => __('Grid strain and surges during heat waves can stress compressors and electronics.', 'hvac')),
		array('title' => __('Wide Temperature Swings', 'hvac'), 'text' => __('Hot days and cool nights make systems cycle harder, speeding up general wear.', 'hvac')),
	);
}

$lc_pr_eyebrow = hvac_lc('loc_projects_eyebrow', __('Our Work', 'hvac'));
$lc_pr_heading = hvac_lc('loc_projects_heading', __('Recent California AC Projects', 'hvac'));
$lc_pr_text    = hvac_lc('loc_projects_text', __('A look at some of the systems we have recently installed and serviced for homeowners and businesses around California.', 'hvac'));
$lc_projects   = hvac_lc_rows('loc_projects');

$lc_rv_eyebrow = hvac_lc('loc_reviews_eyebrow', __('Reviews', 'hvac'));
$lc_rv_heading = hvac_lc('loc_reviews_heading', __('What California Homeowners Say', 'hvac'));
$lc_reviews    = hvac_lc_rows('loc_reviews');
if (empty($lc_reviews)) {
	$lc_reviews = array(
		array('name' => __('Michael Torres', 'hvac'), 'role' => __('Homeowner, California', 'hvac'), 'rating' => 5, 'quote' => __('They fixed our AC during a brutal heat wave and handled everything professionally. Punctual, honest, and the system runs better than ever.', 'hvac')),
		array('name' => __('Rachel Green', 'hvac'), 'role' => __('Homeowner, Los Angeles', 'hvac'), 'rating' => 5, 'quote' => __('Honest inspection, fair pricing, and no pressure at all. The crew was respectful of our home and cleaned up perfectly. Highly recommend.', 'hvac')),
		array('name' => __('Luis Barrera', 'hvac'), 'role' => __('Business Owner, San Diego', 'hvac'), 'rating' => 5, 'quote' => __('We use them for both our home and commercial building. Same great quality and communication every time. A local company you can trust.', 'hvac')),
	);
}

$lc_cta_head = hvac_lc('loc_cta_heading', __('Get Your Free California AC Inspection Today', 'hvac'));
$lc_cta_text = hvac_lc('loc_cta_text', __('Schedule a free, no-obligation inspection with our local California team and get honest recommendations you can trust.', 'hvac'));
$lc_cta_btn  = $hvac_acf ? get_field('loc_cta_button') : false;

/* Reusable estimate form. */
if (! function_exists('hvac_lc_form')) {
	function hvac_lc_form($heading, $subtitle, $button, $options, $shortcode)
	{
		?>
		<div class="booking-form">
			<?php if ($heading) : ?><h2 class="booking-form-title"><?php echo esc_html($heading); ?></h2><?php endif; ?>
			<?php if ($subtitle) : ?><p class="booking-form-subtitle"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
			<?php if ($shortcode) : ?>
				<?php echo do_shortcode($shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<form class="booking-form-fields" method="post" action="#" novalidate>
					<input type="text" name="name" placeholder="<?php esc_attr_e('Full Name', 'hvac'); ?>">
					<input type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'hvac'); ?>">
					<select name="service">
						<option value=""><?php esc_html_e('Service Type', 'hvac'); ?></option>
						<?php foreach ($options as $opt) : ?><option><?php echo esc_html($opt); ?></option><?php endforeach; ?>
					</select>
					<input type="date" name="preferred_date">
					<button type="submit" class="btn-accent booking-form-submit"><?php echo esc_html($button); ?></button>
				</form>
			<?php endif; ?>
		</div>
		<?php
	}
}
?>

<section class="home-hero location-hero"<?php echo (is_array($lc_bg) && ! empty($lc_bg['url'])) ? ' style="background-image:url(' . esc_url($lc_bg['url']) . ')"' : ''; ?>>
	<div class="container home-hero-inner">
		<div class="home-hero-content">
			<?php if (! empty($lc_badges)) : ?>
				<ul class="location-badges">
					<?php foreach ($lc_badges as $b) : ?>
						<?php if (empty($b['label'])) : continue;
						endif; ?>
						<li class="location-badge"><?php echo esc_html($b['label']); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<h1 class="hero-heading"><?php echo esc_html($lc_heading); ?></h1>
			<?php if ($lc_subtext) : ?><p class="hero-subtext"><?php echo esc_html($lc_subtext); ?></p><?php endif; ?>
			<?php if (! empty($lc_points)) : ?>
				<ul class="location-checklist">
					<?php foreach ($lc_points as $p) : ?>
						<?php if (empty($p['text'])) : continue;
						endif; ?>
						<li>
							<span class="location-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg></span>
							<?php echo esc_html($p['text']); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="home-hero-form">
			<?php hvac_lc_form($lc_form_head, $lc_form_sub, $lc_form_btn, $lc_form_opts, $lc_form_sc); ?>
		</div>
	</div>
</section>

<section class="service-overview">
	<div class="container service-overview-inner">
		<div class="service-overview-content">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_in_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($lc_in_heading); ?></h2>
			<div class="service-overview-text"><?php echo wp_kses_post($lc_in_text); ?></div>
			<?php if (! empty($lc_stats)) : ?>
				<ul class="location-stats">
					<?php foreach ($lc_stats as $st) : ?>
						<?php if (empty($st['value']) && empty($st['label'])) : continue;
						endif; ?>
						<li>
							<span class="location-stat-value"><?php echo esc_html($st['value']); ?></span>
							<span class="location-stat-label"><?php echo esc_html($st['label']); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="service-overview-media">
			<?php hvac_acf_image($lc_in_image, 'large', 'service-overview-image'); ?>
		</div>
	</div>
</section>

<section class="home-services">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_sv_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($lc_sv_heading); ?></h2>
			<?php if ($lc_sv_subtext) : ?><p class="section-subtext"><?php echo esc_html($lc_sv_subtext); ?></p><?php endif; ?>
		</div>
		<div class="services-grid">
			<?php if ($lc_services_q->have_posts()) : ?>
				<?php while ($lc_services_q->have_posts()) : $lc_services_q->the_post(); ?>
					<?php $lc_badge = $hvac_acf ? get_field('service_badge') : ''; ?>
					<article class="service-card">
						<a class="service-card-media" href="<?php the_permalink(); ?>">
							<?php
							if (has_post_thumbnail()) {
								the_post_thumbnail('large', array('class' => 'service-card-image'));
							} else {
								echo '<span class="img-placeholder service-card-image" aria-hidden="true"></span>';
							}
							?>
							<?php if ($lc_badge) : ?>
								<span class="service-card-badge">
									<span class="service-card-badge-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg></span>
									<?php echo esc_html($lc_badge); ?>
								</span>
							<?php endif; ?>
						</a>
						<div class="service-card-body">
							<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php $lc_svc_excerpt = get_the_excerpt(); ?>
							<?php if ($lc_svc_excerpt) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($lc_svc_excerpt, 20)); ?></p><?php endif; ?>
							<a class="service-card-link" href="<?php the_permalink(); ?>">
								<?php esc_html_e('Learn More', 'hvac'); ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12" /><polyline points="12 5 19 12 12 19" /></svg>
							</a>
						</div>
					</article>
				<?php endwhile;
				wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ($lc_sv_fallback as $svc) : ?>
					<article class="service-card">
						<div class="service-card-media">
							<span class="img-placeholder service-card-image" aria-hidden="true"></span>
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

<section class="service-whyus">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_wy_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($lc_wy_heading); ?></h2>
			<?php if ($lc_wy_subtext) : ?><p class="section-subtext whyus-lead"><?php echo esc_html($lc_wy_subtext); ?></p><?php endif; ?>
		</div>
		<div class="whyus-grid">
			<?php
			$lc_why_icons = array(
				'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M8.5 13 7 22l5-3 5 3-1.5-9"/></svg>',
				'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
				'<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3 6.3 6.9.9-5 4.8 1.2 6.8L12 17.8 5.9 20.8 7.1 14 2.1 9.2 9 8.3 12 2z"/></svg>',
				'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
			);
			$lc_wi = 0;
			?>
			<?php foreach ($lc_why as $pt) : ?>
				<?php if (empty($pt['title']) && empty($pt['text'])) : continue;
				endif; ?>
				<article class="whyus-card">
					<span class="whyus-card-icon" aria-hidden="true"><?php echo $lc_why_icons[$lc_wi % 4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if (! empty($pt['title'])) : ?><h3 class="whyus-card-title"><?php echo esc_html($pt['title']); ?></h3><?php endif; ?>
					<?php if (! empty($pt['text'])) : ?><p class="whyus-card-text"><?php echo esc_html($pt['text']); ?></p><?php endif; ?>
				</article>
				<?php $lc_wi++; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="services-benefits">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_is_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($lc_is_heading); ?></h2>
			<?php if ($lc_is_text) : ?><p class="section-subtext"><?php echo esc_html($lc_is_text); ?></p><?php endif; ?>
		</div>
		<ul class="benefits-grid">
			<?php foreach ($lc_insight as $it) : ?>
				<?php if (empty($it['title']) && empty($it['text'])) : continue;
				endif; ?>
				<li class="benefit-card">
					<span class="benefit-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a7 7 0 0 0-7 7c0 3 2 5 2 8h10c0-3 2-5 2-8a7 7 0 0 0-7-7z"/><line x1="9" y1="21" x2="15" y2="21"/></svg></span>
					<?php if (! empty($it['title'])) : ?><h3 class="benefit-title"><?php echo esc_html($it['title']); ?></h3><?php endif; ?>
					<?php if (! empty($it['text'])) : ?><p class="benefit-text"><?php echo esc_html($it['text']); ?></p><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php if (! empty($lc_projects)) : ?>
	<section class="location-projects">
		<div class="container">
			<div class="section-head section-head-center">
				<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_pr_eyebrow); ?></span>
				<h2 class="section-heading"><?php echo esc_html($lc_pr_heading); ?></h2>
				<?php if ($lc_pr_text) : ?><p class="section-subtext"><?php echo esc_html($lc_pr_text); ?></p><?php endif; ?>
			</div>
			<div class="location-gallery">
				<?php foreach ($lc_projects as $pr) : ?>
					<?php if (empty($pr['image'])) : continue;
					endif; ?>
					<div class="gallery-item"><?php hvac_acf_image($pr['image'], 'large', 'gallery-image'); ?></div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="home-testimonials">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($lc_rv_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($lc_rv_heading); ?></h2>
		</div>
		<div class="testimonials-grid">
			<?php foreach ($lc_reviews as $rv) : ?>
				<?php if (empty($rv['quote']) && empty($rv['name'])) : continue;
				endif; ?>
				<article class="testimonial-card">
					<div class="testimonial-media">
						<?php hvac_acf_image(isset($rv['image']) ? $rv['image'] : false, 'large', 'testimonial-image'); ?>
					</div>
					<div class="testimonial-body">
						<div class="testimonial-quite-wrapper">
							<div class="testimonial-person">
								<div class="headshot-wrapper">
									<?php hvac_acf_image(isset($rv['headshot']) ? $rv['headshot'] : false, 'thumbnail', 'testimonial-headshot'); ?>
								</div>
								<div class="details">
									<?php if (! empty($rv['name'])) : ?><span class="testimonial-name"><?php echo esc_html($rv['name']); ?></span><?php endif; ?>
									<?php if (! empty($rv['role'])) : ?><span class="testimonial-role"><?php echo esc_html($rv['role']); ?></span><?php endif; ?>
								</div>
							</div>
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon.png" alt="<?php esc_attr_e('Quote', 'hvac'); ?>">
						</div>
						<?php if (! empty($rv['quote'])) : ?><blockquote class="testimonial-quote"><?php echo esc_html($rv['quote']); ?></blockquote><?php endif; ?>
						<?php
						$rv_rating = isset($rv['rating']) ? (int) $rv['rating'] : 5;
						if ($rv_rating < 1) {
							$rv_rating = 5;
						}
						?>
						<span class="testimonial-stars" aria-label="<?php echo esc_attr(sprintf(_n('%d star', '%d stars', $rv_rating, 'hvac'), $rv_rating)); ?>">
							<?php for ($rs = 0; $rs < $rv_rating; $rs++) : ?>
								<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3 6.3 6.9.9-5 4.8 1.2 6.8L12 17.8 5.9 20.8 7.1 14 2.1 9.2 9 8.3 12 2z" /></svg>
							<?php endfor; ?>
						</span>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$lc_cta_url = ! empty($lc_cta_btn['url']) ? $lc_cta_btn['url'] : '#';
$lc_cta_txt = ! empty($lc_cta_btn['title']) ? $lc_cta_btn['title'] : __('Book Your Free Estimate', 'hvac');
$lc_cta_tgt = ! empty($lc_cta_btn['target']) ? $lc_cta_btn['target'] : '';
?>
<section class="home-cta">
	<div class="container">
		<div class="home-cta-banner">
			<div class="location-cta-text">
				<h2 class="home-cta-heading"><?php echo esc_html($lc_cta_head); ?></h2>
				<?php if ($lc_cta_text) : ?><p class="location-cta-sub"><?php echo esc_html($lc_cta_text); ?></p><?php endif; ?>
			</div>
			<a class="btn-accent home-cta-btn" href="<?php echo esc_url($lc_cta_url); ?>"<?php echo hvac_link_target_attrs($lc_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($lc_cta_txt); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
