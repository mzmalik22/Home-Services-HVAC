<?php

/**
 * ACF / Secure Custom Fields for the "Home Page" template (page-home.php).
 *
 * Every section of the landing page is editable here. The field group only
 * appears when a Page uses the "Home Page" template. Repeaters that are left
 * empty fall back to Figma-matching defaults rendered by the template.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_home_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_home_page',
			'title'    => esc_html__('Home Page', 'hvac'),
			'fields'   => array(

				/* ---------------- HERO ---------------- */
				array(
					'key'   => 'field_home_hero_tab',
					'label' => esc_html__('Hero', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_home_hero_eyebrow',
					'label'        => esc_html__('Eyebrow Items', 'hvac'),
					'name'         => 'hero_eyebrow',
					'type'         => 'repeater',
					'layout'       => 'table',
					'max'          => 4,
					'button_label' => esc_html__('Add Item', 'hvac'),
					'instructions' => esc_html__('Displayed in a horizontal row. The first item shows an orange dot, the rest white. Maximum 4.', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_hero_eyebrow_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'           => 'field_home_hero_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'hero_heading',
					'type'          => 'text',
					'default_value' => 'Trusted HVAC Solutions Across the USA',
				),
				array(
					'key'           => 'field_home_hero_subtext',
					'label'         => esc_html__('Sub-text', 'hvac'),
					'name'          => 'hero_subtext',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Expert heating and cooling repair, installation, and emergency solutions designed to keep your home comfortable with dependable service and quality workmanship.',
				),
				array(
					'key'          => 'field_home_hero_features',
					'label'        => esc_html__('Feature Bullets', 'hvac'),
					'name'         => 'hero_features',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Feature', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_hero_feature',
							'label' => esc_html__('Feature', 'hvac'),
							'name'  => 'feature',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'           => 'field_home_background_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'hero_background_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'           => 'field_home_hero_form_title',
					'label'         => esc_html__('Form Title', 'hvac'),
					'name'          => 'hero_form_title',
					'type'          => 'text',
					'default_value' => 'Get Your Free HVAC Estimate',
				),
				array(
					'key'           => 'field_home_hero_form_subtitle',
					'label'         => esc_html__('Form Subtitle', 'hvac'),
					'name'          => 'hero_form_subtitle',
					'type'          => 'text',
					'default_value' => 'Fast response. No spam. No obligation.',
				),
				array(
					'key'          => 'field_home_hero_form_shortcode',
					'label'        => esc_html__('Form Shortcode', 'hvac'),
					'name'         => 'hero_form_shortcode',
					'type'         => 'text',
					'instructions' => esc_html__('Paste a form shortcode (Contact Form 7, WPForms, etc.). Leave empty to show the styled placeholder form.', 'hvac'),
				),

				/* ---------------- TRUST BAR ---------------- */
				array(
					'key'   => 'field_home_trust_tab',
					'label' => esc_html__('Trust Bar', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_home_trust_items',
					'label'        => esc_html__('Trust Items', 'hvac'),
					'name'         => 'trust_items',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Item', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_home_trust_icon',
							'label'         => esc_html__('Icon', 'hvac'),
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'thumbnail',
							'instructions'  => esc_html__('Optional. SVG or PNG. Falls back to a check icon if empty.', 'hvac'),
						),
						array(
							'key'   => 'field_home_trust_label',
							'label' => esc_html__('Label', 'hvac'),
							'name'  => 'label',
							'type'  => 'text',
						),
					),
				),

				/* ---------------- ABOUT ---------------- */
				array(
					'key'   => 'field_home_about_tab',
					'label' => esc_html__('About', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_about_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'about_eyebrow',
					'type'          => 'text',
					'default_value' => 'About Us',
				),
				array(
					'key'           => 'field_home_about_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'about_heading',
					'type'          => 'text',
					'default_value' => 'Trusted HVAC Solutions, Built Around Your Needs.',
				),
				array(
					'key'          => 'field_home_about_text',
					'label'        => esc_html__('Text', 'hvac'),
					'name'         => 'about_text',
					'type'         => 'wysiwyg',
					'tabs'         => 'visual',
					'media_upload' => 0,
				),
				array(
					'key'           => 'field_home_about_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'about_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				/* ---------------- SERVICES ---------------- */
				array(
					'key'   => 'field_home_services_tab',
					'label' => esc_html__('Services', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_services_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'services_eyebrow',
					'type'          => 'text',
					'default_value' => 'Our Services',
				),
				array(
					'key'           => 'field_home_services_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_heading',
					'type'          => 'text',
					'default_value' => 'Complete HVAC Solutions for Every Home',
				),
				array(
					'key'           => 'field_home_services_subtext',
					'label'         => esc_html__('Sub-text', 'hvac'),
					'name'          => 'services_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'From minor repairs to complete system replacements, we help homeowners find reliable HVAC solutions designed to keep their homes comfortable for years to come.',
				),
				array(
					'key'          => 'field_home_services_items',
					'label'        => esc_html__('Service Cards', 'hvac'),
					'name'         => 'services',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Service', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_home_service_image',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_home_service_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_service_text',
							'label' => esc_html__('Description', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
						array(
							'key'           => 'field_home_service_link',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				/* ---------------- STATS ---------------- */
				array(
					'key'           => 'field_home_stats_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'stats_eyebrow',
					'type'          => 'text',
					'default_value' => 'Our Services',
				),
				array(
					'key'   => 'field_home_stats_tab',
					'label' => esc_html__('Stats', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_stats_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'stats_heading',
					'type'          => 'text',
					'default_value' => 'Trusted HVAC Support Across the USA',
				),
				array(
					'key'          => 'field_home_stats_items',
					'label'        => esc_html__('Stats', 'hvac'),
					'name'         => 'stats',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Stat', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_stat_value',
							'label' => esc_html__('Value', 'hvac'),
							'name'  => 'value',
							'type'         => 'wysiwyg',
							'tabs'         => 'visual',
						),
						array(
							'key'   => 'field_home_stat_label',
							'label' => esc_html__('Label', 'hvac'),
							'name'  => 'label',
							'type'  => 'text',
						),
					),
				),

				/* ---------------- SERVICE AREAS ---------------- */
				array(
					'key'   => 'field_home_areas_tab',
					'label' => esc_html__('Service Areas', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_areas_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'areas_eyebrow',
					'type'          => 'text',
					'default_value' => 'Service Areas',
				),
				array(
					'key'           => 'field_home_areas_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'areas_heading',
					'type'          => 'text',
					'default_value' => 'Reliable HVAC Services Across the USA.',
				),
				array(
					'key'           => 'field_home_areas_text',
					'label'         => esc_html__('Text', 'hvac'),
					'name'          => 'areas_text',
					'type'         => 'wysiwyg',
					'tabs'         => 'visual',
				),
				array(
					'key'           => 'field_home_areas_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'areas_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_home_areas_image',
					'label'         => esc_html__('Map Image', 'hvac'),
					'name'          => 'areas_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				/* ---------------- BLOG / TIPS ---------------- */
				array(
					'key'   => 'field_home_blog_tab',
					'label' => esc_html__('Blog', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_blog_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'blog_eyebrow',
					'type'          => 'text',
					'default_value' => 'From Our Blog',
				),
				array(
					'key'           => 'field_home_blog_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'blog_heading',
					'type'          => 'text',
					'default_value' => 'HVAC Tips & Insights for a Comfortable Home',
				),
				array(
					'key'           => 'field_home_blog_subtext',
					'label'         => esc_html__('Sub-text', 'hvac'),
					'name'          => 'blog_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Get practical HVAC advice, maintenance tips, and expert insights to help keep your home comfortable and make smarter system decisions.',
				),
				array(
					'key'          => 'field_home_blog_source',
					'label'        => esc_html__('Cards Source', 'hvac'),
					'name'         => 'blog_source',
					'type'         => 'select',
					'choices'      => array(
						'latest' => esc_html__('Latest blog posts (automatic)', 'hvac'),
						'manual' => esc_html__('Manual cards (below)', 'hvac'),
					),
					'default_value' => 'latest',
				),
				array(
					'key'               => 'field_home_blog_cards',
					'label'             => esc_html__('Manual Cards', 'hvac'),
					'name'              => 'blog_cards',
					'type'              => 'repeater',
					'layout'            => 'block',
					'button_label'      => esc_html__('Add Card', 'hvac'),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_home_blog_source',
								'operator' => '==',
								'value'    => 'manual',
							),
						),
					),
					'sub_fields'        => array(
						array(
							'key'           => 'field_home_blog_card_image',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'array',
						),
						array(
							'key'   => 'field_home_blog_card_category',
							'label' => esc_html__('Category', 'hvac'),
							'name'  => 'category',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_blog_card_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'           => 'field_home_blog_card_link',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				/* ---------------- FAQ ---------------- */
				array(
					'key'   => 'field_home_faq_tab',
					'label' => esc_html__('FAQ', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_faq_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'faq_eyebrow',
					'type'          => 'text',
					'default_value' => 'FAQ',
				),
				array(
					'key'           => 'field_home_faq_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'faq_heading',
					'type'          => 'text',
					'default_value' => 'HVAC Questions? We\'ve Got You Covered.',
				),
				array(
					'key'          => 'field_home_faqs',
					'label'        => esc_html__('Questions', 'hvac'),
					'name'         => 'faqs',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Question', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_faq_question',
							'label' => esc_html__('Question', 'hvac'),
							'name'  => 'question',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_faq_answer',
							'label' => esc_html__('Answer', 'hvac'),
							'name'  => 'answer',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),

				/* ---------------- FINAL CTA ---------------- */
				array(
					'key'   => 'field_home_cta_tab',
					'label' => esc_html__('Final CTA', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_cta_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'cta_eyebrow',
					'type'          => 'text',
					'default_value' => 'Ready to Get Started?',
				),
				array(
					'key'           => 'field_home_cta_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'cta_heading',
					'type'          => 'text',
					'default_value' => 'Not Sure What Your HVAC System Needs?',
				),
				array(
					'key'           => 'field_home_cta_text',
					'label'         => esc_html__('Text', 'hvac'),
					'name'          => 'cta_text',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Schedule a professional HVAC inspection and get clear, honest recommendations from our HVAC experts — free, no obligation.',
				),
				array(
					'key'           => 'field_home_cta_phone',
					'label'         => esc_html__('Phone', 'hvac'),
					'name'          => 'cta_phone',
					'type'          => 'text',
					'default_value' => '(512) 555-0199',
				),
				array(
					'key'           => 'field_home_cta_form_title',
					'label'         => esc_html__('Form Title', 'hvac'),
					'name'          => 'cta_form_title',
					'type'          => 'text',
					'default_value' => 'Get Your Free HVAC Estimate',
				),
				array(
					'key'           => 'field_home_cta_form_subtitle',
					'label'         => esc_html__('Form Subtitle', 'hvac'),
					'name'          => 'cta_form_subtitle',
					'type'          => 'text',
					'default_value' => 'Fast response. No spam. No obligation.',
				),
				array(
					'key'          => 'field_home_cta_form_shortcode',
					'label'        => esc_html__('Form Shortcode', 'hvac'),
					'name'         => 'cta_form_shortcode',
					'type'         => 'text',
					'instructions' => esc_html__('Paste a form shortcode. Leave empty to show the styled placeholder form.', 'hvac'),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-home.php',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_home_page_fields');
