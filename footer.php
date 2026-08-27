<?php

/**
 * The footer for our theme.
 *
 * Content is managed under Theme Options > Footer (ACF). Sensible, Figma-matching
 * defaults are used when a field is empty or ACF is inactive.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Return an inline SVG icon for a social network.
 *
 * @param string $network Network slug.
 * @return string
 */
if (! function_exists('hvac_social_icon')) {
	function hvac_social_icon($network)
	{
		$icons = array(
			'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
			'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
			'x'         => '<path d="M4 4l16 16M20 4L4 20"/>',
			'linkedin'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
			'youtube'   => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>',
		);
		$path = isset($icons[$network]) ? $icons[$network] : '';
		if ('' === $path) {
			return '';
		}
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
	}
}

/**
 * Return target/rel attributes for a link, based on an ACF link "target" value.
 *
 * @param string $target The ACF link target ('_blank' or '').
 * @return string Ready-to-print attribute string (leading space included).
 */
if (! function_exists('hvac_link_target_attrs')) {
	function hvac_link_target_attrs($target)
	{
		if ('_blank' === $target) {
			return ' target="_blank" rel="noopener noreferrer"';
		}
		return '';
	}
}

$hvac_acf = function_exists('get_field');

// Brand.
$hvac_footer_logo     = $hvac_acf ? get_field('footer_logo', 'option') : false;
$hvac_footer_heading  = $hvac_acf ? get_field('footer_heading', 'option') : '';
$hvac_footer_tagline  = $hvac_acf ? get_field('footer_tagline', 'option') : '';
$hvac_contact_raw     = $hvac_acf ? get_field('footer_contact_items', 'option') : array();

// Phone, email, address, hours, and social links are global business
// details- managed once under Theme Options > Business Info so they stay in
// sync with the header, Contact Us page, and every other place they appear.
$hvac_biz_phone      = $hvac_acf ? get_field('business_phone', 'option') : '';
$hvac_biz_email      = $hvac_acf ? get_field('business_email', 'option') : '';
$hvac_biz_address    = $hvac_acf ? get_field('business_address', 'option') : '';
$hvac_biz_hours      = $hvac_acf ? get_field('business_hours', 'option') : '';
$hvac_footer_socials = $hvac_acf ? get_field('business_socials', 'option') : array();

// Subscribe / newsletter.
$hvac_sub_show        = $hvac_acf ? get_field('footer_subscribe_show', 'option') : true;
$hvac_sub_heading     = $hvac_acf ? get_field('footer_subscribe_heading', 'option') : '';
$hvac_sub_placeholder = $hvac_acf ? get_field('footer_subscribe_placeholder', 'option') : '';
$hvac_sub_button      = $hvac_acf ? get_field('footer_subscribe_button', 'option') : '';
$hvac_sub_action      = $hvac_acf ? get_field('footer_subscribe_action', 'option') : '';

if (! $hvac_footer_heading) {
	$hvac_footer_heading = __('Reliable Heating & Cooling, Every Season', 'hvac');
}
if (! $hvac_footer_tagline) {
	$hvac_footer_tagline = __('Professional HVAC installation, replacement, and repair services for reliable heating and cooling in homes and businesses.', 'hvac');
}
// Build the global contact rows (phone, email, address, hours) first, so
// they always reflect Theme Options > Business Info.
$hvac_svg_open      = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
$hvac_contact_items = array();
if ($hvac_biz_phone) {
	$hvac_contact_items[] = array(
		'icon_html' => $hvac_svg_open . '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'text'      => $hvac_biz_phone,
		'link'      => 'tel:' . preg_replace('/[^0-9+]/', '', $hvac_biz_phone),
	);
}
if ($hvac_biz_email) {
	$hvac_contact_items[] = array(
		'icon_html' => $hvac_svg_open . '<path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
		'text'      => $hvac_biz_email,
		'link'      => 'mailto:' . $hvac_biz_email,
	);
}
if ($hvac_biz_address) {
	$hvac_contact_items[] = array(
		'icon_html' => $hvac_svg_open . '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
		'text'      => $hvac_biz_address,
		'link'      => '',
	);
}
if ($hvac_biz_hours) {
	$hvac_contact_items[] = array(
		'icon_html' => $hvac_svg_open . '<circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>',
		'text'      => $hvac_biz_hours,
		'link'      => '',
	);
}

