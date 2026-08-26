<?php

/**
 * Template Name: Flexible Content
 *
 * A generic "page builder" template: the page is built entirely from the
 * "Sections" flexible content field (see inc/flexible-content-fields.php),
 * with one layout per reusable section design already used across this
 * theme (hero, content+image, services grid, feature grids, process steps,
 * checklist, testimonials, news, project gallery, stats, FAQ, CTA banner,
 * related services, related posts, rich text, image).
 *
 * This template is also applied automatically to every standard blog Post
 * (see the `template_include` filter in functions.php)- no manual template
 * selection needed there. When a post has no Sections filled in yet, this
 * falls back to the theme's classic single-post layout so existing posts
 * keep working unchanged until an editor opts into the builder.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

/**
 * Render one "Feature Grid" / "Benefits Grid" style layout. Shared because
 * both layouts are visually the same shape (icon + title + text cards) with
 * different CSS classes, and Benefits Grid items may carry an optional link.
 */
if (! function_exists('hvac_fc_render_card_grid')) {
	function hvac_fc_render_card_grid($row, $section_class, $grid_tag, $grid_class, $card_tag, $card_class, $icon_class, $title_class, $text_class, $icons)
	{
		$eyebrow = ! empty($row['eyebrow']) ? $row['eyebrow'] : '';
		$heading = ! empty($row['heading']) ? $row['heading'] : '';
		$subtext = ! empty($row['subtext']) ? $row['subtext'] : '';
		$items   = ! empty($row['items']) ? $row['items'] : array();
		if (empty($items)) {
			return;
		}
		?>
		<section class="<?php echo esc_attr($section_class); ?>">
			<div class="container">
				<?php if ($eyebrow || $heading || $subtext) : ?>
					<div class="section-head section-head-center">
						<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
						<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
						<?php if ($subtext) : ?><p class="section-subtext whyus-lead"><?php echo esc_html($subtext); ?></p><?php endif; ?>
					</div>
				<?php endif; ?>
				<<?php echo tag_escape($grid_tag); ?> class="<?php echo esc_attr($grid_class); ?>">
					<?php $i = 0; ?>
					<?php foreach ($items as $item) : ?>
						<?php if (empty($item['title']) && empty($item['text'])) : continue;
						endif; ?>
						<?php
						$link     = isset($item['link']) ? $item['link'] : array();
						$link_url = ! empty($link['url']) ? $link['url'] : '';
						?>
						<<?php echo tag_escape($card_tag); ?> class="<?php echo esc_attr($card_class); ?>">
							<span class="<?php echo esc_attr($icon_class); ?>" aria-hidden="true">
								<?php
								if (! empty($item['icon'])) {
									hvac_acf_image($item['icon'], 'thumbnail', $icon_class . '-img');
								} else {
									echo $icons[$i % count($icons)]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</span>
							<?php if (! empty($item['title'])) : ?><h3 class="<?php echo esc_attr($title_class); ?>"><?php echo esc_html($item['title']); ?></h3><?php endif; ?>
							<?php if (! empty($item['text'])) : ?><p class="<?php echo esc_attr($text_class); ?>"><?php echo esc_html($item['text']); ?></p><?php endif; ?>
							<?php if ($link_url) : ?>
								<a class="service-card-link" href="<?php echo esc_url($link_url); ?>" <?php echo hvac_link_target_attrs(! empty($link['target']) ? $link['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<?php echo esc_html(! empty($link['title']) ? $link['title'] : __('Learn More', 'hvac')); ?>
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12" /><polyline points="12 5 19 12 12 19" /></svg>
								</a>
							<?php endif; ?>
						</<?php echo tag_escape($card_tag); ?>>
						<?php $i++; ?>
					<?php endforeach; ?>
				</<?php echo tag_escape($grid_tag); ?>>
			</div>
		</section>
		<?php
	}
}

$hvac_fc_whyus_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.1-2.1 2.8-2.8z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
);
$hvac_fc_benefit_icons = array(
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a7 7 0 0 0-7 7c0 3 2 5 2 8h10c0-3 2-5 2-8a7 7 0 0 0-7-7z"/><line x1="9" y1="21" x2="15" y2="21"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="3"/><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/></svg>',
	'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
);

/**
 * Render every row of the "page_sections" flexible content field.
 */
if (! function_exists('hvac_fc_render_sections')) {
	function hvac_fc_render_sections()
	{
		global $hvac_fc_whyus_icons, $hvac_fc_benefit_icons;

		while (have_rows('page_sections')) :
			the_row();
			$row = array();
			foreach (array('eyebrow', 'heading', 'subtext', 'content', 'text') as $k) {
				// no-op placeholder to keep static analysers happy; fields are read per-layout below.
			}
			switch (get_row_layout()) :

				/* ============================== HERO ============================== */
				case 'hero':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$subtext = get_sub_field('subtext');
					$phone   = get_sub_field('phone');
					$tel     = $phone ? preg_replace('/[^0-9+]/', '', $phone) : '';
					$button  = get_sub_field('button');
					$bg      = get_sub_field('background_image');
					?>
					<section class="page-hero"<?php echo (is_array($bg) && ! empty($bg['url'])) ? ' style="background-image:url(' . esc_url($bg['url']) . ')"' : ''; ?>>
						<div class="container page-hero-inner">
							<?php if ($eyebrow) : ?><span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
							<?php if ($heading) : ?><h1 class="page-hero-heading"><?php echo esc_html($heading); ?></h1><?php endif; ?>
							<?php if ($subtext) : ?><p class="page-hero-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
							<?php if (! empty($button['url']) || $phone) : ?>
								<div class="service-detail-actions">
									<?php if (! empty($button['url'])) : ?>
										<a class="btn-accent" href="<?php echo esc_url($button['url']); ?>" <?php echo hvac_link_target_attrs(! empty($button['target']) ? $button['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html(! empty($button['title']) ? $button['title'] : __('Get Started', 'hvac')); ?></a>
									<?php endif; ?>
									<?php if ($phone) : ?>
										<a class="service-detail-phone" href="tel:<?php echo esc_attr($tel); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
											<?php echo esc_html($phone); ?>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</section>
					<?php
					break;

				/* ========================= CONTENT + IMAGE ========================= */
				case 'content_image':
					$eyebrow  = get_sub_field('eyebrow');
					$heading  = get_sub_field('heading');
					$content  = get_sub_field('content');
					$image    = get_sub_field('image');
					$position = get_sub_field('image_position');
					$button   = get_sub_field('button');
					if (! trim(wp_strip_all_tags((string) $content)) && empty($image['url']) && empty($image['ID'])) {
						break;
					}
					?>
					<section class="service-overview">
						<div class="container service-overview-inner">
							<div class="service-overview-content" style="<?php echo ('left' === $position) ? 'order:2' : ''; ?>">
								<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
								<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($content) : ?><div class="service-overview-text"><?php echo wp_kses_post($content); ?></div><?php endif; ?>
								<?php if (! empty($button['url'])) : ?><a class="btn" href="<?php echo esc_url($button['url']); ?>" <?php echo hvac_link_target_attrs(! empty($button['target']) ? $button['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html(! empty($button['title']) ? $button['title'] : __('Learn More', 'hvac')); ?></a><?php endif; ?>
							</div>
							<div class="service-overview-media" style="<?php echo ('left' === $position) ? 'order:1' : ''; ?>">
								<?php hvac_acf_image($image, 'large', 'service-overview-image'); ?>
							</div>
						</div>
					</section>
					<?php
					break;

				/* ============================ SERVICES GRID ============================ */
				case 'services_grid':
					$eyebrow  = get_sub_field('eyebrow');
					$heading  = get_sub_field('heading');
					$subtext  = get_sub_field('subtext');
					$selected = get_sub_field('services');
					$selected = is_array($selected) ? array_map('intval', array_filter($selected)) : array();
					$count    = (int) get_sub_field('count');
					if ($count < 1) {
						$count = 6;
					}
					$args = array('post_type' => 'service', 'ignore_sticky_posts' => true, 'no_found_rows' => true);
					if (! empty($selected)) {
						$args['post__in']       = $selected;
						$args['orderby']        = 'post__in';
						$args['posts_per_page'] = count($selected);
					} else {
						$args['posts_per_page'] = $count;
					}
					$q = new WP_Query($args);
					if (! $q->have_posts()) {
						break;
					}
					?>
					<section class="home-services">
						<div class="container">
							<?php if ($eyebrow || $heading || $subtext) : ?>
								<div class="section-head section-head-center">
									<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
									<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
									<?php if ($subtext) : ?><p class="section-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="services-grid">
								<?php while ($q->have_posts()) : $q->the_post(); ?>
									<?php $badge = function_exists('get_field') ? get_field('service_badge') : ''; ?>
									<article class="service-card">
										<a class="service-card-media" href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail()) {
												the_post_thumbnail('large', array('class' => 'service-card-image'));
											} else {
												echo '<span class="img-placeholder service-card-image" aria-hidden="true"></span>';
											} ?>
											<?php if ($badge) : ?>
												<span class="service-card-badge">
													<span class="service-card-badge-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg></span>
													<?php echo esc_html($badge); ?>
												</span>
											<?php endif; ?>
										</a>
										<div class="service-card-body">
											<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<?php $excerpt = get_the_excerpt(); ?>
											<?php if ($excerpt) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($excerpt, 20)); ?></p><?php endif; ?>
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
					<?php
					break;

				/* ========================== FEATURE GRID ========================== */
				case 'feature_grid':
					hvac_fc_render_card_grid(
						array(
							'eyebrow' => get_sub_field('eyebrow'),
							'heading' => get_sub_field('heading'),
							'subtext' => get_sub_field('subtext'),
							'items'   => get_sub_field('items'),
						),
						'service-whyus',
						'div',
						'whyus-grid',
						'article',
						'whyus-card',
						'whyus-card-icon',
						'whyus-card-title',
						'whyus-card-text',
						$hvac_fc_whyus_icons
					);
					break;

				/* ========================== BENEFITS GRID ========================== */
				case 'benefits_grid':
					hvac_fc_render_card_grid(
						array(
							'eyebrow' => get_sub_field('eyebrow'),
							'heading' => get_sub_field('heading'),
							'subtext' => get_sub_field('subtext'),
							'items'   => get_sub_field('items'),
						),
						'services-benefits',
						'ul',
						'benefits-grid',
						'li',
						'benefit-card',
						'benefit-icon',
						'benefit-title',
						'benefit-text',
						$hvac_fc_benefit_icons
					);
					break;

				/* ============================ PROCESS STEPS ============================ */
				case 'process_steps':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$subtext = get_sub_field('subtext');
					$image   = get_sub_field('image');
					$steps   = get_sub_field('steps');
					if (empty($steps)) {
						break;
					}
					?>
					<section class="home-how">
						<div class="container home-how-inner">
							<div class="home-how-media">
								<?php hvac_acf_image($image, 'large', 'home-how-image'); ?>
							</div>
							<div class="home-how-content">
								<?php if ($eyebrow) : ?><span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
								<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($subtext) : ?><p class="home-how-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
								<ol class="how-steps">
									<?php $n = 1; ?>
									<?php foreach ($steps as $step) : ?>
										<?php if (empty($step['title'])) : continue;
										endif; ?>
										<li class="how-step">
											<span class="how-step-num" aria-hidden="true"><?php echo esc_html(str_pad((string) $n, 2, '0', STR_PAD_LEFT)); ?></span>
											<div class="how-step-body">
												<h3 class="how-step-title"><?php echo esc_html($step['title']); ?></h3>
												<?php if (! empty($step['text'])) : ?><p class="how-step-text"><?php echo esc_html($step['text']); ?></p><?php endif; ?>
											</div>
										</li>
										<?php $n++; ?>
									<?php endforeach; ?>
								</ol>
							</div>
						</div>
					</section>
					<?php
					break;

				/* =============================== CHECKLIST =============================== */
				case 'checklist':
					$heading = get_sub_field('heading');
					$dark    = get_sub_field('dark_bg');
					$items   = get_sub_field('items');
					if (empty($items)) {
						break;
					}
					?>
					<section class="<?php echo $dark ? 'home-cta' : ''; ?>" style="padding:3rem 0;<?php echo $dark ? 'background:var(--color-primary);' : ''; ?>">
						<div class="container">
							<?php if ($heading) : ?><h2 class="section-heading" style="<?php echo $dark ? 'color:#fff;' : ''; ?>"><?php echo esc_html($heading); ?></h2><?php endif; ?>
							<ul class="location-checklist" style="margin-top:<?php echo $heading ? '1.5rem' : '0'; ?>;<?php echo $dark ? '' : 'grid-template-columns:repeat(auto-fit,minmax(260px,1fr));'; ?>">
								<?php foreach ($items as $item) : ?>
									<?php if (empty($item['text'])) : continue;
									endif; ?>
									<li style="<?php echo $dark ? '' : 'color: var(--color-text);'; ?>">
										<span class="location-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg></span>
										<?php echo esc_html($item['text']); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</section>
					<?php
					break;

				/* ============================== TESTIMONIALS ============================== */
				case 'testimonials':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$subtext = get_sub_field('subtext');
					$items   = get_sub_field('items');
					if (empty($items)) {
						break;
					}
					?>
					<section class="home-testimonials">
						<div class="container">
							<div class="section-head section-head-center">
								<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
								<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($subtext) : ?><p class="section-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
							</div>
							<div class="testimonials-grid">
								<?php foreach ($items as $t) : ?>
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
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon.png" alt="<?php esc_attr_e('Quote', 'hvac'); ?>">
											</div>
											<?php if (! empty($t['quote'])) : ?><blockquote class="testimonial-quote"><?php echo esc_html($t['quote']); ?></blockquote><?php endif; ?>
											<?php $rating = isset($t['rating']) ? (int) $t['rating'] : 5;
											$rating = max(1, $rating); ?>
											<span class="testimonial-stars" aria-label="<?php echo esc_attr(sprintf(_n('%d star', '%d stars', $rating, 'hvac'), $rating)); ?>">
												<?php for ($s = 0; $s < $rating; $s++) : ?>
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
					break;

				/* ================================ NEWS GRID ================================ */
				case 'news_grid':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$subtext = get_sub_field('subtext');
					$source  = get_sub_field('source');
					$cards   = array();
					if ('manual' === $source) {
						foreach ((array) get_sub_field('manual_cards') as $mc) {
							$cards[] = array(
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
						$nq = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true));
						if ($nq->have_posts()) {
							while ($nq->have_posts()) {
								$nq->the_post();
								$cats = get_the_category();
								$cards[] = array(
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
					if (empty($cards)) {
						break;
					}
					$featured = array_shift($cards);
					$rest     = array_slice($cards, 0, 2);
					?>
					<section class="home-news">
						<div class="container">
							<?php if ($eyebrow || $heading || $subtext) : ?>
								<div class="section-head section-head-center">
									<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
									<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
									<?php if ($subtext) : ?><p class="section-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="news-layout">
								<article class="news-featured">
									<a class="news-featured-media" href="<?php echo esc_url($featured['url']); ?>" <?php echo hvac_link_target_attrs($featured['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php if (! empty($featured['image_id'])) {
											echo wp_get_attachment_image($featured['image_id'], 'large', false, array('class' => 'news-featured-image'));
										} else {
											hvac_acf_image(isset($featured['image']) ? $featured['image'] : false, 'large', 'news-featured-image');
										} ?>
									</a>
									<h3 class="news-featured-title"><a href="<?php echo esc_url($featured['url']); ?>" <?php echo hvac_link_target_attrs($featured['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($featured['title']); ?></a></h3>
									<?php if (! empty($featured['date']) || ! empty($featured['category'])) : ?>
										<p class="news-meta"><?php echo esc_html(trim(implode(' · ', array_filter(array($featured['date'], $featured['category']))))); ?></p>
									<?php endif; ?>
									<?php if (! empty($featured['excerpt'])) : ?><p class="news-featured-excerpt"><?php echo esc_html($featured['excerpt']); ?></p><?php endif; ?>
								</article>
								<?php if (! empty($rest)) : ?>
									<div class="news-list">
										<?php foreach ($rest as $nc) : ?>
											<article class="news-card">
												<a class="news-card-media" href="<?php echo esc_url($nc['url']); ?>" <?php echo hvac_link_target_attrs($nc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
													<?php if (! empty($nc['image_id'])) {
														echo wp_get_attachment_image($nc['image_id'], 'medium', false, array('class' => 'news-card-image'));
													} else {
														hvac_acf_image(isset($nc['image']) ? $nc['image'] : false, 'medium', 'news-card-image');
													} ?>
												</a>
												<div class="news-card-body">
													<h3 class="news-card-title"><a href="<?php echo esc_url($nc['url']); ?>" <?php echo hvac_link_target_attrs($nc['target']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($nc['title']); ?></a></h3>
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
					break;

				/* ============================= PROJECTS GALLERY ============================= */
				case 'projects_gallery':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$subtext = get_sub_field('subtext');
					$items   = get_sub_field('items');
					if (empty($items)) {
						break;
					}
					?>
					<section class="home-projects">
						<div class="container">
							<?php if ($eyebrow || $heading || $subtext) : ?>
								<div class="section-head section-head-center">
									<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
									<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
									<?php if ($subtext) : ?><p class="section-subtext"><?php echo esc_html($subtext); ?></p><?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="services-grid">
								<?php foreach ($items as $pj) : ?>
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
					break;

				/* =================================== STATS =================================== */
				case 'stats':
					$heading = get_sub_field('heading');
					$items   = get_sub_field('items');
					if (empty($items)) {
						break;
					}
					?>
					<section class="about-stats-section">
						<div class="container">
							<?php if ($heading) : ?><h2 class="section-heading section-head-center"><?php echo esc_html($heading); ?></h2><?php endif; ?>
							<ul class="location-stats about-stats">
								<?php foreach ($items as $st) : ?>
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
					<?php
					break;

				/* ================================= TABLE ================================= */
				case 'comparison_table':
					$heading = get_sub_field('heading');
					$col1    = get_sub_field('col1_label');
					$col2    = get_sub_field('col2_label');
					$col3    = get_sub_field('col3_label');
					$rows    = get_sub_field('rows');
					$note    = get_sub_field('note');
					if (empty($rows)) {
						break;
					}
					?>
					<section class="fc-table-section">
						<div class="container">
							<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
							<div class="fc-table-wrap">
								<table class="fc-table">
									<thead>
										<tr>
											<th><?php echo esc_html($col1 ? $col1 : __('Item', 'hvac')); ?></th>
											<th><?php echo esc_html($col2 ? $col2 : __('Details', 'hvac')); ?></th>
											<?php if ($col3) : ?><th><?php echo esc_html($col3); ?></th><?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $r) : ?>
											<?php if (empty($r['col1']) && empty($r['col2'])) : continue;
											endif; ?>
											<tr>
												<td data-label="<?php echo esc_attr($col1); ?>"><?php echo esc_html($r['col1']); ?></td>
												<td data-label="<?php echo esc_attr($col2); ?>"><?php echo esc_html($r['col2']); ?></td>
												<?php if ($col3) : ?><td data-label="<?php echo esc_attr($col3); ?>"><?php echo esc_html($r['col3']); ?></td><?php endif; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<?php if ($note) : ?><p class="fc-table-note"><?php echo esc_html($note); ?></p><?php endif; ?>
						</div>
					</section>
					<?php
					break;

				/* ==================================== FAQ ==================================== */
				case 'faq':
					$eyebrow = get_sub_field('eyebrow');
					$heading = get_sub_field('heading');
					$items   = get_sub_field('items');
					if (empty($items)) {
						break;
					}
					?>
					<section class="service-faq">
						<div class="container">
							<div class="section-head section-head-center">
								<?php if ($eyebrow) : ?><span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
								<?php if ($heading) : ?><h2 class="section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
							</div>
							<div class="faq-list">
								<?php foreach ($items as $i => $faq) : ?>
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
					<?php
					break;

				/* ================================ CTA BANNER ================================ */
				case 'cta_banner':
					$heading   = get_sub_field('heading');
					$subtext   = get_sub_field('subtext');
					$checklist = get_sub_field('checklist');
					$button    = get_sub_field('button');
					$bg        = get_sub_field('background_image');
					if (! $heading) {
						break;
					}
					$btn_url = ! empty($button['url']) ? $button['url'] : '#';
					$btn_txt = ! empty($button['title']) ? $button['title'] : __('Get Started', 'hvac');
					$btn_tgt = ! empty($button['target']) ? $button['target'] : '';
					?>
					<section class="home-cta">
						<div class="container">
							<div class="home-cta-banner" <?php echo (is_array($bg) && ! empty($bg['url'])) ? ' style="background-image:url(' . esc_url($bg['url']) . ')"' : ''; ?>>
								<div class="location-cta-text">
									<h2 class="home-cta-heading"><?php echo esc_html($heading); ?></h2>
									<?php if ($subtext) : ?><p class="location-cta-sub"><?php echo esc_html($subtext); ?></p><?php endif; ?>
									<?php if (! empty($checklist)) : ?>
										<ul class="location-checklist">
											<?php foreach ($checklist as $cc) : ?>
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
								<a class="btn-accent home-cta-btn" href="<?php echo esc_url($btn_url); ?>" <?php echo hvac_link_target_attrs($btn_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($btn_txt); ?></a>
							</div>
						</div>
					</section>
					<?php
					break;

				/* ============================= RELATED SERVICES ============================= */
				case 'related_services':
					$heading = get_sub_field('heading');
					$count   = (int) get_sub_field('count');
					if ($count < 1) {
						$count = 3;
					}
					$rq = new WP_Query(array(
						'post_type'           => 'service',
						'posts_per_page'      => $count,
						'post__not_in'        => array(get_the_ID()),
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					));
					if (! $rq->have_posts()) {
						break;
					}
					?>
					<section class="home-services">
						<div class="container">
							<div class="section-head section-head-center">
								<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('More Services', 'hvac'); ?></span>
								<h2 class="section-heading"><?php echo esc_html($heading ? $heading : __('Related Services', 'hvac')); ?></h2>
							</div>
							<div class="services-grid">
								<?php while ($rq->have_posts()) : $rq->the_post(); ?>
									<?php $badge = function_exists('get_field') ? get_field('service_badge') : ''; ?>
									<article class="service-card">
										<a class="service-card-media" href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail()) {
												the_post_thumbnail('large', array('class' => 'service-card-image'));
											} else {
												echo '<span class="img-placeholder service-card-image" aria-hidden="true"></span>';
											} ?>
											<?php if ($badge) : ?>
												<span class="service-card-badge">
													<span class="service-card-badge-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg></span>
													<?php echo esc_html($badge); ?>
												</span>
											<?php endif; ?>
										</a>
										<div class="service-card-body">
											<h3 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<?php $excerpt = get_the_excerpt(); ?>
											<?php if ($excerpt) : ?><p class="service-card-text"><?php echo esc_html(wp_trim_words($excerpt, 18)); ?></p><?php endif; ?>
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
					<?php
					break;

				/* =============================== RELATED POSTS =============================== */
				case 'related_posts':
					$heading  = get_sub_field('heading');
					$count    = (int) get_sub_field('count');
					$same_cat = get_sub_field('same_category');
					if ($count < 1) {
						$count = 3;
					}
					$args = array(
						'post_type'           => 'post',
						'posts_per_page'      => $count,
						'post__not_in'        => array(get_the_ID()),
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					);
					if ($same_cat && 'post' === get_post_type()) {
						$cats = get_the_category();
						if (! empty($cats)) {
							$args['cat'] = $cats[0]->term_id;
						}
					}
					$rq = new WP_Query($args);
					if (! $rq->have_posts()) {
						wp_reset_postdata();
						break;
					}
					?>
					<section class="blog-listing-section single-related">
						<div class="container">
							<div class="section-head section-head-center">
								<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Keep Reading', 'hvac'); ?></span>
								<h2 class="section-heading"><?php echo esc_html($heading ? $heading : __('Related Articles', 'hvac')); ?></h2>
							</div>
							<div class="post-cards">
								<?php while ($rq->have_posts()) : $rq->the_post(); ?>
									<?php get_template_part('template-parts/content', get_post_type()); ?>
								<?php endwhile; ?>
							</div>
						</div>
					</section>
					<?php
					wp_reset_postdata();
					break;

				/* ================================= RICH TEXT ================================= */
				case 'rich_text':
					$content = get_sub_field('content');
					if (! trim(wp_strip_all_tags((string) $content))) {
						break;
					}
					?>
					<div class="single-wrap">
						<div class="container">
							<div class="entry-content single-content">
								<?php echo wp_kses_post($content); ?>
							</div>
						</div>
					</div>
					<?php
					break;

				/* =================================== IMAGE =================================== */
				case 'image_block':
					$image  = get_sub_field('image');
					$cap    = get_sub_field('caption');
					$full   = get_sub_field('full_width');
					if (empty($image['url']) && empty($image['ID'])) {
						break;
					}
					?>
					<div class="single-wrap">
						<div class="<?php echo $full ? '' : 'container'; ?>" style="<?php echo $full ? '' : 'max-width:900px;margin:0 auto;'; ?>">
							<?php hvac_acf_image($image, 'large', 'home-about-image'); ?>
							<?php if ($cap) : ?><p style="text-align:center;color:var(--color-text-light-dark);margin-top:0.75rem;font-size:0.9rem;"><?php echo esc_html($cap); ?></p><?php endif; ?>
						</div>
					</div>
					<?php
					break;

			endswitch;
		endwhile;
	}
}

/**
 * Classic single-post fallback (matches single.php), used when a 'post' has
 * no Sections filled in yet, so existing/not-yet-migrated posts keep working.
 */
if (! function_exists('hvac_fc_render_classic_post')) {
	function hvac_fc_render_classic_post()
	{
		$cats     = get_the_category();
		$cat      = ! empty($cats) ? $cats[0] : null;
		$comments = (int) get_comments_number();
		?>
		<section class="page-hero single-hero">
			<div class="container page-hero-inner">
				<nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'hvac'); ?>">
					<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'hvac'); ?></a>
					<span aria-hidden="true">/</span>
					<?php if ($cat) : ?>
						<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
						<span aria-hidden="true">/</span>
					<?php endif; ?>
					<span class="breadcrumb-current"><?php the_title(); ?></span>
				</nav>
				<?php if ($cat) : ?><span class="single-cat"><?php echo esc_html($cat->name); ?></span><?php endif; ?>
				<h1 class="page-hero-heading single-title"><?php the_title(); ?></h1>
				<div class="single-meta">
					<span class="single-meta-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
						<?php echo esc_html(get_the_date()); ?>
					</span>
					<span class="single-meta-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" /></svg>
						<?php echo esc_html(get_the_author()); ?>
					</span>
					<?php if ($comments > 0) : ?>
						<span class="single-meta-item">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" /></svg>
							<?php printf(esc_html(_n('%d Comment', '%d Comments', $comments, 'hvac')), $comments); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<div class="single-wrap">
			<div class="container">
				<?php if (has_post_thumbnail()) : ?>
					<div class="single-feature">
						<?php the_post_thumbnail('large', array('class' => 'single-feature-image')); ?>
					</div>
				<?php endif; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
					<div class="entry-content single-content">
						<?php
						the_content();
						wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'hvac'), 'after' => '</div>'));
						?>
					</div>
					<?php if (has_tag()) : ?>
						<footer class="single-tags"><?php hvac_entry_tags(); ?></footer>
					<?php endif; ?>
				</article>
				<?php
				the_post_navigation(array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous', 'hvac') . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__('Next', 'hvac') . '</span> <span class="nav-title">%title</span>',
				));
				?>
			</div>
		</div>

		<?php
		$rel_args = array('post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => array(get_the_ID()), 'ignore_sticky_posts' => true, 'no_found_rows' => true);
		if ($cat) {
			$rel_args['cat'] = $cat->term_id;
		}
		$rel_q = new WP_Query($rel_args);
		if ($rel_q->have_posts()) :
			?>
			<section class="blog-listing-section single-related">
				<div class="container">
					<div class="section-head section-head-center">
						<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Keep Reading', 'hvac'); ?></span>
						<h2 class="section-heading"><?php esc_html_e('Related Articles', 'hvac'); ?></h2>
					</div>
					<div class="post-cards">
						<?php while ($rel_q->have_posts()) : $rel_q->the_post(); ?>
							<?php get_template_part('template-parts/content', get_post_type()); ?>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
			<?php
		endif;
		wp_reset_postdata();
	}
}

get_header();

while (have_posts()) :
	the_post();

	$has_sections = $hvac_acf && have_rows('page_sections');

	if ($has_sections) {
		hvac_fc_render_sections();

		if ('post' === get_post_type() && (comments_open() || get_comments_number())) {
			?>
			<div class="single-comments">
				<div class="container">
					<?php comments_template(); ?>
				</div>
			</div>
			<?php
		}
	} elseif ('post' === get_post_type()) {
		// No sections yet- keep existing posts looking exactly as before.
		hvac_fc_render_classic_post();
		if (comments_open() || get_comments_number()) {
			?>
			<div class="single-comments">
				<div class="container">
					<?php comments_template(); ?>
				</div>
			</div>
			<?php
		}
	} else {
		// A Page using this template with no sections added yet.
		?>
		<div class="single-wrap">
			<div class="container">
				<h1 class="page-hero-heading"><?php the_title(); ?></h1>
				<div class="entry-content single-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<?php
	}

endwhile;

get_footer();
