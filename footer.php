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
$hvac_footer_tagline  = $hvac_acf ? get_field('footer_tagline', 'option') : '';
$hvac_footer_phone    = $hvac_acf ? get_field('footer_phone', 'option') : '';
$hvac_footer_email    = $hvac_acf ? get_field('footer_email', 'option') : '';
$hvac_footer_location = $hvac_acf ? get_field('footer_location', 'option') : '';
$hvac_footer_socials  = $hvac_acf ? get_field('footer_socials', 'option') : array();

if (! $hvac_footer_tagline) {
	$hvac_footer_tagline = __('Trusted HVAC solutions for homeowners across the USA — from heating and cooling repairs to emergency response and complete system replacements.', 'hvac');
}
if (! $hvac_footer_phone) {
	$hvac_footer_phone = '(512) 555-0199';
}
if (! $hvac_footer_email) {
	$hvac_footer_email = 'hello@hvacreliefpros.com';
}
if (! $hvac_footer_location) {
	$hvac_footer_location = __('Serving Homeowners Nationwide, USA', 'hvac');
}

// Link columns — normalise ACF rows or fall back to Figma defaults.
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
	$hvac_make_links = function ($labels) {
		return array_map(
			function ($label) {
				return array(
					'label'  => $label,
					'url'    => '#',
					'target' => '',
				);
			},
			$labels
		);
	};
	$hvac_columns = array(
		array(
			'title' => __('HVAC Services', 'hvac'),
			'links' => $hvac_make_links(
				array(
					__('AC Repair', 'hvac'),
					__('Heating Repair', 'hvac'),
					__('Furnace Installation', 'hvac'),
					__('Emergency HVAC Service', 'hvac'),
					__('Commercial HVAC', 'hvac'),
					__('HVAC Maintenance', 'hvac'),
				)
			),
		),
		array(
			'title' => __('Service Areas', 'hvac'),
			'links' => $hvac_make_links(
				array(
					__('Austin', 'hvac'),
					__('Round Rock', 'hvac'),
					__('Cedar Park', 'hvac'),
					__('Georgetown', 'hvac'),
					__('Pflugerville', 'hvac'),
					__('View All Areas', 'hvac'),
				)
			),
		),
		array(
			'title' => __('Company', 'hvac'),
			'links' => $hvac_make_links(
				array(
					__('About', 'hvac'),
					__('Reviews', 'hvac'),
					__('Projects', 'hvac'),
					__('Financing', 'hvac'),
					__('Blog', 'hvac'),
					__('Contact', 'hvac'),
				)
			),
		),
	);
}

// Bottom bar.
$hvac_copyright = $hvac_acf ? get_field('footer_copyright', 'option') : '';
if (! $hvac_copyright) {
	/* translators: default footer copyright line. */
	$hvac_copyright = __('© {year} Sample HVAC Co. | Licensed & Insured', 'hvac');
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
			'label'  => __('Privacy', 'hvac'),
			'url'    => '#',
			'target' => '',
		),
		array(
			'label'  => __('Terms', 'hvac'),
			'url'    => '#',
			'target' => '',
		),
	);
}

$hvac_tel = preg_replace('/[^0-9+]/', '', $hvac_footer_phone);
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

					<?php if ($hvac_footer_tagline) : ?>
						<p class="footer-tagline"><?php echo esc_html($hvac_footer_tagline); ?></p>
					<?php endif; ?>

					<ul class="footer-contact">
						<?php if ($hvac_footer_phone) : ?>
							<li>
								<span class="footer-contact-icon" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
									</svg>
								</span>
								<a href="tel:<?php echo esc_attr($hvac_tel); ?>"><?php echo esc_html($hvac_footer_phone); ?></a>
							</li>
						<?php endif; ?>
						<?php if ($hvac_footer_email) : ?>
							<li>
								<span class="footer-contact-icon" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" />
										<polyline points="22,6 12,13 2,6" />
									</svg>
								</span>
								<a href="mailto:<?php echo esc_attr($hvac_footer_email); ?>"><?php echo esc_html($hvac_footer_email); ?></a>
							</li>
						<?php endif; ?>
						<?php if ($hvac_footer_location) : ?>
							<li>
								<span class="footer-contact-icon" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
										<circle cx="12" cy="10" r="3" />
									</svg>
								</span>
								<span><?php echo esc_html($hvac_footer_location); ?></span>
							</li>
						<?php endif; ?>
					</ul>

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
									<a href="<?php echo esc_url($hvac_social_link['url']); ?>" <?php echo hvac_link_target_attrs($hvac_social_target); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled attribute string. 
																									?> aria-label="<?php echo esc_attr(ucfirst((string) $hvac_social['network'])); ?>">
										<?php echo $hvac_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. 
										?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

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
		</div><!-- .footer-top -->
	</div>

	<div class="footer-bottom-wrapper">
		<div class="container">
			<div class="footer-bottom">

				<p class="site-info"><?php echo esc_html($hvac_copyright); ?></p>

				<?php if (! empty($hvac_bottom_links) && is_array($hvac_bottom_links)) : ?>
					<ul class="footer-bottom-links">
						<?php foreach ($hvac_bottom_links as $hvac_blink) : ?>
							<?php if (empty($hvac_blink['label'])) : continue;
							endif; ?>
							<li>
								<a href="<?php echo esc_url(! empty($hvac_blink['url']) ? $hvac_blink['url'] : '#'); ?>" <?php echo hvac_link_target_attrs(isset($hvac_blink['target']) ? $hvac_blink['target'] : ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled attribute string. 
																																?>><?php echo esc_html($hvac_blink['label']); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div><!-- .footer-bottom -->
	</div>


</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>