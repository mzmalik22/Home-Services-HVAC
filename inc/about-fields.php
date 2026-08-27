<?php

/**
 * SCF / ACF fields for the "About Us" page template (page-about.php).
 *
 * Only appears on a Page using that template. Every section is editable, with
 * HVAC defaults so the page renders before content is entered.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_about_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	$title_text = function ($prefix) {
		return array(
			array('key' => $prefix . '_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
			array('key' => $prefix . '_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
		);
	};

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_about_page',
			'title'    => esc_html__('About Page', 'hvac'),
			'fields'   => array(

				// --- Hero ---
				array('key' => 'field_hvac_ab_hero_tab', 'label' => esc_html__('Hero', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'about_eyebrow', 'type' => 'text', 'default_value' => 'About Us'),
				array('key' => 'field_hvac_ab_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_heading', 'type' => 'text', 'default_value' => 'Your Trusted Local Heating & Cooling Experts'),
				array('key' => 'field_hvac_ab_intro', 'label' => esc_html__('Intro', 'hvac'), 'name' => 'about_intro', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'We are a full-service residential and commercial HVAC company dedicated to honest advice, quality workmanship, and comfort built to last. From repairs and tune-ups to full system installations, homeowners and businesses trust our licensed local technicians to treat every home like our own.'),
				array('key' => 'field_hvac_ab_btn', 'label' => esc_html__('Button', 'hvac'), 'name' => 'about_btn', 'type' => 'link', 'return_format' => 'array'),
				array('key' => 'field_hvac_ab_phone_note', 'label' => esc_html__('Phone', 'hvac'), 'type' => 'message', 'message' => esc_html__('Managed under Theme Options > Business Info.', 'hvac')),
				array('key' => 'field_hvac_ab_hero_img', 'label' => esc_html__('Hero Image', 'hvac'), 'name' => 'about_hero_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),

				// --- Story ---
				array('key' => 'field_hvac_ab_story_tab', 'label' => esc_html__('Our Story', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_story_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_story_heading', 'type' => 'text', 'default_value' => 'Our Story'),
				array('key' => 'field_hvac_ab_story_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'about_story_text', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
				array('key' => 'field_hvac_ab_story_img', 'label' => esc_html__('Image', 'hvac'), 'name' => 'about_story_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),

				// --- Stats ---
				array('key' => 'field_hvac_ab_stats_tab', 'label' => esc_html__('Stats', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_stats_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_stats_heading', 'type' => 'text', 'default_value' => 'Trusted by Homeowners Across the Region'),
				array(
					'key' => 'field_hvac_ab_stats', 'label' => esc_html__('Stats', 'hvac'), 'name' => 'about_stats',
					'type' => 'repeater', 'layout' => 'table', 'button_label' => esc_html__('Add Stat', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_ab_stat_value', 'label' => esc_html__('Value', 'hvac'), 'name' => 'value', 'type' => 'text'),
						array('key' => 'field_hvac_ab_stat_label', 'label' => esc_html__('Label', 'hvac'), 'name' => 'label', 'type' => 'text'),
					),
				),

				// --- Values ---
				array('key' => 'field_hvac_ab_values_tab', 'label' => esc_html__('Values', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_values_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'about_values_eyebrow', 'type' => 'text', 'default_value' => 'What We Stand For'),
				array('key' => 'field_hvac_ab_values_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_values_heading', 'type' => 'text', 'default_value' => 'The Values Behind Every Job'),
				array('key' => 'field_hvac_ab_values_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'about_values_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'The principles that guide every project, from the first estimate to the final walkthrough.'),
				array(
					'key' => 'field_hvac_ab_values', 'label' => esc_html__('Value Cards', 'hvac'), 'name' => 'about_values',
					'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Value', 'hvac'),
					'sub_fields' => $title_text('field_hvac_ab_value'),
				),

				// --- Credentials ---
				array('key' => 'field_hvac_ab_creds_tab', 'label' => esc_html__('Credentials', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_creds_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'about_creds_eyebrow', 'type' => 'text', 'default_value' => 'Licensed, Insured & Certified'),
				array('key' => 'field_hvac_ab_creds_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_creds_heading', 'type' => 'text', 'default_value' => 'Peace of Mind on Every Project'),
				array('key' => 'field_hvac_ab_creds_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'about_creds_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'We meet the standards that protect your home and your investment.'),
				array(
					'key' => 'field_hvac_ab_creds', 'label' => esc_html__('Credential Cards', 'hvac'), 'name' => 'about_creds',
					'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Credential', 'hvac'),
					'sub_fields' => $title_text('field_hvac_ab_cred'),
				),

				// --- Services (from CPT) ---
				array('key' => 'field_hvac_ab_services_tab', 'label' => esc_html__('Services', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_services_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'about_services_eyebrow', 'type' => 'text', 'default_value' => 'What We Do'),
				array('key' => 'field_hvac_ab_services_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_services_heading', 'type' => 'text', 'default_value' => 'One Trusted Team for Every Project'),
				array('key' => 'field_hvac_ab_services_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'about_services_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Repairs, maintenance, installation, and indoor air quality- handled by one dependable local team.'),
				array('key' => 'field_hvac_ab_services_selected', 'label' => esc_html__('Services to Show', 'hvac'), 'name' => 'about_services_selected', 'type' => 'relationship', 'post_type' => array('service'), 'filters' => array('search'), 'return_format' => 'id', 'instructions' => esc_html__('Pulled from the Service post type. Leave empty to show the latest services; select specific ones to feature only those.', 'hvac')),
				array('key' => 'field_hvac_ab_services_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'about_services_count', 'type' => 'number', 'min' => 1, 'default_value' => 4),

				// --- Testimonials ---
				array('key' => 'field_hvac_ab_testi_tab', 'label' => esc_html__('Testimonials', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_testi_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'about_testi_eyebrow', 'type' => 'text', 'default_value' => 'Reviews'),
				array('key' => 'field_hvac_ab_testi_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_testi_heading', 'type' => 'text', 'default_value' => 'What Our Customers Say'),
				array('key' => 'field_hvac_ab_testimonials_selected', 'label' => esc_html__('Testimonials to Show', 'hvac'), 'name' => 'about_testimonials_selected', 'type' => 'relationship', 'post_type' => array('testimonial'), 'filters' => array('search'), 'return_format' => 'id', 'instructions' => esc_html__('Optional. Leave empty to show every published testimonial.', 'hvac')),
				array('key' => 'field_hvac_ab_testimonials_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'about_testimonials_count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'instructions' => esc_html__('Used when no testimonials are selected above. Leave blank to show all.', 'hvac')),

				// --- CTA ---
				array('key' => 'field_hvac_ab_cta_tab', 'label' => esc_html__('CTA', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_ab_cta_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'about_cta_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Ready to Work With a Team You Can Trust?'),
				array('key' => 'field_hvac_ab_cta_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'about_cta_button', 'type' => 'link', 'return_format' => 'array'),
			),
			'location' => array(
				array(
					array('param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php'),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_about_page_fields');