// Append any additional freeform items an editor has added (e.g. "24/7
// Customer Support"), on top of the global contact rows above.
if (! empty($hvac_contact_raw) && is_array($hvac_contact_raw)) {
	foreach ($hvac_contact_raw as $hvac_ci) {
		$hvac_ci_text = isset($hvac_ci['text']) ? $hvac_ci['text'] : '';
		$hvac_ci_link = isset($hvac_ci['link']) ? $hvac_ci['link'] : '';
		$hvac_ci_icon = isset($hvac_ci['icon']) ? $hvac_ci['icon'] : array();
		$hvac_icon_html = '';
		if (! empty($hvac_ci_icon['url'])) {
			$hvac_icon_html = sprintf(
				'<img src="%1$s" alt="%2$s" width="16" height="16" />',
				esc_url($hvac_ci_icon['url']),
				esc_attr(! empty($hvac_ci_icon['alt']) ? $hvac_ci_icon['alt'] : '')
			);
		}
		if ('' === $hvac_ci_text && '' === $hvac_icon_html) {
			continue;
		}
		$hvac_contact_items[] = array(
			'icon_html' => $hvac_icon_html,
			'text'      => $hvac_ci_text,
			'link'      => $hvac_ci_link,
		);
	}
}
if (empty($hvac_contact_items)) {
	$hvac_contact_items[] = array(
		'icon_html' => $hvac_svg_open . '<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>',
		'text'      => __('24/7 Customer Support', 'hvac'),
		'link'      => '',
	);
}
if (! $hvac_sub_heading) {
	$hvac_sub_heading = __('Sign Up for HVAC Tips, Seasonal Offers & Maintenance Reminders', 'hvac');
}
if (! $hvac_sub_placeholder) {
	$hvac_sub_placeholder = __('Enter your email', 'hvac');
}
if (! $hvac_sub_button) {
	$hvac_sub_button = __('Subscribe', 'hvac');
}

// Link columns- normalise ACF rows or fall back to Figma defaults.
$hvac_columns = array();
if ($hvac_acf && have_rows('footer_columns', 'option')) {
	while (have_rows('footer_columns', 'option')) {
		the_row();
		$hvac_col_links = array();
		if (have_rows('col_links')) {
			while (have_rows('col_links')) {
				the_row();
				$hvac_link_val = get_sub_field('link');
				if (empty($hvac_link_val['url'])) {
					continue;
				}
				$hvac_col_links[] = array(
					'label'  => ! empty($hvac_link_val['title']) ? $hvac_link_val['title'] : $hvac_link_val['url'],
					'url'    => $hvac_link_val['url'],
					'target' => isset($hvac_link_val['target']) ? $hvac_link_val['target'] : '',
				);
			}
		}
		$hvac_columns[] = array(
			'title' => get_sub_field('col_title'),
			'links' => $hvac_col_links,
		);
	}
}

if (empty($hvac_columns)) {
	$hvac_make_links = function ($pairs) {
		return array_map(
			function ($pair) {
				return array(
					'label'  => $pair[0],
					'url'    => ! empty($pair[1]) ? $pair[1] : '#',
					'target' => '',
				);
			},
			$pairs
		);
	};
	$hvac_services_archive = get_post_type_archive_link('service');
	$hvac_service_url      = function ($slug) {
		$svc = get_page_by_path($slug, OBJECT, 'service');
		return $svc ? get_permalink($svc) : '#';
	};
	$hvac_ac_url       = $hvac_service_url('ac-repair-troubleshooting');
	$hvac_furnace_url  = $hvac_service_url('furnace-replacement');
	$hvac_heatpump_url = $hvac_service_url('heat-pump-installation-replacement');
	$hvac_ductless_url = $hvac_service_url('ductless-mini-split-installation');
	$hvac_comm_url     = $hvac_service_url('commercial-hvac');
	$hvac_emerg_url    = $hvac_service_url('emergency-hvac-repair');
	$hvac_california   = get_page_by_path('california');

	$hvac_columns = array(
		array(
			'title' => __('HVAC Services', 'hvac'),
			'links' => $hvac_make_links(
				array(
					array(__('AC Installation', 'hvac'), $hvac_ac_url),
					array(__('AC Replacement', 'hvac'), $hvac_ac_url),
					array(__('Furnace Replacement', 'hvac'), $hvac_furnace_url),
					array(__('Heat Pump Installation & Replacement', 'hvac'), $hvac_heatpump_url),
					array(__('Ductless / Mini-Split Installation', 'hvac'), $hvac_ductless_url),
					array(__('Commercial HVAC', 'hvac'), $hvac_comm_url),
					array(__('HVAC Repair', 'hvac'), $hvac_services_archive),
					array(__('Emergency HVAC Repair', 'hvac'), $hvac_emerg_url),
				)
			),
		),
		array(
			'title' => __('Service Areas', 'hvac'),
			'links' => $hvac_make_links(
				array(
					array(__('California', 'hvac'), $hvac_california ? get_permalink($hvac_california) : '#'),
					array(__('Ohio', 'hvac'), '#'),
					array(__('Washington', 'hvac'), '#'),
					array(__('Florida', 'hvac'), '#'),
				)
			),
		),
		array(
			'title' => __('Company', 'hvac'),
			'links' => $hvac_make_links(
				array(
					array(__('About Us', 'hvac'), get_permalink(87)),
					array(__('Services', 'hvac'), $hvac_services_archive),
					array(__('Our Locations', 'hvac'), home_url('/#areas-we-serve')),
					array(__('Reviews', 'hvac'), home_url('/#reviews')),
					array(__('Project Gallery', 'hvac'), home_url('/#project-gallery')),
					array(__('Blog', 'hvac'), get_permalink(83)),
					array(__('Contact Us', 'hvac'), get_permalink(74)),
				)
			),
		),
	);
}

