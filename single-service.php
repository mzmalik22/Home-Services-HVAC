<?php

/**
 * The service detail template (single "Service" CPT).
 *
 * Layout follows the theme's V2 design and mirrors a typical service page
 * (hero, overview, highlights, why-us, FAQ, related services, CTA). Every
 * section is editable via the "Service Detail Page" fields (Secure Custom
 * Fields) and only renders when it has content.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

get_header();

while (have_posts()) :
	the_post();

	$sd_intro   = $hvac_acf ? get_field('detail_intro') : '';
	$sd_cta     = $hvac_acf ? get_field('detail_cta') : false;
	$sd_phone   = $hvac_acf ? get_field('detail_phone') : '';
	$sd_tel     = $sd_phone ? preg_replace('/[^0-9+]/', '', $sd_phone) : '';

	$sd_ov_head = $hvac_acf ? get_field('overview_heading') : '';
	$sd_ov_body = $hvac_acf ? get_field('overview_content') : '';
	$sd_ov_img  = $hvac_acf ? get_field('overview_image') : false;

	$sd_hl_head = $hvac_acf ? get_field('highlights_heading') : '';
	$sd_hls     = ($hvac_acf && have_rows('highlights')) ? get_field('highlights') : array();

	$sd_wy_head   = $hvac_acf ? get_field('whyus_heading') : '';
	$sd_wy_text   = $hvac_acf ? get_field('whyus_text') : '';
	$sd_wy_points = ($hvac_acf && have_rows('whyus_points')) ? get_field('whyus_points') : array();

	$sd_pr_head  = $hvac_acf ? get_field('process_heading') : '';
	$sd_pr_sub   = $hvac_acf ? get_field('process_subtext') : '';
	$sd_pr_img   = $hvac_acf ? get_field('process_image') : false;
	$sd_pr_steps = ($hvac_acf && have_rows('process_steps')) ? get_field('process_steps') : array();

	$sd_rv_head  = $hvac_acf ? get_field('reviews_heading') : '';
	$sd_rv_sub   = $hvac_acf ? get_field('reviews_subtext') : '';
	$sd_reviews  = ($hvac_acf && have_rows('reviews')) ? get_field('reviews') : array();

	$sd_faqs    = ($hvac_acf && have_rows('faqs')) ? get_field('faqs') : array();

	$sd_rel_head = $hvac_acf ? get_field('related_heading') : '';
	if (! $sd_rel_head) {
		$sd_rel_head = __('Related Services', 'hvac');
	}
	$sd_archive = get_post_type_archive_link('service');

	/*
	 * Fallback content — used only when the admin hasn't entered a value, so a
	 * new service page looks complete out of the box. Anything entered in the
	 * "Service Detail Page" fields overrides these.
	 */
	$sd_title = get_the_title();

	if (! $sd_intro) {
		/* translators: %s: service name (lowercased). */
		$sd_intro = sprintf(__('Fast, reliable %s from certified technicians — honest diagnostics, upfront pricing, and lasting results that keep your home comfortable.', 'hvac'), strtolower($sd_title));
	}
	if (empty($sd_cta['url'])) {
		$sd_cta = array(
			'title'  => __('Get a Free Quote', 'hvac'),
			'url'    => '#',
			'target' => '',
		);
	}
	if (! $sd_phone) {
		$sd_phone = $hvac_acf ? get_field('footer_phone', 'option') : '';
		if (! $sd_phone && $hvac_acf) {
			$sd_phone = get_field('header_phone', 'option');
		}
		if (! $sd_phone) {
			$sd_phone = '+62 864 6444 2222';
		}
	}
	$sd_tel = $sd_phone ? preg_replace('/[^0-9+]/', '', $sd_phone) : '';

	if (! $sd_ov_head) {
		/* translators: %s: service name. */
		$sd_ov_head = sprintf(__('Expert %s', 'hvac'), $sd_title);
	}
	if (! $sd_hl_head) {
		$sd_hl_head = __('What You Get', 'hvac');
	}
	if (empty($sd_hls)) {
		$sd_hls = array(
			array('item' => __('Honest diagnosis with upfront pricing', 'hvac')),
			array('item' => __('Same-day service whenever possible', 'hvac')),
			array('item' => __('Trained, certified, and insured technicians', 'hvac')),
			array('item' => __('Restored comfort, airflow, and efficiency', 'hvac')),
		);
	}
	if (! $sd_wy_head) {
		$sd_wy_head = __('Why Homeowners Choose Us', 'hvac');
	}
	if (! $sd_wy_text) {
		$sd_wy_text = wpautop(__('We diagnose the real problem, explain it in plain language, and fix it right the first time — with honest, upfront pricing and no surprise fees.', 'hvac'));
	}
	if (empty($sd_wy_points)) {
		$sd_wy_points = array(
			array('title' => __('Certified & Insured Technicians', 'hvac'), 'text' => __('Licensed pros who respect your home and get the job done right the first time.', 'hvac')),
			array('title' => __('Upfront, Honest Pricing', 'hvac'), 'text' => __('Clear quotes with no hidden fees or surprise charges — ever.', 'hvac')),
			array('title' => __('Fast, Same-Day Service', 'hvac'), 'text' => __('Rapid response when you need it most, often on the very same day.', 'hvac')),
			array('title' => __('Satisfaction Guaranteed', 'hvac'), 'text' => __('Every job is backed by our workmanship and satisfaction guarantee.', 'hvac')),
		);
	}
	if (! $sd_pr_head) {
		$sd_pr_head = __('How It Works', 'hvac');
	}
	if (! $sd_pr_sub) {
		$sd_pr_sub = __('Getting your service booked and done is simple — here is what to expect from start to finish.', 'hvac');
	}
	if (empty($sd_pr_steps)) {
		$sd_pr_steps = array(
			array('title' => __('Book Your Appointment', 'hvac'), 'text' => __('Schedule online or by phone and pick the time that works best for you.', 'hvac')),
			array('title' => __('Expert Diagnosis & Quote', 'hvac'), 'text' => __('Our certified technician inspects the issue and gives you an honest, upfront quote.', 'hvac')),
			array('title' => __('Fast, Reliable Fix', 'hvac'), 'text' => __('We complete the work cleanly and confirm everything runs perfectly before we leave.', 'hvac')),
		);
	}

	if (! $sd_rv_head) {
		$sd_rv_head = __('What Our Customers Say', 'hvac');
	}
	if (! $sd_rv_sub) {
		$sd_rv_sub = __('Real feedback from homeowners who trust us with their comfort.', 'hvac');
	}
	if (empty($sd_reviews)) {
		$sd_reviews = array(
			array('name' => __('Sarah Thompson', 'hvac'), 'role' => __('Homeowner', 'hvac'), 'rating' => 5, 'quote' => __('The team was fast, friendly, and fixed our AC the same day. Honest pricing and great communication throughout.', 'hvac')),
			array('name' => __('Michael Reyes', 'hvac'), 'role' => __('Homeowner', 'hvac'), 'rating' => 5, 'quote' => __('Professional from start to finish. They explained everything clearly and left the place spotless. Highly recommend.', 'hvac')),
			array('name' => __('Danielle Carter', 'hvac'), 'role' => __('Homeowner', 'hvac'), 'rating' => 5, 'quote' => __('Booked in the morning, fixed by the afternoon. No upselling, just reliable service. I will definitely call them again.', 'hvac')),
		);
	}

	// Default icons for the why-choose-us cards (shield, tag, clock, badge).
	$sd_whyus_icons = array(
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.6 13.4 11 3.8a2 2 0 0 0-1.4-.6H4a1 1 0 0 0-1 1v5.6a2 2 0 0 0 .6 1.4l9.6 9.6a2 2 0 0 0 2.8 0l4.6-4.6a2 2 0 0 0 0-2.8z"/><line x1="7" y1="7" x2="7" y2="7"/></svg>',
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M8.5 13 7 22l5-3 5 3-1.5-9"/></svg>',
	);
	if (empty($sd_faqs)) {
		$sd_faqs = array(
			array('question' => __('How soon can you come out?', 'hvac'), 'answer' => __('We offer fast scheduling and same-day service whenever possible. Give us a call and we\'ll find the earliest slot that works for you.', 'hvac')),
			array('question' => __('Do you provide free estimates?', 'hvac'), 'answer' => __('Yes. Every estimate is free and comes with honest recommendations and no obligation.', 'hvac')),
			array('question' => __('Do you service all brands?', 'hvac'), 'answer' => __('Our certified technicians install, repair, and maintain every major HVAC brand and model.', 'hvac')),
			array('question' => __('Is your work guaranteed?', 'hvac'), 'answer' => __('Absolutely. Our workmanship is backed by a satisfaction guarantee for lasting peace of mind.', 'hvac')),
		);
	}
