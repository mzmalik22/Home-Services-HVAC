<?php

/**
 * SCF / ACF fields for the "Location" page template (page-location.php).
 *
 * Structure follows a location landing page (hero + estimate form, intro with
 * stats, services, why-us, local insight, projects, reviews, service area,
 * CTA). Only appears on a Page using the Location template. Sensible defaults
 * render before content is entered.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_location_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	/** Simple {text} repeater sub-field. */
	$text_item = function ($key, $name = 'text') {
		return array(
			array('key' => $key, 'label' => esc_html__('Text', 'hvac'), 'name' => $name, 'type' => 'text'),
		);
	};

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_location_page',
			'title'    => esc_html__('Location Page', 'hvac'),
			'fields'   => array(

				/* -------- Hero -------- */
				array('key' => 'field_hvac_lc_hero_tab', 'label' => esc_html__('Hero', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_hero_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_hero_heading', 'type' => 'text', 'default_value' => "California's Trusted Local AC & Heating Experts"),
				array('key' => 'field_hvac_lc_hero_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'loc_hero_subtext', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'From emergency repairs to full system replacements, homeowners across California rely on our licensed local technicians for honest advice, quality workmanship, and cooling built to last.'),
				array('key' => 'field_hvac_lc_hero_bg', 'label' => esc_html__('Background Image', 'hvac'), 'name' => 'loc_hero_bg', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
				array(
					'key' => 'field_hvac_lc_hero_badges', 'label' => esc_html__('Badges', 'hvac'), 'name' => 'loc_hero_badges',
					'type' => 'repeater', 'layout' => 'table', 'button_label' => esc_html__('Add Badge', 'hvac'),
					'sub_fields' => $text_item('field_hvac_lc_hero_badge_text', 'label'),
				),
				array(
					'key' => 'field_hvac_lc_hero_points', 'label' => esc_html__('Checklist', 'hvac'), 'name' => 'loc_hero_points',
					'type' => 'repeater', 'layout' => 'table', 'button_label' => esc_html__('Add Point', 'hvac'),
					'sub_fields' => $text_item('field_hvac_lc_hero_point_text'),
				),
				array('key' => 'field_hvac_lc_form_heading', 'label' => esc_html__('Form Heading', 'hvac'), 'name' => 'loc_form_heading', 'type' => 'text', 'default_value' => 'Get Your Free California AC Estimate'),
				array('key' => 'field_hvac_lc_form_subtitle', 'label' => esc_html__('Form Subtitle', 'hvac'), 'name' => 'loc_form_subtitle', 'type' => 'text', 'default_value' => 'Fast response. No spam. No obligation.'),
				array('key' => 'field_hvac_lc_form_services', 'label' => esc_html__('Service Options', 'hvac'), 'name' => 'loc_form_services', 'type' => 'textarea', 'rows' => 5, 'instructions' => esc_html__('Dropdown options, one per line.', 'hvac'), 'default_value' => "AC Repair\nAC Installation\nAC Maintenance\nEmergency Service\nIndoor Air Quality"),
				array('key' => 'field_hvac_lc_form_button', 'label' => esc_html__('Form Button', 'hvac'), 'name' => 'loc_form_button', 'type' => 'text', 'default_value' => 'Get My Free Estimate'),
				array('key' => 'field_hvac_lc_form_shortcode', 'label' => esc_html__('Form Shortcode', 'hvac'), 'name' => 'loc_form_shortcode', 'type' => 'textarea', 'rows' => 3, 'instructions' => esc_html__('Optional. Overrides the built-in form.', 'hvac')),

				/* -------- Intro -------- */
				array('key' => 'field_hvac_lc_intro_tab', 'label' => esc_html__('Intro', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_intro_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_intro_eyebrow', 'type' => 'text', 'default_value' => 'AC Services in California'),
				array('key' => 'field_hvac_lc_intro_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_intro_heading', 'type' => 'text', 'default_value' => 'Dependable Heating & Cooling in California'),
				array('key' => 'field_hvac_lc_intro_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'loc_intro_text', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
				array('key' => 'field_hvac_lc_intro_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'loc_intro_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
				array(
					'key' => 'field_hvac_lc_stats', 'label' => esc_html__('Stats', 'hvac'), 'name' => 'loc_stats',
					'type' => 'repeater', 'layout' => 'table', 'button_label' => esc_html__('Add Stat', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_lc_stat_value', 'label' => esc_html__('Value', 'hvac'), 'name' => 'value', 'type' => 'text'),
						array('key' => 'field_hvac_lc_stat_label', 'label' => esc_html__('Label', 'hvac'), 'name' => 'label', 'type' => 'text'),
					),
				),

				/* -------- Services -------- */
				array('key' => 'field_hvac_lc_services_tab', 'label' => esc_html__('Services', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_services_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_services_eyebrow', 'type' => 'text', 'default_value' => 'What We Offer'),
				array('key' => 'field_hvac_lc_services_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_services_heading', 'type' => 'text', 'default_value' => 'Complete AC Services in California'),
				array('key' => 'field_hvac_lc_services_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'loc_services_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Whatever your system needs, our local California team has you covered- for homes and businesses alike.'),
				array(
					'key' => 'field_hvac_lc_services_selected', 'label' => esc_html__('Services to Show', 'hvac'), 'name' => 'loc_services_selected',
					'type' => 'relationship', 'post_type' => array('service'), 'filters' => array('search'), 'return_format' => 'id',
					'instructions' => esc_html__('Pulled from the Service post type. Leave empty to show the latest services automatically; select specific services to feature only those, in order.', 'hvac'),
				),
				array(
					'key' => 'field_hvac_lc_services_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'loc_services_count',
					'type' => 'number', 'default_value' => 6, 'min' => 1,
					'instructions' => esc_html__('How many services to show when none are selected above.', 'hvac'),
				),

				/* -------- Why us -------- */
				array('key' => 'field_hvac_lc_why_tab', 'label' => esc_html__('Why Us', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_why_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_why_eyebrow', 'type' => 'text', 'default_value' => 'Why Choose Us'),
				array('key' => 'field_hvac_lc_why_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_why_heading', 'type' => 'text', 'default_value' => 'Why California Homeowners Choose Us'),
				array('key' => 'field_hvac_lc_why_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'loc_why_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'We combine local know-how with certified craftsmanship to make heating and cooling simple, honest, and stress-free.'),
				array(
					'key' => 'field_hvac_lc_why_points', 'label' => esc_html__('Points', 'hvac'), 'name' => 'loc_why_points',
					'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Point', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_lc_why_point_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_hvac_lc_why_point_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
					),
				),

				/* -------- Local insight -------- */
				array('key' => 'field_hvac_lc_insight_tab', 'label' => esc_html__('Local Insight', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_insight_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_insight_eyebrow', 'type' => 'text', 'default_value' => 'Local Insight'),
				array('key' => 'field_hvac_lc_insight_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_insight_heading', 'type' => 'text', 'default_value' => 'What Affects Your AC in California'),
				array('key' => 'field_hvac_lc_insight_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'loc_insight_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'California\'s climate is tough on cooling systems. Knowing what to watch for helps you protect your comfort before small issues become expensive ones.'),
				array(
					'key' => 'field_hvac_lc_insight_items', 'label' => esc_html__('Items', 'hvac'), 'name' => 'loc_insight_items',
					'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Item', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_lc_insight_item_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_hvac_lc_insight_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
					),
				),

				/* -------- Projects -------- */
				array('key' => 'field_hvac_lc_projects_tab', 'label' => esc_html__('Projects', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_projects_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_projects_eyebrow', 'type' => 'text', 'default_value' => 'Our Work'),
				array('key' => 'field_hvac_lc_projects_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_projects_heading', 'type' => 'text', 'default_value' => 'Recent California AC Projects'),
				array('key' => 'field_hvac_lc_projects_text', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'loc_projects_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'A look at some of the systems we have recently installed and serviced for homeowners and businesses around California.'),
				array(
					'key' => 'field_hvac_lc_projects', 'label' => esc_html__('Gallery', 'hvac'), 'name' => 'loc_projects',
					'type' => 'repeater', 'layout' => 'table', 'button_label' => esc_html__('Add Image', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_lc_project_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail'),
					),
				),

				/* -------- Reviews -------- */
				array('key' => 'field_hvac_lc_reviews_tab', 'label' => esc_html__('Reviews', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_reviews_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'loc_reviews_eyebrow', 'type' => 'text', 'default_value' => 'Reviews'),
				array('key' => 'field_hvac_lc_reviews_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_reviews_heading', 'type' => 'text', 'default_value' => 'What California Homeowners Say'),
				array('key' => 'field_hvac_lc_reviews_selected', 'label' => esc_html__('Testimonials to Show', 'hvac'), 'name' => 'loc_reviews_selected', 'type' => 'relationship', 'post_type' => array('testimonial'), 'filters' => array('search'), 'return_format' => 'id', 'instructions' => esc_html__('Optional. Leave empty to show every published testimonial.', 'hvac')),
				array('key' => 'field_hvac_lc_reviews_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'loc_reviews_count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'instructions' => esc_html__('Used when no testimonials are selected above. Leave blank to show all.', 'hvac')),

				/* -------- CTA -------- */
				array('key' => 'field_hvac_lc_cta_tab', 'label' => esc_html__('CTA', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_lc_cta_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'loc_cta_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Get Your Free California AC Inspection Today'),
				array('key' => 'field_hvac_lc_cta_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'loc_cta_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Schedule a free, no-obligation inspection with our local California team and get honest recommendations you can trust.'),
				array('key' => 'field_hvac_lc_cta_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'loc_cta_button', 'type' => 'link', 'return_format' => 'array'),
			),
			'location' => array(
				array(
					array('param' => 'page_template', 'operator' => '==', 'value' => 'page-location.php'),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_location_page_fields');
