<?php

/**
 * Template Name: About Us
 *
 * An about page matching the theme's V2 design: hero, our story, a stats band,
 * values, credentials, "what we do" (Service CPT), testimonials, and a CTA.
 * Editable via the "About Page" field group (SCF), with HVAC defaults.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

if (! function_exists('hvac_ab')) {
	function hvac_ab($name, $fallback = '')
	{
		if (function_exists('get_field')) {
			$v = get_field($name);
			if (! empty($v)) {
				return $v;
			}
		}
		return $fallback;
	}
}
if (! function_exists('hvac_ab_rows')) {
	function hvac_ab_rows($name)
	{
		return (function_exists('have_rows') && have_rows($name)) ? get_field($name) : array();
	}
}

get_header();

/* ---- Hero ---- */
$ab_eyebrow = hvac_ab('about_eyebrow', __('About Us', 'hvac'));
$ab_heading = hvac_ab('about_heading', __('Your Trusted Local Heating & Cooling Experts', 'hvac'));
$ab_intro   = hvac_ab('about_intro', __('We are a full-service residential and commercial HVAC company dedicated to honest advice, quality workmanship, and comfort built to last. From repairs and tune-ups to full system installations, homeowners and businesses trust our licensed local technicians to treat every home like our own.', 'hvac'));
$ab_btn     = $hvac_acf ? get_field('about_btn') : false;
$ab_phone   = $hvac_acf ? get_field('business_phone', 'option') : '+62 864 6444 2222';
$ab_tel     = $ab_phone ? preg_replace('/[^0-9+]/', '', $ab_phone) : '';
$ab_hero_img = $hvac_acf ? get_field('about_hero_image') : false;

/* ---- Story ---- */
$ab_story_heading = hvac_ab('about_story_heading', __('Our Story', 'hvac'));
$ab_story_text    = hvac_ab('about_story_text', wpautop(__('We started with a simple belief: homeowners deserve heating and cooling done right the first time, by people they can trust. What began as a small local crew has grown into a full-service HVAC company serving homes and businesses across the region. Over the years we have refined a detail-obsessed process- thorough diagnostics, quality parts, and meticulous workmanship- that delivers dependable comfort season after season. We still answer the phone, still show up on time, and still stand behind every job.', 'hvac')));
$ab_story_image   = $hvac_acf ? get_field('about_story_image') : false;

/* ---- Stats ---- */
$ab_stats_heading = hvac_ab('about_stats_heading', __('Trusted by Homeowners Across the Region', 'hvac'));
$ab_stats = hvac_ab_rows('about_stats');
if (empty($ab_stats)) {
	$ab_stats = array(
		array('value' => '15+', 'label' => __('Years of Experience', 'hvac')),
		array('value' => '5,000+', 'label' => __('Systems Serviced', 'hvac')),
		array('value' => '4.9', 'label' => __('Average Star Rating', 'hvac')),
	);
}

/* ---- Values ---- */
$ab_v_eyebrow = hvac_ab('about_values_eyebrow', __('What We Stand For', 'hvac'));
$ab_v_heading = hvac_ab('about_values_heading', __('The Values Behind Every Job', 'hvac'));
$ab_v_subtext = hvac_ab('about_values_subtext', __('The principles that guide every project, from the first estimate to the final walkthrough.', 'hvac'));
$ab_values = hvac_ab_rows('about_values');
if (empty($ab_values)) {
	$ab_values = array(
		array('title' => __('Honesty First', 'hvac'), 'text' => __('Straightforward advice and transparent pricing- no pressure, no surprises.', 'hvac')),
		array('title' => __('Quality Workmanship', 'hvac'), 'text' => __('Careful diagnostics and quality parts for reliable, long-lasting comfort.', 'hvac')),
		array('title' => __('Respect for Your Home', 'hvac'), 'text' => __('We protect your space, tidy up, and treat your property with care.', 'hvac')),
		array('title' => __('Reliability', 'hvac'), 'text' => __('We show up on time, communicate clearly, and finish on schedule.', 'hvac')),
	);
}
$ab_value_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.1-2.1 2.8-2.8z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
);

/* ---- Credentials ---- */
$ab_c_eyebrow = hvac_ab('about_creds_eyebrow', __('Licensed, Insured & Certified', 'hvac'));
$ab_c_heading = hvac_ab('about_creds_heading', __('Peace of Mind on Every Project', 'hvac'));
$ab_c_subtext = hvac_ab('about_creds_subtext', __('We meet the standards that protect your home and your investment.', 'hvac'));
$ab_creds = hvac_ab_rows('about_creds');
if (empty($ab_creds)) {
	$ab_creds = array(
		array('title' => __('Licensed & Insured', 'hvac'), 'text' => __('Fully licensed and insured, so your home and our crew are protected on every job.', 'hvac')),
		array('title' => __('Certified Technicians', 'hvac'), 'text' => __('Trained, background-checked professionals who meet the highest standards.', 'hvac')),
		array('title' => __('Workmanship Warranty', 'hvac'), 'text' => __('We stand behind our work with a solid warranty for lasting peace of mind.', 'hvac')),
		array('title' => __('Local & Established', 'hvac'), 'text' => __('A local company with deep roots and a reputation built on referrals.', 'hvac')),
	);
}