// Bottom bar.
$hvac_copyright = $hvac_acf ? get_field('footer_copyright', 'option') : '';
if (! $hvac_copyright) {
	/* translators: default footer copyright line. */
	$hvac_copyright = __('© {year} HVAC Reliable Pros. All Rights Reserved.', 'hvac');
}
$hvac_copyright = str_replace('{year}', gmdate('Y'), $hvac_copyright);

$hvac_bottom_raw   = $hvac_acf ? get_field('footer_bottom_links', 'option') : array();
$hvac_bottom_links = array();
if (! empty($hvac_bottom_raw) && is_array($hvac_bottom_raw)) {
	foreach ($hvac_bottom_raw as $hvac_bottom_row) {
		$hvac_bl = isset($hvac_bottom_row['link']) ? $hvac_bottom_row['link'] : array();
		if (empty($hvac_bl['url'])) {
			continue;
		}
		$hvac_bottom_links[] = array(
			'label'  => ! empty($hvac_bl['title']) ? $hvac_bl['title'] : $hvac_bl['url'],
			'url'    => $hvac_bl['url'],
			'target' => isset($hvac_bl['target']) ? $hvac_bl['target'] : '',
		);
	}
}
if (empty($hvac_bottom_links)) {
	$hvac_bottom_links = array(
		array(
			'label'  => __('Privacy Policy', 'hvac'),
			'url'    => get_permalink(79) ? get_permalink(79) : '#',
			'target' => '',
		),
		array(
			'label'  => __('Terms & Conditions', 'hvac'),
			'url'    => '#',
			'target' => '',
		),
		array(
			'label'  => __('Accessibility', 'hvac'),
			'url'    => '#',
			'target' => '',
		),
	);
}

