<?php

/**
 * Shared "services listing" sections.
 *
 * Renders the page hero, the services grid (a custom query of the "Service"
 * CPT, paginated), a benefits section, and a CTA banner. Used by both the CPT
 * archive (archive-service.php) and the "Service" page template
 * (page-services.php). Editable under Theme Options > Services Page.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

/**
 * Where do we read the section content from?
 *  - On the "Service" page template: the current Page (admin edits it inline).
 *  - Everywhere else (the CPT archive): the "Services Page" options screen.
 */
$hvac_is_service_page = function_exists('is_page_template') && is_page_template('page-services.php');
$hvac_ctx = $hvac_is_service_page ? get_queried_object_id() : 'option';

/** Small helper: field value from the active context ($hvac_ctx) or a fallback. */
if (! function_exists('hvac_sp_val')) {
	function hvac_sp_val($name, $ctx, $fallback = '')
	{
		if (function_exists('get_field')) {
			$val = get_field($name, $ctx);
			if (! empty($val)) {
				return $val;
			}
		}
		return $fallback;
	}
}

/* =============================== PAGE HERO =============================== */
$sp_eyebrow = hvac_sp_val('services_hero_eyebrow', $hvac_ctx, __('Our Services', 'hvac'));
$sp_heading = hvac_sp_val('services_hero_heading', $hvac_ctx, __('Professional AC Services for Ultimate Comfort', 'hvac'));
$sp_subtext = hvac_sp_val('services_hero_subtext', $hvac_ctx, __('Explore our full range of AC repair, maintenance, and installation services designed to keep your home cool and comfortable all year round.', 'hvac'));
$sp_bg      = $hvac_acf ? get_field('services_hero_bg', $hvac_ctx) : false;
?>
<section class="page-hero"<?php echo (is_array($sp_bg) && ! empty($sp_bg['url'])) ? ' style="background-image:url(' . esc_url($sp_bg['url']) . ')"' : ''; ?>>
	<div class="container page-hero-inner">
		<?php if ($sp_eyebrow) : ?>
			<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($sp_eyebrow); ?></span>
		<?php endif; ?>
		<?php if ($sp_heading) : ?><h1 class="page-hero-heading"><?php echo esc_html($sp_heading); ?></h1><?php endif; ?>
		<?php if ($sp_subtext) : ?><p class="page-hero-subtext"><?php echo esc_html($sp_subtext); ?></p><?php endif; ?>
	</div>
</section>

<?php
/* =============================== SERVICES GRID =============================== */
$hvac_paged = get_query_var('paged') ? (int) get_query_var('paged') : (get_query_var('page') ? (int) get_query_var('page') : 1);

// Relationship field (page template only). Empty = show all services; otherwise
// show only the selected services, in the chosen order, without pagination.
$hvac_selected = $hvac_acf ? get_field('services_selected', $hvac_ctx) : array();
$hvac_selected = is_array($hvac_selected) ? array_map('intval', array_filter($hvac_selected)) : array();

$hvac_query_args = array(
	'post_type'           => 'service',
	'ignore_sticky_posts' => true,
);
if (! empty($hvac_selected)) {
	$hvac_query_args['post__in']       = $hvac_selected;
	$hvac_query_args['orderby']        = 'post__in';
	$hvac_query_args['posts_per_page'] = -1;
} else {
	$hvac_query_args['posts_per_page'] = (int) get_option('posts_per_page', 9);
	$hvac_query_args['paged']          = $hvac_paged;
}
$hvac_services_q = new WP_Query($hvac_query_args);
?>
<section class="home-services">
	<div class="container">
		<?php if ($hvac_services_q->have_posts()) : ?>
			<div class="services-grid">
				<?php
				while ($hvac_services_q->have_posts()) :
					$hvac_services_q->the_post();
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
							<?php $svc_excerpt = get_the_excerpt(); ?>
							<?php if ($svc_excerpt) : ?>
								<p class="service-card-text"><?php echo esc_html(wp_trim_words($svc_excerpt, 22)); ?></p>
							<?php endif; ?>
							<a class="service-card-link" href="<?php the_permalink(); ?>">
								<?php esc_html_e('Learn More', 'hvac'); ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12" /><polyline points="12 5 19 12 12 19" /></svg>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			$hvac_big = 999999999;
			$hvac_links = paginate_links(
				array(
					'base'      => str_replace($hvac_big, '%#%', esc_url(get_pagenum_link($hvac_big))),
					'format'    => '?paged=%#%',
					'current'   => max(1, $hvac_paged),
					'total'     => $hvac_services_q->max_num_pages,
					'prev_text' => __('&laquo; Previous', 'hvac'),
					'next_text' => __('Next &raquo;', 'hvac'),
				)
			);
			if ($hvac_links) :
				?>
				<nav class="pagination" aria-label="<?php esc_attr_e('Services navigation', 'hvac'); ?>">
					<div class="nav-links"><?php echo $hvac_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</nav>
			<?php endif; ?>

		<?php else : ?>
			<p class="services-empty"><?php esc_html_e('No services have been added yet. Add your first one under Services in the dashboard.', 'hvac'); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<?php
