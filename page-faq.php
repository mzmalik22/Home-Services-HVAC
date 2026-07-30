<?php

/**
 * Template Name: FAQ
 *
 * A frequently-asked-questions page matching the theme's V2 design: a page hero,
 * grouped accordion FAQs (reusing the theme's FAQ styling), and a CTA banner.
 * Editable via the "FAQ Page" field group (SCF), with HVAC defaults.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

get_header();

$fq_eyebrow = $hvac_acf ? get_field('faq_eyebrow') : '';
if (! $fq_eyebrow) {
	$fq_eyebrow = __('FAQ', 'hvac');
}
$fq_heading = $hvac_acf ? get_field('faq_heading') : '';
if (! $fq_heading) {
	$fq_heading = __('Frequently Asked Questions', 'hvac');
}
$fq_subtext = $hvac_acf ? get_field('faq_subtext') : '';
if (! $fq_subtext) {
	$fq_subtext = __('Answers to the questions we hear most about our heating and cooling services. Can\'t find what you\'re looking for? Get in touch.', 'hvac');
}
$fq_bg = $hvac_acf ? get_field('faq_bg') : false;

$fq_groups = ($hvac_acf && have_rows('faq_groups')) ? get_field('faq_groups') : array();
if (empty($fq_groups)) {
	$fq_groups = array(
		array(
			'group_title' => __('General', 'hvac'),
			'items'       => array(
				array('question' => __('What areas do you serve?', 'hvac'), 'answer' => __('We provide heating and cooling services to homeowners and businesses across Washington, Oregon, California, and Florida. Not sure if you\'re in our area? Give us a call.', 'hvac')),
				array('question' => __('Do you offer free estimates?', 'hvac'), 'answer' => __('Yes. Every estimate is free and comes with honest recommendations and no obligation.', 'hvac')),
				array('question' => __('Are your technicians licensed and insured?', 'hvac'), 'answer' => __('Absolutely. Every job is handled by licensed, insured, and factory-trained technicians who respect your home.', 'hvac')),
			),
		),
		array(
			'group_title' => __('Services & Scheduling', 'hvac'),
			'items'       => array(
				array('question' => __('Do you offer emergency service?', 'hvac'), 'answer' => __('Yes- we offer 24/7 emergency service and respond as quickly as possible to restore your comfort.', 'hvac')),
				array('question' => __('How often should I service my AC?', 'hvac'), 'answer' => __('We recommend a professional tune-up at least once a year to keep your system efficient and prevent breakdowns.', 'hvac')),
				array('question' => __('How soon can you come out?', 'hvac'), 'answer' => __('We offer fast scheduling and same-day service whenever possible. Call us and we\'ll find the earliest slot that works for you.', 'hvac')),
			),
		),
		array(
			'group_title' => __('Pricing & Payment', 'hvac'),
			'items'       => array(
				array('question' => __('How much does a repair cost?', 'hvac'), 'answer' => __('Costs vary by the issue and system, so we provide a clear, upfront quote after diagnosing the problem- with no hidden fees.', 'hvac')),
				array('question' => __('Do you offer financing?', 'hvac'), 'answer' => __('Yes, flexible financing options are available on qualifying installations and replacements. Ask us for details.', 'hvac')),
			),
		),
	);
}

$fq_cta_show = $hvac_acf ? get_field('faq_cta_show') : true;
$fq_cta_head = $hvac_acf ? get_field('faq_cta_heading') : '';
if (! $fq_cta_head) {
	$fq_cta_head = __('Still Have Questions? Our Team Is Here to Help.', 'hvac');
}
$fq_cta_btn = $hvac_acf ? get_field('faq_cta_button') : false;
$fq_index   = 0;
?>

<section class="page-hero"<?php echo (is_array($fq_bg) && ! empty($fq_bg['url'])) ? ' style="background-image:url(' . esc_url($fq_bg['url']) . ')"' : ''; ?>>
	<div class="container page-hero-inner">
		<?php if ($fq_eyebrow) : ?>
			<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($fq_eyebrow); ?></span>
		<?php endif; ?>
		<h1 class="page-hero-heading"><?php echo esc_html($fq_heading); ?></h1>
		<?php if ($fq_subtext) : ?><p class="page-hero-subtext"><?php echo esc_html($fq_subtext); ?></p><?php endif; ?>
	</div>
</section>

<section class="faq-page-section">
	<div class="container">
		<div class="faq-groups">
			<?php foreach ($fq_groups as $group) : ?>
				<?php
				$items = isset($group['items']) ? $group['items'] : array();
				if (empty($items)) {
					continue;
				}
				?>
				<div class="faq-group">
					<?php if (! empty($group['group_title'])) : ?>
						<h2 class="faq-group-title"><?php echo esc_html($group['group_title']); ?></h2>
					<?php endif; ?>
					<div class="faq-list">
						<?php foreach ($items as $item) : ?>
							<?php if (empty($item['question'])) : continue;
							endif; ?>
							<details class="faq-item">
								<summary class="faq-q"><?php echo esc_html($item['question']); ?><span class="faq-icon" aria-hidden="true"></span></summary>
								<?php if (! empty($item['answer'])) : ?><div class="faq-a"><?php echo wp_kses_post(wpautop($item['answer'])); ?></div><?php endif; ?>
							</details>
							<?php $fq_index++; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ($fq_cta_show) : ?>
	<?php
	$fq_cta_url = ! empty($fq_cta_btn['url']) ? $fq_cta_btn['url'] : '#';
	$fq_cta_txt = ! empty($fq_cta_btn['title']) ? $fq_cta_btn['title'] : __('Contact Us', 'hvac');
	$fq_cta_tgt = ! empty($fq_cta_btn['target']) ? $fq_cta_btn['target'] : '';
	?>
	<section class="home-cta">
		<div class="container">
			<div class="home-cta-banner">
				<h2 class="home-cta-heading"><?php echo esc_html($fq_cta_head); ?></h2>
				<a class="btn-accent home-cta-btn" href="<?php echo esc_url($fq_cta_url); ?>"<?php echo hvac_link_target_attrs($fq_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($fq_cta_txt); ?></a>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
