<?php

/**
 * Template Name: Privacy Policy
 *
 * A legal / privacy policy page matching the theme's V2 design: a page hero and
 * a readable prose section with an "on this page" table of contents. The body
 * is editable via the "Privacy Policy Page" fields (SCF); when empty, a full
 * default policy is rendered.
 *
 * NOTE: The default text is a general template for an HVAC services website and
 * is not legal advice- have it reviewed by counsel before publishing.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

get_header();

$pv_eyebrow = $hvac_acf ? get_field('privacy_eyebrow') : '';
if (! $pv_eyebrow) {
	$pv_eyebrow = __('Legal', 'hvac');
}
$pv_heading = $hvac_acf ? get_field('privacy_heading') : '';
if (! $pv_heading) {
	$pv_heading = __('Privacy Policy', 'hvac');
}
$pv_updated = $hvac_acf ? get_field('privacy_updated') : '';
if (! $pv_updated) {
	$pv_updated = gmdate('F Y');
}
$pv_intro   = $hvac_acf ? get_field('privacy_intro') : '';
$pv_content = $hvac_acf ? get_field('privacy_content') : '';

$pv_email = ($hvac_acf ? get_field('footer_email', 'option') : '') ?: 'support@hvacreliablepro.com';
$pv_phone = ($hvac_acf ? get_field('footer_phone', 'option') : '') ?: '+62 864 6444 2222';

if (! $pv_intro) {
	$pv_intro = __('This Privacy Policy explains how we collect, use, share and protect your information when you visit our website or request our heating and cooling services. Please read it carefully. By using our website, you agree to the practices described below.', 'hvac');
}

/* Default policy (mirrors a standard 12-section policy)- rendered only when
   the WYSIWYG field is empty. */