/* ---- Services (from CPT) ---- */
$ab_s_eyebrow = hvac_ab('about_services_eyebrow', __('What We Do', 'hvac'));
$ab_s_heading = hvac_ab('about_services_heading', __('One Trusted Team for Every Project', 'hvac'));
$ab_s_subtext = hvac_ab('about_services_subtext', __('Repairs, maintenance, installation, and indoor air quality- handled by one dependable local team.', 'hvac'));
$ab_s_selected = $hvac_acf ? get_field('about_services_selected') : array();
$ab_s_selected = is_array($ab_s_selected) ? array_map('intval', array_filter($ab_s_selected)) : array();
$ab_s_count = (int) hvac_ab('about_services_count', 4);
if ($ab_s_count < 1) {
	$ab_s_count = 4;
}
$ab_s_args = array('post_type' => 'service', 'ignore_sticky_posts' => true, 'no_found_rows' => true);
if (! empty($ab_s_selected)) {
	$ab_s_args['post__in'] = $ab_s_selected;
	$ab_s_args['orderby']  = 'post__in';
	$ab_s_args['posts_per_page'] = count($ab_s_selected);
} else {
	$ab_s_args['posts_per_page'] = $ab_s_count;
}
$ab_services_q = new WP_Query($ab_s_args);

/* ---- Testimonials ---- */
$ab_t_eyebrow = hvac_ab('about_testi_eyebrow', __('Reviews', 'hvac'));
$ab_t_heading = hvac_ab('about_testi_heading', __('What Our Customers Say', 'hvac'));
$ab_testimonials = hvac_get_testimonials(
	$hvac_acf ? get_field('about_testimonials_selected') : array(),
	(int) hvac_ab('about_testimonials_count', 3)
);

/* ---- CTA ---- */
$ab_cta_head = hvac_ab('about_cta_heading', __('Ready to Work With a Team You Can Trust?', 'hvac'));
$ab_cta_btn  = $hvac_acf ? get_field('about_cta_button') : false;

$ab_btn_url = ! empty($ab_btn['url']) ? $ab_btn['url'] : '#';
$ab_btn_txt = ! empty($ab_btn['title']) ? $ab_btn['title'] : __('Get a Free Estimate', 'hvac');
$ab_btn_tgt = ! empty($ab_btn['target']) ? $ab_btn['target'] : '';
?>

<section class="home-hero about-hero"<?php echo (is_array($ab_hero_img) && ! empty($ab_hero_img['url'])) ? '' : ''; ?>>
	<div class="container home-hero-inner">
		<div class="home-hero-content">
			<?php if ($ab_eyebrow) : ?><span class="hero-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_eyebrow); ?></span><?php endif; ?>
			<h1 class="hero-heading"><?php echo esc_html($ab_heading); ?></h1>
			<?php if ($ab_intro) : ?><p class="hero-subtext"><?php echo esc_html($ab_intro); ?></p><?php endif; ?>
			<div class="service-detail-actions">
				<a class="btn-accent" href="<?php echo esc_url($ab_btn_url); ?>"<?php echo hvac_link_target_attrs($ab_btn_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($ab_btn_txt); ?></a>
				<?php if ($ab_phone) : ?>
					<a class="service-detail-phone" href="tel:<?php echo esc_attr($ab_tel); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
						<?php echo esc_html($ab_phone); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="about-hero-media">
			<?php hvac_acf_image($ab_hero_img, 'large', 'about-hero-image'); ?>
		</div>
	</div>
</section>

<section class="service-overview">
	<div class="container service-overview-inner">
		<div class="service-overview-content">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_story_heading); ?></span>
			<h2 class="section-heading"><?php echo esc_html($ab_story_heading); ?></h2>
			<div class="service-overview-text"><?php echo wp_kses_post($ab_story_text); ?></div>
		</div>
		<div class="service-overview-media">
			<?php hvac_acf_image($ab_story_image, 'large', 'service-overview-image'); ?>
		</div>
	</div>
</section>