?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">

	<div class="footer-top-wrapper">
		<div class="container">
			<div class="footer-top">

				<div class="footer-brand">
					<div class="footer-logo">
						<?php
						if (! empty($hvac_footer_logo['url'])) {
							printf(
								'<img src="%1$s" alt="%2$s" />',
								esc_url($hvac_footer_logo['url']),
								esc_attr(! empty($hvac_footer_logo['alt']) ? $hvac_footer_logo['alt'] : get_bloginfo('name'))
							);
						} elseif (has_custom_logo()) {
							the_custom_logo();
						} else {
							printf(
								'<span class="footer-site-title">%s</span>',
								esc_html(get_bloginfo('name'))
							);
						}
						?>
					</div>

					<?php if ($hvac_footer_heading) : ?>
						<h2 class="footer-heading"><?php echo esc_html($hvac_footer_heading); ?></h2>
					<?php endif; ?>

					<ul class="footer-contact">
						<?php foreach ($hvac_contact_items as $hvac_ci) : ?>
							<?php if (empty($hvac_ci['text']) && empty($hvac_ci['icon_html'])) : continue;
							endif; ?>
							<li>

								<?php if (! empty($hvac_ci['link'])) : ?>
									<a href="<?php echo esc_url($hvac_ci['link']); ?>"> <?php if (! empty($hvac_ci['icon_html'])) : ?>
											<span class="footer-contact-icon" aria-hidden="true"><?php echo $hvac_ci['icon_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																									?></span>
										<?php endif; ?> <?php echo esc_html($hvac_ci['text']); ?></a>
								<?php else : ?>
									<p class="border-button-hvac"><span class="footer-contact-icon" aria-hidden="true"><?php echo $hvac_ci['icon_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																														?></span> <?php echo esc_html($hvac_ci['text']); ?></p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>

					<?php if ($hvac_footer_tagline) : ?>
						<p class="footer-tagline"><?php echo esc_html($hvac_footer_tagline); ?></p>
					<?php endif; ?>
				</div>

				<div class="footer-links-col-wrapper">

					<div class="footer-links-wrapper">
						<?php foreach ($hvac_columns as $hvac_column) : ?>
							<div class="footer-col">
								<?php if (! empty($hvac_column['title'])) : ?>
									<h3 class="footer-col-title"><?php echo esc_html($hvac_column['title']); ?></h3>
								<?php endif; ?>
								<?php if (! empty($hvac_column['links'])) : ?>
									<ul class="footer-links">
										<?php foreach ($hvac_column['links'] as $hvac_link) : ?>
											<?php if (empty($hvac_link['label'])) : continue;
											endif; ?>
											<li>
												<a href="<?php echo esc_url(! empty($hvac_link['url']) ? $hvac_link['url'] : '#'); ?>" <?php echo hvac_link_target_attrs(isset($hvac_link['target']) ? $hvac_link['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled attribute string. 
																																		?>><?php echo esc_html($hvac_link['label']); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ($hvac_sub_show) : ?>
						<div class="footer-subscribe">
							<?php if ($hvac_sub_heading) : ?>
								<p class="footer-subscribe-title"><?php echo esc_html($hvac_sub_heading); ?></p>
							<?php endif; ?>
							<?php if ($hvac_sub_action) : ?>
								<form class="footer-subscribe-form" action="<?php echo esc_url($hvac_sub_action); ?>" method="post">
									<label class="screen-reader-text" for="footer-subscribe-email"><?php echo esc_html($hvac_sub_placeholder); ?></label>
									<input type="email" id="footer-subscribe-email" name="email" placeholder="<?php echo esc_attr($hvac_sub_placeholder); ?>" required />
									<button type="submit" class="btn"><?php echo esc_html($hvac_sub_button); ?></button>
								</form>
							<?php else : ?>
								<?php echo function_exists('hvac_form_message_html') ? hvac_form_message_html('subscribe') : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<form class="footer-subscribe-form hvac-ajax-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
									<?php wp_nonce_field('hvac_form_submit', 'hvac_nonce'); ?>
									<input type="hidden" name="action" value="hvac_form_submit">
									<input type="hidden" name="form_type" value="subscribe">
									<?php
								$hvac_current_url = ( is_ssl() ? 'https://' : 'http://' ) . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' );
								?>
								<input type="hidden" name="hvac_page_url" value="<?php echo esc_url($hvac_current_url); ?>">
									<div class="hvac-hp-field" aria-hidden="true"><input type="text" name="hvac_hp" value="" tabindex="-1" autocomplete="off"></div>
									<label class="screen-reader-text" for="footer-subscribe-email"><?php echo esc_html($hvac_sub_placeholder); ?></label>
									<input type="email" id="footer-subscribe-email" name="email" placeholder="<?php echo esc_attr($hvac_sub_placeholder); ?>" required />
									<button type="submit" class="btn"><?php echo esc_html($hvac_sub_button); ?></button>
								</form>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div><!-- .footer-top -->
	</div>

	<div class="footer-bottom-wrapper">
		<div class="container">
			<div class="footer-bottom">
				<div class="footer-bottom-left">
					<?php if (! empty($hvac_footer_socials) && is_array($hvac_footer_socials)) : ?>
						<ul class="footer-socials">
							<?php foreach ($hvac_footer_socials as $hvac_social) : ?>
								<?php
								$hvac_social_link = isset($hvac_social['link']) ? $hvac_social['link'] : array();
								if (empty($hvac_social_link['url'])) {
									continue;
								}
								$hvac_icon          = hvac_social_icon($hvac_social['network']);
								$hvac_social_target = ! empty($hvac_social_link['target']) ? $hvac_social_link['target'] : '_blank';
								?>
								<li>
									<a href="<?php echo esc_url($hvac_social_link['url']); ?>" <?php echo hvac_link_target_attrs($hvac_social_target); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																								?> aria-label="<?php echo esc_attr(ucfirst((string) $hvac_social['network'])); ?>">
										<?php echo $hvac_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
										?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if (! empty($hvac_bottom_links) && is_array($hvac_bottom_links)) : ?>
						<ul class="footer-bottom-links">
							<?php foreach ($hvac_bottom_links as $hvac_blink) : ?>
								<?php if (empty($hvac_blink['label'])) : continue;
								endif; ?>
								<li>
									<a href="<?php echo esc_url(! empty($hvac_blink['url']) ? $hvac_blink['url'] : '#'); ?>" <?php echo hvac_link_target_attrs(isset($hvac_blink['target']) ? $hvac_blink['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																																?>><?php echo esc_html($hvac_blink['label']); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<p class="site-info"><?php echo esc_html($hvac_copyright); ?></p>
			</div>
		</div><!-- .footer-bottom -->
	</div>


</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>