?>

	<section class="page-hero service-detail-hero"<?php echo has_post_thumbnail() ? ' style="background-image:url(' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')) . ')"' : ''; ?>>
		<div class="container page-hero-inner service-detail-hero-inner">
			<nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'hvac'); ?>">
				<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'hvac'); ?></a>
				<span aria-hidden="true">/</span>
				<?php if ($sd_archive) : ?>
					<a href="<?php echo esc_url($sd_archive); ?>"><?php esc_html_e('Services', 'hvac'); ?></a>
					<span aria-hidden="true">/</span>
				<?php endif; ?>
				<span class="breadcrumb-current"><?php the_title(); ?></span>
			</nav>

			<h1 class="page-hero-heading"><?php the_title(); ?></h1>
			<?php if ($sd_intro) : ?><p class="page-hero-subtext"><?php echo esc_html($sd_intro); ?></p><?php endif; ?>

			<?php if (! empty($sd_cta['url']) || $sd_phone) : ?>
				<div class="service-detail-actions">
					<?php if (! empty($sd_cta['url'])) : ?>
						<a class="btn-accent" href="<?php echo esc_url($sd_cta['url']); ?>"<?php echo hvac_link_target_attrs(! empty($sd_cta['target']) ? $sd_cta['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html(! empty($sd_cta['title']) ? $sd_cta['title'] : __('Get a Free Quote', 'hvac')); ?></a>
					<?php endif; ?>
					<?php if ($sd_phone) : ?>
						<a class="service-detail-phone" href="tel:<?php echo esc_attr($sd_tel); ?>">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
							<?php echo esc_html($sd_phone); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php
	// Overview: SCF content (fallback to the post editor) + a side image.
	$sd_ov_body_out = $sd_ov_body ? $sd_ov_body : apply_filters('the_content', get_the_content());
	if (! trim(wp_strip_all_tags((string) $sd_ov_body_out))) {
		/* translators: %s: service name (lowercased). */
		$sd_ov_body_out = wpautop(sprintf(__('From minor fixes to complete solutions, our %s service is designed to keep your home cool, comfortable, and running efficiently all year round. Our certified team arrives on time, works cleanly, and stands behind every job with honest, upfront pricing.', 'hvac'), strtolower($sd_title)));
	}
	if (trim(wp_strip_all_tags((string) $sd_ov_body_out)) || ! empty($sd_ov_img['url'])) :
		?>
		<section class="service-overview">
			<div class="container service-overview-inner">
				<div class="service-overview-content">
					<?php if ($sd_ov_head) : ?>
						<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Overview', 'hvac'); ?></span>
						<h2 class="section-heading"><?php echo esc_html($sd_ov_head); ?></h2>
					<?php endif; ?>
					<div class="service-overview-text"><?php echo wp_kses_post($sd_ov_body_out); ?></div>
				</div>
				<div class="service-overview-media">
					<?php hvac_acf_image($sd_ov_img, 'large', 'service-overview-image'); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if (! empty($sd_hls)) : ?>
		<section class="service-highlights">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Benefits', 'hvac'); ?></span>
					<?php if ($sd_hl_head) : ?><h2 class="section-heading"><?php echo esc_html($sd_hl_head); ?></h2><?php endif; ?>
				</div>
				<ul class="highlights-grid">
					<?php foreach ($sd_hls as $hl) : ?>
						<?php if (empty($hl['item'])) : continue;
						endif; ?>
						<li class="highlight-card">
							<span class="highlight-check" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg>
							</span>
							<span class="highlight-text"><?php echo esc_html($hl['item']); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<?php if (! empty($sd_pr_steps)) : ?>
		<section class="home-how">
			<div class="container home-how-inner">
				<div class="home-how-media">
					<?php hvac_acf_image($sd_pr_img, 'large', 'home-how-image'); ?>
				</div>
				<div class="home-how-content">
					<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('How It Works', 'hvac'); ?></span>
					<h2 class="section-heading"><?php echo esc_html($sd_pr_head); ?></h2>
					<?php if ($sd_pr_sub) : ?><p class="home-how-subtext"><?php echo esc_html($sd_pr_sub); ?></p><?php endif; ?>
					<ol class="how-steps">
						<?php $pr_n = 1; ?>
						<?php foreach ($sd_pr_steps as $step) : ?>
							<?php if (empty($step['title'])) : continue;
							endif; ?>
							<li class="how-step">
								<span class="how-step-num" aria-hidden="true"><?php echo esc_html(str_pad((string) $pr_n, 2, '0', STR_PAD_LEFT)); ?></span>
								<div class="how-step-body">
									<h3 class="how-step-title"><?php echo esc_html($step['title']); ?></h3>
									<?php if (! empty($step['text'])) : ?><p class="how-step-text"><?php echo esc_html($step['text']); ?></p><?php endif; ?>
								</div>
							</li>
							<?php $pr_n++; ?>
						<?php endforeach; ?>
					</ol>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ($sd_wy_text || $sd_wy_head || ! empty($sd_wy_points)) : ?>
		<section class="service-whyus">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Why Choose Us', 'hvac'); ?></span>
					<?php if ($sd_wy_head) : ?><h2 class="section-heading"><?php echo esc_html($sd_wy_head); ?></h2><?php endif; ?>
					<?php if ($sd_wy_text) : ?><div class="section-subtext whyus-lead"><?php echo wp_kses_post($sd_wy_text); ?></div><?php endif; ?>
				</div>
				<?php if (! empty($sd_wy_points)) : ?>
					<div class="whyus-grid">
						<?php $wp_i = 0; ?>
						<?php foreach ($sd_wy_points as $pt) : ?>
							<?php if (empty($pt['title']) && empty($pt['text'])) : continue;
							endif; ?>
							<article class="whyus-card">
								<span class="whyus-card-icon" aria-hidden="true">
									<?php
									if (! empty($pt['icon'])) {
										hvac_acf_image($pt['icon'], 'thumbnail', 'whyus-card-icon-img');
									} else {
										echo $sd_whyus_icons[$wp_i % 4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
									?>
								</span>
								<?php if (! empty($pt['title'])) : ?><h3 class="whyus-card-title"><?php echo esc_html($pt['title']); ?></h3><?php endif; ?>
								<?php if (! empty($pt['text'])) : ?><p class="whyus-card-text"><?php echo esc_html($pt['text']); ?></p><?php endif; ?>
							</article>
							<?php $wp_i++; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if (! empty($sd_faqs)) : ?>
		<section class="service-faq">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('FAQ', 'hvac'); ?></span>
					<h2 class="section-heading"><?php esc_html_e('Frequently Asked Questions', 'hvac'); ?></h2>
				</div>
				<div class="faq-list">
					<?php foreach ($sd_faqs as $i => $faq) : ?>
						<?php if (empty($faq['question'])) : continue;
						endif; ?>
						<details class="faq-item"<?php echo 0 === $i ? ' open' : ''; ?>>
							<summary class="faq-q"><?php echo esc_html($faq['question']); ?><span class="faq-icon" aria-hidden="true"></span></summary>
							<?php if (! empty($faq['answer'])) : ?><div class="faq-a"><?php echo wp_kses_post(wpautop($faq['answer'])); ?></div><?php endif; ?>
						</details>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if (! empty($sd_reviews)) : ?>
		<section class="home-testimonials">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Reviews', 'hvac'); ?></span>
					<h2 class="section-heading"><?php echo esc_html($sd_rv_head); ?></h2>
					<?php if ($sd_rv_sub) : ?><p class="section-subtext"><?php echo esc_html($sd_rv_sub); ?></p><?php endif; ?>
				</div>
				<div class="testimonials-grid">
					<?php foreach ($sd_reviews as $rv) : ?>
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
	// Related services — other services, newest first.
	$sd_related = new WP_Query(
		array(
			'post_type'           => 'service',
			'posts_per_page'      => 3,
			'post__not_in'        => array(get_the_ID()),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ($sd_related->have_posts()) :
		?>
		<section class="home-services">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('More Services', 'hvac'); ?></span>
					<h2 class="section-heading"><?php echo esc_html($sd_rel_head); ?></h2>
				</div>
				<div class="services-grid">
					<?php
					while ($sd_related->have_posts()) :
						$sd_related->the_post();
						$badge = $hvac_acf ? get_field('service_badge') : '';
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
								<?php if ($badge) : ?>
									<span class="service-card-badge">
										<span class="service-card-badge-icon" aria-hidden="true">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
										</span>
										<?php echo esc_html($badge); ?>
									</span>
								<?php endif; ?>
							</a>
							<div class="service-card-body">
								<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php $rel_excerpt = get_the_excerpt(); ?>
								<?php if ($rel_excerpt) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($rel_excerpt, 18)); ?></p><?php endif; ?>
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

	<?php
	// CTA banner — per-service, falling back to the global Services Page CTA.
	$sd_cta_heading = $hvac_acf ? get_field('detail_cta_heading') : '';
	if (! $sd_cta_heading && $hvac_acf) {
		$sd_cta_heading = get_field('services_cta_heading', 'option');
	}
	if (! $sd_cta_heading) {
		$sd_cta_heading = __('Ready to Enjoy Reliable, Worry-Free Cooling? Book Your Service Today.', 'hvac');
	}
	$sd_cta_btn = $hvac_acf ? get_field('detail_cta_button') : false;
	if (empty($sd_cta_btn['url']) && $hvac_acf) {
		$sd_cta_btn = get_field('services_cta_button', 'option');
	}
	$sd_cta_url = ! empty($sd_cta_btn['url']) ? $sd_cta_btn['url'] : '#';
	$sd_cta_txt = ! empty($sd_cta_btn['title']) ? $sd_cta_btn['title'] : __('Book Now', 'hvac');
	$sd_cta_tgt = ! empty($sd_cta_btn['target']) ? $sd_cta_btn['target'] : '';
	?>
	<section class="home-cta">
		<div class="container">
			<div class="home-cta-banner">
				<h2 class="home-cta-heading"><?php echo esc_html($sd_cta_heading); ?></h2>
				<a class="btn-accent home-cta-btn" href="<?php echo esc_url($sd_cta_url); ?>"<?php echo hvac_link_target_attrs($sd_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($sd_cta_txt); ?></a>
			</div>
		</div>
	</section>

<?php
endwhile;

get_footer();
