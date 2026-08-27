<?php

/**
 * Template Name: Contact Us
 *
 * A contact page matching the theme's V2 design: a page hero, a two-column
 * contact details + form section, an optional map, and a CTA banner. Every
 * section is editable via the "Contact Page" field group (SCF), with sensible
 * defaults so the page renders before any content is entered.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

/** Field value or fallback (current page context). */
if (! function_exists('hvac_ct')) {
	function hvac_ct($name, $fallback = '')
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

get_header();

$ct_eyebrow = hvac_ct('contact_hero_eyebrow', __('Contact Us', 'hvac'));
$ct_heading = hvac_ct('contact_hero_heading', __('Get in Touch With Our HVAC Experts', 'hvac'));
$ct_subtext = hvac_ct('contact_hero_subtext', __('Have a question or need a quote? Reach out and our team will get back to you fast.', 'hvac'));
$ct_bg      = $hvac_acf ? get_field('contact_hero_bg') : false;

$ct_info_head = hvac_ct('contact_info_heading', __('Contact Information', 'hvac'));
$ct_info_text = hvac_ct('contact_info_text', __('Reach us any time- we\'re here to help with repairs, installations, and emergency service.', 'hvac'));

// Phone, email, address, hours, and social links are global business
// details- managed once under Theme Options > Business Info.
$ct_phone     = $hvac_acf ? get_field('business_phone', 'option') : '+62 864 6444 2222';
$ct_email     = $hvac_acf ? get_field('business_email', 'option') : 'support@hvacreliablepro.com';
$ct_address   = $hvac_acf ? get_field('business_address', 'option') : '';
$ct_hours     = $hvac_acf ? get_field('business_hours', 'option') : '';
$ct_socials   = ($hvac_acf && have_rows('business_socials', 'option')) ? get_field('business_socials', 'option') : array();
$ct_tel       = $ct_phone ? preg_replace('/[^0-9+]/', '', $ct_phone) : '';

$ct_form_head = hvac_ct('contact_form_heading', __('Send Us a Message', 'hvac'));
$ct_form_sc   = hvac_ct('contact_form_shortcode', '');
$ct_map       = hvac_ct('contact_map_embed', '');

$ct_cta_show  = $hvac_acf ? get_field('contact_cta_show') : true;
$ct_cta_head  = hvac_ct('contact_cta_heading', __('Need Service Fast? Call Now for Same-Day HVAC Support.', 'hvac'));
$ct_cta_btn   = $hvac_acf ? get_field('contact_cta_button') : false;
?>

<section class="page-hero"<?php echo (is_array($ct_bg) && ! empty($ct_bg['url'])) ? ' style="background-image:url(' . esc_url($ct_bg['url']) . ')"' : ''; ?>>
	<div class="container page-hero-inner">
		<?php if ($ct_eyebrow) : ?>
			<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($ct_eyebrow); ?></span>
		<?php endif; ?>
		<?php if ($ct_heading) : ?><h1 class="page-hero-heading"><?php echo esc_html($ct_heading); ?></h1><?php endif; ?>
		<?php if ($ct_subtext) : ?><p class="page-hero-subtext"><?php echo esc_html($ct_subtext); ?></p><?php endif; ?>
	</div>
</section>

<section class="contact-section">
	<div class="container contact-grid">

		<div class="contact-info">
			<?php if ($ct_info_head) : ?>
				<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Reach Us', 'hvac'); ?></span>
				<h2 class="section-heading"><?php echo esc_html($ct_info_head); ?></h2>
			<?php endif; ?>
			<?php if ($ct_info_text) : ?><p class="contact-info-intro"><?php echo esc_html($ct_info_text); ?></p><?php endif; ?>

			<ul class="contact-info-list">
				<?php if ($ct_phone) : ?>
					<li class="contact-info-item">
						<span class="contact-info-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
						</span>
						<span class="contact-info-body">
							<span class="contact-info-label"><?php esc_html_e('Phone', 'hvac'); ?></span>
							<a class="contact-info-value" href="tel:<?php echo esc_attr($ct_tel); ?>"><?php echo esc_html($ct_phone); ?></a>
						</span>
					</li>
				<?php endif; ?>
				<?php if ($ct_email) : ?>
					<li class="contact-info-item">
						<span class="contact-info-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" /><polyline points="22,6 12,13 2,6" /></svg>
						</span>
						<span class="contact-info-body">
							<span class="contact-info-label"><?php esc_html_e('Email', 'hvac'); ?></span>
							<a class="contact-info-value" href="mailto:<?php echo esc_attr($ct_email); ?>"><?php echo esc_html($ct_email); ?></a>
						</span>
					</li>
				<?php endif; ?>
				<?php if ($ct_address) : ?>
					<li class="contact-info-item">
						<span class="contact-info-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" /><circle cx="12" cy="10" r="3" /></svg>
						</span>
						<span class="contact-info-body">
							<span class="contact-info-label"><?php esc_html_e('Address', 'hvac'); ?></span>
							<span class="contact-info-value"><?php echo esc_html($ct_address); ?></span>
						</span>
					</li>
				<?php endif; ?>
				<?php if ($ct_hours) : ?>
					<li class="contact-info-item">
						<span class="contact-info-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 14" /></svg>
						</span>
						<span class="contact-info-body">
							<span class="contact-info-label"><?php esc_html_e('Hours', 'hvac'); ?></span>
							<span class="contact-info-value"><?php echo esc_html($ct_hours); ?></span>
						</span>
					</li>
				<?php endif; ?>
			</ul>

			<?php if (! empty($ct_socials) && is_array($ct_socials)) : ?>
				<ul class="contact-socials">
					<?php foreach ($ct_socials as $ct_social) : ?>
						<?php
						$ct_social_link = isset($ct_social['link']) ? $ct_social['link'] : array();
						if (empty($ct_social_link['url'])) {
							continue;
						}
						$ct_social_target = ! empty($ct_social_link['target']) ? $ct_social_link['target'] : '_blank';
						?>
						<li>
							<a href="<?php echo esc_url($ct_social_link['url']); ?>"<?php echo hvac_link_target_attrs($ct_social_target); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr(ucfirst((string) $ct_social['network'])); ?>">
								<?php echo hvac_social_icon($ct_social['network']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="contact-form-card">
			<?php if ($ct_form_head) : ?><h2 class="contact-form-title"><?php echo esc_html($ct_form_head); ?></h2><?php endif; ?>

			<?php if ($ct_form_sc) : ?>
				<?php echo do_shortcode($ct_form_sc); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<form class="contact-form" method="post" action="#" novalidate>
					<div class="contact-form-row">
						<div>
							<label class="screen-reader-text" for="ct-name"><?php esc_html_e('Your Name', 'hvac'); ?></label>
							<input id="ct-name" type="text" name="name" placeholder="<?php esc_attr_e('Your Name', 'hvac'); ?>">
						</div>
						<div>
							<label class="screen-reader-text" for="ct-email"><?php esc_html_e('Email Address', 'hvac'); ?></label>
							<input id="ct-email" type="email" name="email" placeholder="<?php esc_attr_e('Email Address', 'hvac'); ?>">
						</div>
					</div>
					<div class="contact-form-row">
						<div>
							<label class="screen-reader-text" for="ct-phone"><?php esc_html_e('Phone Number', 'hvac'); ?></label>
							<input id="ct-phone" type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'hvac'); ?>">
						</div>
						<div>
							<label class="screen-reader-text" for="ct-subject"><?php esc_html_e('Subject', 'hvac'); ?></label>
							<input id="ct-subject" type="text" name="subject" placeholder="<?php esc_attr_e('Subject', 'hvac'); ?>">
						</div>
					</div>
					<label class="screen-reader-text" for="ct-message"><?php esc_html_e('Message', 'hvac'); ?></label>
					<textarea id="ct-message" name="message" placeholder="<?php esc_attr_e('How can we help?', 'hvac'); ?>"></textarea>
					<button type="submit" class="btn-accent"><?php esc_html_e('Send Message', 'hvac'); ?></button>
				</form>
			<?php endif; ?>
		</div>

	</div>

	<?php if ($ct_map) : ?>
		<div class="container">
			<div class="contact-map">
				<?php
				echo wp_kses(
					$ct_map,
					array(
						'iframe' => array(
							'src'             => array(),
							'width'           => array(),
							'height'          => array(),
							'style'           => array(),
							'title'           => array(),
							'loading'         => array(),
							'allowfullscreen' => array(),
							'referrerpolicy'  => array(),
							'frameborder'     => array(),
						),
					)
				);
				?>
			</div>
		</div>
	<?php endif; ?>
</section>

<?php if ($ct_cta_show) : ?>
	<?php
	$ct_cta_url = ! empty($ct_cta_btn['url']) ? $ct_cta_btn['url'] : ($ct_tel ? 'tel:' . $ct_tel : '#');
	$ct_cta_txt = ! empty($ct_cta_btn['title']) ? $ct_cta_btn['title'] : __('Call Now', 'hvac');
	$ct_cta_tgt = ! empty($ct_cta_btn['target']) ? $ct_cta_btn['target'] : '';
	?>
	<section class="home-cta">
		<div class="container">
			<div class="home-cta-banner">
				<h2 class="home-cta-heading"><?php echo esc_html($ct_cta_head); ?></h2>
				<a class="btn-accent home-cta-btn" href="<?php echo esc_url($ct_cta_url); ?>"<?php echo hvac_link_target_attrs($ct_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($ct_cta_txt); ?></a>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