/* =============================== BENEFITS =============================== */
$b_eyebrow = hvac_sp_val('services_benefits_eyebrow', $hvac_ctx, __('Why Choose Us', 'hvac'));
$b_heading = hvac_sp_val('services_benefits_heading', $hvac_ctx, __('Comfort You Can Count On', 'hvac'));
$benefits  = ($hvac_acf && have_rows('services_benefits', $hvac_ctx)) ? get_field('services_benefits', $hvac_ctx) : array();
if (empty($benefits)) {
	$benefits = array(
		array('title' => __('Certified Technicians', 'hvac'), 'text' => __('Licensed, insured, and experienced professionals on every job.', 'hvac')),
		array('title' => __('24/7 Emergency Service', 'hvac'), 'text' => __('Fast response whenever you need us- day or night.', 'hvac')),
		array('title' => __('Upfront Pricing', 'hvac'), 'text' => __('Clear, honest quotes with no hidden fees or surprises.', 'hvac')),
		array('title' => __('Satisfaction Guaranteed', 'hvac'), 'text' => __('We stand behind the quality of every service we complete.', 'hvac')),
	);
}
$benefit_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.6 13.4 11 3.8a2 2 0 0 0-1.4-.6H4a1 1 0 0 0-1 1v5.6a2 2 0 0 0 .6 1.4l9.6 9.6a2 2 0 0 0 2.8 0l4.6-4.6a2 2 0 0 0 0-2.8z"/><line x1="7" y1="7" x2="7" y2="7"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88z"/></svg>',
);
?>
<section class="services-benefits">
	<div class="container">
		<div class="section-head section-head-center">
			<?php if ($b_eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($b_eyebrow); ?></span><?php endif; ?>
			<h2 class="section-heading"><?php echo esc_html($b_heading); ?></h2>
		</div>
		<ul class="benefits-grid">
			<?php $bi = 0; ?>
			<?php foreach ($benefits as $b) : ?>
				<?php if (empty($b['title']) && empty($b['text'])) : continue;
				endif; ?>
				<li class="benefit-card">
					<span class="benefit-icon" aria-hidden="true">
						<?php
						if (! empty($b['icon'])) {
							hvac_acf_image($b['icon'], 'thumbnail', 'benefit-icon-img');
						} else {
							echo $benefit_icons[$bi % 4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</span>
					<?php if (! empty($b['title'])) : ?><h3 class="benefit-title"><?php echo esc_html($b['title']); ?></h3><?php endif; ?>
					<?php if (! empty($b['text'])) : ?><p class="benefit-text"><?php echo esc_html($b['text']); ?></p><?php endif; ?>
				</li>
				<?php $bi++; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
/* =============================== CTA BANNER =============================== */
$cta_heading = hvac_sp_val('services_cta_heading', $hvac_ctx, __('Ready to Enjoy Reliable, Worry-Free Cooling? Book Your AC Service Today.', 'hvac'));
$cta_button  = $hvac_acf ? get_field('services_cta_button', $hvac_ctx) : false;
$cta_bg      = $hvac_acf ? get_field('services_cta_bg', $hvac_ctx) : false;
$cta_url     = ! empty($cta_button['url']) ? $cta_button['url'] : '#';
$cta_txt     = ! empty($cta_button['title']) ? $cta_button['title'] : __('Book Now', 'hvac');
$cta_tgt     = ! empty($cta_button['target']) ? $cta_button['target'] : '';
?>
<section class="home-cta">
	<div class="container">
		<div class="home-cta-banner"<?php echo (is_array($cta_bg) && ! empty($cta_bg['url'])) ? ' style="background-image:url(' . esc_url($cta_bg['url']) . ')"' : ''; ?>>
			<?php if ($cta_heading) : ?><h2 class="home-cta-heading"><?php echo esc_html($cta_heading); ?></h2><?php endif; ?>
			<a class="btn-accent home-cta-btn" href="<?php echo esc_url($cta_url); ?>"<?php echo hvac_link_target_attrs($cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($cta_txt); ?></a>
		</div>
	</div>
</section>
