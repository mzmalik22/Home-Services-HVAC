<?php

/**
 * SCF / ACF fields for the "Contact Us" page template (page-contact.php).
 *
 * The field group only appears on a Page using that template. Every section is
 * editable, with sensible defaults so the page renders before content is added.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_contact_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_contact_page',
			'title'    => esc_html__('Contact Page', 'hvac'),
			'fields'   => array(

				// --- Hero ---
				array(
					'key'   => 'field_hvac_ct_hero_tab',
					'label' => esc_html__('Hero', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_ct_hero_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'contact_hero_eyebrow',
					'type'          => 'text',
					'default_value' => 'Contact Us',
				),
				array(
					'key'           => 'field_hvac_ct_hero_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'contact_hero_heading',
					'type'          => 'text',
					'default_value' => 'Get in Touch With Our HVAC Experts',
				),
				array(
					'key'           => 'field_hvac_ct_hero_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'contact_hero_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Have a question or need a quote? Reach out and our team will get back to you fast.',
				),
				array(
					'key'           => 'field_hvac_ct_hero_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'contact_hero_bg',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				// --- Contact details ---
				array(
					'key'   => 'field_hvac_ct_info_tab',
					'label' => esc_html__('Contact Details', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_ct_info_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'contact_info_heading',
					'type'          => 'text',
					'default_value' => 'Contact Information',
				),
				array(
					'key'           => 'field_hvac_ct_info_text',
					'label'         => esc_html__('Text', 'hvac'),
					'name'          => 'contact_info_text',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Reach us any time — we\'re here to help with repairs, installations, and emergency service.',
				),
				array(
					'key'           => 'field_hvac_ct_phone',
					'label'         => esc_html__('Phone', 'hvac'),
					'name'          => 'contact_phone',
					'type'          => 'text',
					'default_value' => '+62 864 6444 2222',
				),
				array(
					'key'           => 'field_hvac_ct_email',
					'label'         => esc_html__('Email', 'hvac'),
					'name'          => 'contact_email',
					'type'          => 'text',
					'default_value' => 'support@hvacreliablepro.com',
				),
				array(
					'key'           => 'field_hvac_ct_address',
					'label'         => esc_html__('Address', 'hvac'),
					'name'          => 'contact_address',
					'type'          => 'text',
					'default_value' => 'United States',
				),
				array(
					'key'           => 'field_hvac_ct_hours',
					'label'         => esc_html__('Hours', 'hvac'),
					'name'          => 'contact_hours',
					'type'          => 'text',
					'default_value' => 'Mon–Sun: 24/7 Emergency Service',
				),
				array(
					'key'          => 'field_hvac_ct_socials',
					'label'        => esc_html__('Social Links', 'hvac'),
					'name'         => 'contact_socials',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Social Link', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'     => 'field_hvac_ct_social_network',
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
							'key'           => 'field_hvac_ct_social_url',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				// --- Form ---
				array(
					'key'   => 'field_hvac_ct_form_tab',
					'label' => esc_html__('Form', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_ct_form_heading',
					'label'         => esc_html__('Form Heading', 'hvac'),
					'name'          => 'contact_form_heading',
					'type'          => 'text',
					'default_value' => 'Send Us a Message',
				),
				array(
					'key'          => 'field_hvac_ct_form_shortcode',
					'label'        => esc_html__('Form Shortcode', 'hvac'),
					'name'         => 'contact_form_shortcode',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => esc_html__('Optional. Paste a form shortcode (e.g. Contact Form 7 / WPForms). Leave empty to show the built-in styled form.', 'hvac'),
				),

				// --- Map ---
				array(
					'key'   => 'field_hvac_ct_map_tab',
					'label' => esc_html__('Map', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_hvac_ct_map',
					'label'        => esc_html__('Map Embed', 'hvac'),
					'name'         => 'contact_map_embed',
					'type'         => 'textarea',
					'rows'         => 4,
					'instructions' => esc_html__('Optional. Paste a Google Maps embed <iframe> to show a map below the form.', 'hvac'),
				),

				// --- CTA ---
				array(
					'key'   => 'field_hvac_ct_cta_tab',
					'label' => esc_html__('CTA Banner', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_ct_cta_show',
					'label'         => esc_html__('Show CTA Banner', 'hvac'),
					'name'          => 'contact_cta_show',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
				),
				array(
					'key'           => 'field_hvac_ct_cta_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'contact_cta_heading',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Need Service Fast? Call Now for Same-Day HVAC Support.',
				),
				array(
					'key'           => 'field_hvac_ct_cta_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'contact_cta_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-contact.php',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_contact_page_fields');
