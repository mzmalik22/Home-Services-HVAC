<?php

/**
 * SCF / ACF fields for the "Privacy Policy" page template (page-privacy.php).
 *
 * Only appears on a Page using that template. The body is a WYSIWYG field; when
 * left empty the template renders a full default policy.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_privacy_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_privacy_page',
			'title'    => esc_html__('Privacy Policy Page', 'hvac'),
			'fields'   => array(
				array('key' => 'field_hvac_pv_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'privacy_eyebrow', 'type' => 'text', 'default_value' => 'Legal'),
				array('key' => 'field_hvac_pv_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'privacy_heading', 'type' => 'text', 'default_value' => 'Privacy Policy'),
				array('key' => 'field_hvac_pv_updated', 'label' => esc_html__('Last Updated', 'hvac'), 'name' => 'privacy_updated', 'type' => 'text', 'instructions' => esc_html__('e.g. "January 1, 2026". Leave empty to show the current month/year.', 'hvac')),
				array('key' => 'field_hvac_pv_intro', 'label' => esc_html__('Intro', 'hvac'), 'name' => 'privacy_intro', 'type' => 'textarea', 'rows' => 3),
				array('key' => 'field_hvac_pv_content', 'label' => esc_html__('Policy Content', 'hvac'), 'name' => 'privacy_content', 'type' => 'wysiwyg', 'toolbar' => 'full', 'media_upload' => 0, 'instructions' => esc_html__('The full policy. Leave empty to use the built-in default policy.', 'hvac')),
			),
			'location' => array(
				array(
					array('param' => 'page_template', 'operator' => '==', 'value' => 'page-privacy.php'),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_privacy_page_fields');
