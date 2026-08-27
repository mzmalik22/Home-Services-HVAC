<?php

/**
 * "Business Info" Theme Options subpage- the single source of truth for
 * global business details: phone, email, address, hours, and social links.
 *
 * Every place these details appear across the theme (header top bar, footer,
 * Contact Us page, About Us page, service detail pages, the Privacy Policy
 * page, and the Flexible Content hero block) reads from these fields, so
 * updating a value here updates it everywhere it is shown.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Register the "Business Info" subpage under Theme Options.
 */
function hvac_business_info_page()
{
	if (! function_exists('acf_add_options_sub_page')) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__('Business Info', 'hvac'),
			'menu_title'  => esc_html__('Business Info', 'hvac'),
			'menu_slug'   => 'hvac-theme-options-business',
			'parent_slug' => 'hvac-theme-options',
			'capability'  => 'manage_options',
		)
	);
}
add_action('acf/init', 'hvac_business_info_page');

/**
 * Fields for the "Business Info" subpage.
 */
function hvac_business_info_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_business_info',
			'title'    => esc_html__('Business Info', 'hvac'),
			'fields'   => array(
				array(
					'key'          => 'field_hvac_biz_phone',
					'label'        => esc_html__('Phone Number', 'hvac'),
					'name'         => 'business_phone',
					'type'         => 'text',
					'instructions' => esc_html__('Used site-wide: header top bar, footer, Contact Us page, About Us page, service pages, and the Privacy Policy page.', 'hvac'),
				),
				array(
					'key'          => 'field_hvac_biz_email',
					'label'        => esc_html__('Email Address', 'hvac'),
					'name'         => 'business_email',
					'type'         => 'text',
					'instructions' => esc_html__('Used site-wide: header top bar, footer, Contact Us page, and the Privacy Policy page.', 'hvac'),
				),
				array(
					'key'          => 'field_hvac_biz_address',
					'label'        => esc_html__('Address', 'hvac'),
					'name'         => 'business_address',
					'type'         => 'textarea',
					'rows'         => 2,
					'instructions' => esc_html__('Used on the footer and Contact Us page. Leave empty to hide it.', 'hvac'),
				),
				array(
					'key'          => 'field_hvac_biz_hours',
					'label'        => esc_html__('Business Hours', 'hvac'),
					'name'         => 'business_hours',
					'type'         => 'text',
					'instructions' => esc_html__('e.g. "Monday-Saturday 9AM - 6PM". Used in the header, footer, and Contact Us page.', 'hvac'),
				),
				array(
					'key'          => 'field_hvac_biz_socials',
					'label'        => esc_html__('Social Links', 'hvac'),
					'name'         => 'business_socials',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Social Link', 'hvac'),
					'instructions' => esc_html__('Used in the header top bar, footer, and Contact Us page.', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'     => 'field_hvac_biz_social_network',
							'label'   => esc_html__('Network', 'hvac'),
							'name'    => 'network',
							'type'    => 'select',
							'choices' => array(
								'facebook'  => 'Facebook',
								'instagram' => 'Instagram',
								'x'         => 'X (Twitter)',
								'linkedin'  => 'LinkedIn',
								'youtube'   => 'YouTube',
							),
						),
						array(
							'key'           => 'field_hvac_biz_social_url',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-theme-options-business',
					),
				),
			),
		)
	);
}
add_action('acf/init', 'hvac_business_info_fields');