if (! $pv_content) {
	$e_email    = esc_html($pv_email);
	$e_phone    = esc_html($pv_phone);
	$mailto     = esc_attr($pv_email);
	$tel        = esc_attr(preg_replace('/[^0-9+]/', '', $pv_phone));
	$contact_pg = get_permalink(get_page_by_path('contact')) ? esc_url(get_permalink(get_page_by_path('contact'))) : '';

	$sections = array(
		array(
			'title' => __('Who We Are', 'hvac'),
			'body'  => '<p>' . esc_html__('We are a professional heating and cooling company serving homeowners and businesses across Washington, Oregon, California and Florida. In this policy, “we”, “us” and “our” refer to our company, and “you” refers to any visitor to our website or customer of our services.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Information We Collect', 'hvac'),
			'body'  => '<p>' . esc_html__('We collect information you provide directly to us and information gathered automatically when you use our website:', 'hvac') . '</p><ul>'
				. '<li>' . esc_html__('Contact details you submit through our forms- such as your name, phone number, email address and service location.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Service details you share with us, including the services you are interested in and your preferred schedule.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Technical data collected automatically, such as your IP address, browser type, device information and pages viewed.', 'hvac') . '</li></ul>',
		),
		array(
			'title' => __('How We Use Your Information', 'hvac'),
			'body'  => '<p>' . esc_html__('We use the information we collect to:', 'hvac') . '</p><ul>'
				. '<li>' . esc_html__('Respond to your enquiries and provide free estimates.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Schedule, perform and follow up on heating and cooling services.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Send you service updates and, where you have opted in, occasional offers.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Improve our website, services and customer experience.', 'hvac') . '</li>'
				. '<li>' . esc_html__('Comply with legal obligations and protect our rights.', 'hvac') . '</li></ul>',
		),
		array(
			'title' => __('How We Share Your Information', 'hvac'),
			'body'  => '<p>' . esc_html__('We do not sell your personal information. We may share it only with trusted service providers who help us operate our business- such as scheduling, communication and analytics tools- and only to the extent necessary. We may also disclose information when required by law or to protect the safety and rights of our customers and team.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Cookies & Tracking Technologies', 'hvac'),
			'body'  => '<p>' . esc_html__('Our website uses cookies and similar technologies to remember your preferences, understand how the site is used and improve performance. You can control or disable cookies through your browser settings, though some features of the site may not work as intended if you do.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Data Retention', 'hvac'),
			'body'  => '<p>' . esc_html__('We keep your information only for as long as necessary to provide our services, meet our legal and accounting obligations, and resolve any disputes. When it is no longer needed, we securely delete or anonymise it.', 'hvac') . '</p>',
		),
		array(
			'title' => __('How We Protect Your Information', 'hvac'),
			'body'  => '<p>' . esc_html__('We use reasonable administrative, technical and physical safeguards to protect your information against loss, misuse and unauthorised access. However, no method of transmission over the internet is completely secure, and we cannot guarantee absolute security.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Your Privacy Rights', 'hvac'),
			'body'  => '<p>' . esc_html__('Depending on where you live, you may have rights to access, correct, delete or restrict the use of your personal information, and to opt out of certain uses. Residents of Washington, Oregon, California and Florida may have additional rights under their state privacy laws- including, for California residents, rights under the California Consumer Privacy Act (CCPA/CPRA).', 'hvac') . '</p><p>' . esc_html__('To exercise any of these rights, please contact us using the details below. We will not discriminate against you for exercising your privacy rights.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Third-Party Links', 'hvac'),
			'body'  => '<p>' . esc_html__('Our website may contain links to third-party sites. We are not responsible for the privacy practices or content of those sites, and we encourage you to review their privacy policies.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Children’s Privacy', 'hvac'),
			'body'  => '<p>' . esc_html__('Our services are intended for adults. We do not knowingly collect personal information from children under 13. If you believe a child has provided us with information, please contact us and we will delete it.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Changes to This Policy', 'hvac'),
			'body'  => '<p>' . esc_html__('We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised “last updated” date. We encourage you to review this policy periodically.', 'hvac') . '</p>',
		),
		array(
			'title' => __('Contact Us', 'hvac'),
			'body'  => '<p>' . esc_html__('If you have any questions about this Privacy Policy or how we handle your information, please get in touch. We serve homeowners across Washington, Oregon, California and Florida and are happy to help.', 'hvac') . '</p><ul>'
				. '<li>' . esc_html__('Email:', 'hvac') . ' <a href="mailto:' . $mailto . '">' . $e_email . '</a></li>'
				. '<li>' . esc_html__('Phone:', 'hvac') . ' <a href="tel:' . $tel . '">' . $e_phone . '</a></li>'
				. ($contact_pg ? '<li><a href="' . $contact_pg . '">' . esc_html__('Contact page', 'hvac') . '</a></li>' : '')
				. '</ul>',
		),
	);

	// Build the "on this page" TOC + the numbered sections.
	$toc  = '<nav class="legal-toc" aria-label="' . esc_attr__('On this page', 'hvac') . '"><p class="legal-toc-title">' . esc_html__('On this page', 'hvac') . '</p><ol>';
	$body = '';
	foreach ($sections as $i => $sec) {
		$anchor = 'pp-section-' . ($i + 1);
		$toc   .= '<li><a href="#' . $anchor . '">' . esc_html($sec['title']) . '</a></li>';
		$body  .= '<h2 id="' . $anchor . '">' . esc_html($sec['title']) . '</h2>' . $sec['body'];
	}
	$toc     .= '</ol></nav>';
	$pv_content = $toc . $body;
}
?>

<section class="page-hero">
	<div class="container page-hero-inner">
		<?php if ($pv_eyebrow) : ?>
			<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($pv_eyebrow); ?></span>
		<?php endif; ?>
		<h1 class="page-hero-heading"><?php echo esc_html($pv_heading); ?></h1>
		<?php if ($pv_intro) : ?><p class="page-hero-subtext"><?php echo esc_html($pv_intro); ?></p><?php endif; ?>
	</div>
</section>

<section class="legal-section">
	<div class="container">
		<div class="legal-content">
			<?php if ($pv_updated) : ?>
				<p class="legal-updated"><?php printf(esc_html__('Last updated: %s', 'hvac'), esc_html($pv_updated)); ?></p>
			<?php endif; ?>
			<?php echo wp_kses_post($pv_content); ?>
		</div>
	</div>
</section>

<?php
get_footer();