<section class="about-stats-section">
	<div class="container">
		<?php if ($ab_stats_heading) : ?><h2 class="section-heading section-head-center"><?php echo esc_html($ab_stats_heading); ?></h2><?php endif; ?>
		<ul class="location-stats about-stats">
			<?php foreach ($ab_stats as $st) : ?>
				<?php if (empty($st['value']) && empty($st['label'])) : continue;
				endif; ?>
				<li>
					<span class="location-stat-value"><?php echo esc_html($st['value']); ?></span>
					<span class="location-stat-label"><?php echo esc_html($st['label']); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="service-whyus">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_v_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($ab_v_heading); ?></h2>
			<?php if ($ab_v_subtext) : ?><p class="section-subtext whyus-lead"><?php echo esc_html($ab_v_subtext); ?></p><?php endif; ?>
		</div>
		<div class="whyus-grid">
			<?php $vi = 0; ?>
			<?php foreach ($ab_values as $v) : ?>
				<?php if (empty($v['title']) && empty($v['text'])) : continue;
				endif; ?>
				<article class="whyus-card">
					<span class="whyus-card-icon" aria-hidden="true"><?php echo $ab_value_icons[$vi % 4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if (! empty($v['title'])) : ?><h3 class="whyus-card-title"><?php echo esc_html($v['title']); ?></h3><?php endif; ?>
					<?php if (! empty($v['text'])) : ?><p class="whyus-card-text"><?php echo esc_html($v['text']); ?></p><?php endif; ?>
				</article>
				<?php $vi++; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="services-benefits">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_c_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($ab_c_heading); ?></h2>
			<?php if ($ab_c_subtext) : ?><p class="section-subtext"><?php echo esc_html($ab_c_subtext); ?></p><?php endif; ?>
		</div>
		<ul class="benefits-grid">
			<?php foreach ($ab_creds as $cr) : ?>
				<?php if (empty($cr['title']) && empty($cr['text'])) : continue;
				endif; ?>
				<li class="benefit-card">
					<span class="benefit-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg></span>
					<?php if (! empty($cr['title'])) : ?><h3 class="benefit-title"><?php echo esc_html($cr['title']); ?></h3><?php endif; ?>
					<?php if (! empty($cr['text'])) : ?><p class="benefit-text"><?php echo esc_html($cr['text']); ?></p><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php if ($ab_services_q->have_posts()) : ?>
	<section class="home-services">
		<div class="container">
			<div class="section-head section-head-center">
				<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_s_eyebrow); ?></span>
				<h2 class="section-heading"><?php echo esc_html($ab_s_heading); ?></h2>
				<?php if ($ab_s_subtext) : ?><p class="section-subtext"><?php echo esc_html($ab_s_subtext); ?></p><?php endif; ?>
			</div>
			<div class="services-grid">
				<?php
				while ($ab_services_q->have_posts()) :
					$ab_services_q->the_post();
					$ab_badge = $hvac_acf ? get_field('service_badge') : '';
					?>
					<article class="service-card">
						<a class="service-card-media" href="<?php the_permalink(); ?>">
							<?php
							if (has_post_thumbnail()) {
								the_post_thumbnail('large', array('class' => 'service-card-image'));
							} else {
								echo '<span class="img-placeholder service-card-image" aria-hidden="true"></span>';
							}
							?>
							<?php if ($ab_badge) : ?>
								<span class="service-card-badge">
									<span class="service-card-badge-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg></span>
									<?php echo esc_html($ab_badge); ?>
								</span>
							<?php endif; ?>
						</a>
						<div class="service-card-body">
							<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php $ab_ex = get_the_excerpt(); ?>
							<?php if ($ab_ex) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($ab_ex, 18)); ?></p><?php endif; ?>
							<a class="service-card-link" href="<?php the_permalink(); ?>">
								<?php esc_html_e('Learn More', 'hvac'); ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12" /><polyline points="12 5 19 12 12 19" /></svg>
							</a>
						</div>
					</article>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if (! empty($ab_testimonials)) : ?>
<section class="home-testimonials">
	<div class="container">
		<div class="section-head section-head-center">
			<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ab_t_eyebrow); ?></span>
			<h2 class="section-heading"><?php echo esc_html($ab_t_heading); ?></h2>
		</div>
		<div class="testimonials-grid">
			<?php foreach ($ab_testimonials as $rv) : ?>
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
						$ab_rating = isset($rv['rating']) ? (int) $rv['rating'] : 5;
						if ($ab_rating < 1) {
							$ab_rating = 5;
						}
						?>
						<span class="testimonial-stars" aria-label="<?php echo esc_attr(sprintf(_n('%d star', '%d stars', $ab_rating, 'hvac'), $ab_rating)); ?>">
							<?php for ($rs = 0; $rs < $ab_rating; $rs++) : ?>
								<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3 6.3 6.9.9-5 4.8 1.2 6.8L12 17.8 5.9 20.8 7.1 14 2.1 9.2 9 8.3 12 2z" /></svg>
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
$ab_cta_url = ! empty($ab_cta_btn['url']) ? $ab_cta_btn['url'] : ($ab_tel ? 'tel:' . $ab_tel : '#');
$ab_cta_txt = ! empty($ab_cta_btn['title']) ? $ab_cta_btn['title'] : __('Get a Free Estimate', 'hvac');
$ab_cta_tgt = ! empty($ab_cta_btn['target']) ? $ab_cta_btn['target'] : '';
?>
<section class="home-cta">
	<div class="container">
		<div class="home-cta-banner">
			<h2 class="home-cta-heading"><?php echo esc_html($ab_cta_head); ?></h2>
			<a class="btn-accent home-cta-btn" href="<?php echo esc_url($ab_cta_url); ?>"<?php echo hvac_link_target_attrs($ab_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($ab_cta_txt); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
