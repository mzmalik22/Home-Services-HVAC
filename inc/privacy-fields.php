<?php

/**
 * SCF / ACF fields for the "Privacy Policy" page template (page-privacy.php).
 *
 * Only appears on a Page using that template. The policy body is a repeater of
 * titled sections; the template builds the "on this page" table of contents
 * from those titles. When empty, a full default policy is rendered.
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
				array('key' => 'field_hvac_pv_show_toc', 'label' => esc_html__('Show "On This Page" List', 'hvac'), 'name' => 'privacy_show_toc', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1, 'instructions' => esc_html__('Auto-built from the section titles below.', 'hvac')),
				array(
					'key'          => 'field_hvac_pv_sections',
					'label'        => esc_html__('Policy Sections', 'hvac'),
					'name'         => 'privacy_sections',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Section', 'hvac'),
					'instructions' => esc_html__('Each section shows as a heading (added to the table of contents) plus its content. Leave empty to use the built-in default policy.', 'hvac'),
					'sub_fields'   => array(
						array('key' => 'field_hvac_pv_section_title', 'label' => esc_html__('Section Title', 'hvac'), 'name' => 'section_title', 'type' => 'text'),
						array('key' => 'field_hvac_pv_section_content', 'label' => esc_html__('Section Content', 'hvac'), 'name' => 'section_content', 'type' => 'wysiwyg', 'toolbar' => 'full', 'media_upload' => 0),
					),
				),
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
