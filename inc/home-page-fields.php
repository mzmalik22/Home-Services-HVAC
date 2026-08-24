<?php

/**
 * ACF / Secure Custom Fields for the "Home Page" template (page-home.php).
 *
 * Every section of the landing page (Figma: Landing page UI V2 Final) is
 * editable here. The field group only appears when a Page uses the "Home Page"
 * template. Repeaters left empty fall back to Figma-matching defaults rendered
 * by the template.
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
					'key'           => 'field_home_hero_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'hero_eyebrow',
					'type'          => 'text',
					'default_value' => 'Reliable Heating & Cooling',
				),
				array(
					'key'           => 'field_home_hero_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'hero_heading',
					'type'          => 'text',
					'default_value' => 'Reliable HVAC Services for Homes & Businesses',
				),
				array(
					'key'           => 'field_home_hero_tagline',
					'label'         => esc_html__('Tagline', 'hvac'),
					'name'          => 'hero_tagline',
					'type'          => 'text',
					'instructions'  => esc_html__('The bold line under the heading, e.g. "Installation | Replacement | Repair".', 'hvac'),
					'default_value' => 'Installation | Replacement | Repair',
				),
				array(
					'key'           => 'field_home_hero_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'hero_subtext',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Keep your home or business comfortable with professional heating and cooling services. From new system installations and HVAC replacements to emergency repairs, our experienced technicians provide dependable solutions tailored to your property.',
				),
				array(
					'key'           => 'field_home_hero_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'hero_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_home_hero_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'hero_background_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_home_hero_form_msg',
					'label' => esc_html__('Booking Form', 'hvac'),
					'type'  => 'message',
					'message' => esc_html__('The booking form card shown on the right of the hero.', 'hvac'),
				),
				array(
					'key'           => 'field_home_hero_form_eyebrow',
					'label'         => esc_html__('Form Eyebrow', 'hvac'),
					'name'          => 'hero_form_eyebrow',
					'type'          => 'text',
					'default_value' => 'Effortless Cooling, Anytime',
				),
				array(
					'key'           => 'field_home_hero_form_title',
					'label'         => esc_html__('Form Title', 'hvac'),
					'name'          => 'hero_form_title',
					'type'          => 'text',
					'default_value' => 'Booking For Your Comfort',
				),
				array(
					'key'           => 'field_home_hero_form_subtitle',
					'label'         => esc_html__('Form Subtitle', 'hvac'),
					'name'          => 'hero_form_subtitle',
					'type'          => 'text',
					'default_value' => 'Keep your air conditioner running at peak performance with expert repairs.',
				),
				array(
					'key'           => 'field_home_hero_form_services',
					'label'         => esc_html__('Service Options', 'hvac'),
					'name'          => 'hero_form_services',
					'type'          => 'textarea',
					'rows'          => 5,
					'instructions'  => esc_html__('Options for the "Choose services" dropdown- one per line.', 'hvac'),
					'default_value' => "AC Repair\nAC Installation\nAC Maintenance\nEmergency Service\nDuct Cleaning",
				),
				array(
					'key'           => 'field_home_hero_form_button',
					'label'         => esc_html__('Form Button Label', 'hvac'),
					'name'          => 'hero_form_button',
					'type'          => 'text',
					'default_value' => 'Book Now',
				),
				array(
					'key'          => 'field_home_hero_form_shortcode',
					'label'        => esc_html__('Form Shortcode', 'hvac'),
					'name'         => 'hero_form_shortcode',
					'type'         => 'text',
					'instructions' => esc_html__('Optional. Paste a form shortcode to replace the built-in booking form.', 'hvac'),
				),
				array(
					'key'          => 'field_home_hero_features',
					'label'        => esc_html__('Feature Cards', 'hvac'),
					'name'         => 'hero_features',
					'type'         => 'repeater',
					'layout'       => 'block',
					'max'          => 3,
					'button_label' => esc_html__('Add Feature Card', 'hvac'),
					'instructions' => esc_html__('The three cards that sit across the bottom of the hero.', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_home_hero_feature_icon',
							'label'         => esc_html__('Icon', 'hvac'),
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'thumbnail',
							'instructions'  => esc_html__('Optional. Falls back to a built-in icon.', 'hvac'),
						),
						array(
							'key'   => 'field_home_hero_feature_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_hero_feature_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),
				array(
					'key'          => 'field_home_hero_checklist',
					'label'        => esc_html__('Checklist', 'hvac'),
					'name'         => 'hero_checklist',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Checklist Item', 'hvac'),
					'instructions' => esc_html__('Short trust-signal bullets shown under the hero content, e.g. "Licensed & Certified HVAC Professionals".', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'  => 'field_home_hero_checklist_text',
							'label' => esc_html__('Text', 'hvac'),
							'name' => 'text',
							'type' => 'text',
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
					'key'           => 'field_home_about_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'about_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
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
					'default_value' => 'Trusted Heating & Cooling Professionals',
				),
				array(
					'key'   => 'field_home_about_text',
					'label' => esc_html__('Text', 'hvac'),
					'name'  => 'about_text',
					'type'  => 'wysiwyg',
					'media_upload' => 0,
					'toolbar' => 'basic',
				),
				array(
					'key'           => 'field_home_about_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'about_button',
					'type'          => 'link',
					'return_format' => 'array',
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
					'default_value' => 'Our HVAC Services',
				),
				array(
					'key'           => 'field_home_services_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'services_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_home_services_selected',
					'label'         => esc_html__('Services to Show', 'hvac'),
					'name'          => 'home_services_selected',
					'type'          => 'relationship',
					'post_type'     => array('service'),
					'filters'       => array('search'),
					'return_format' => 'id',
					'instructions'  => esc_html__('Optional. Leave empty to show the latest services automatically. Select specific services to feature only those, in order.', 'hvac'),
				),
				array(
					'key'           => 'field_home_services_count',
					'label'         => esc_html__('Number to Show', 'hvac'),
					'name'          => 'services_count',
					'type'          => 'number',
					'default_value' => 6,
					'min'           => 1,
					'instructions'  => esc_html__('How many services to show when none are selected above.', 'hvac'),
				),

				/* ---------------- WHY CHOOSE US ---------------- */
				array(
					'key'   => 'field_home_whyus_tab',
					'label' => esc_html__('Why Choose Us', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_whyus_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'whyus_eyebrow',
					'type'          => 'text',
					'default_value' => 'Why Choose Us',
				),
				array(
					'key'           => 'field_home_whyus_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'whyus_heading',
					'type'          => 'text',
					'default_value' => 'Why Choose HVAC Reliable Pros?',
				),
				array(
					'key'   => 'field_home_whyus_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'whyus_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_whyus_items',
					'label'        => esc_html__('Reasons', 'hvac'),
					'name'         => 'whyus_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Reason', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_whyus_item_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_whyus_item_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				/* ---------------- HOW IT WORKS ---------------- */
				array(
					'key'   => 'field_home_how_tab',
					'label' => esc_html__('How It Works', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_how_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'how_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'           => 'field_home_how_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'how_eyebrow',
					'type'          => 'text',
					'default_value' => 'How It Works',
				),
				array(
					'key'           => 'field_home_how_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'how_heading',
					'type'          => 'text',
					'default_value' => 'Our HVAC Process',
				),
				array(
					'key'           => 'field_home_how_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'how_subtext',
					'type'          => 'textarea',
					'rows'          => 3,
				),
				array(
					'key'          => 'field_home_how_steps',
					'label'        => esc_html__('Steps', 'hvac'),
					'name'         => 'how_steps',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Step', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_how_step_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_how_step_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),

				/* ---------------- TESTIMONIALS ---------------- */
				array(
					'key'   => 'field_home_testi_tab',
					'label' => esc_html__('Testimonials', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_testi_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'testi_eyebrow',
					'type'          => 'text',
					'default_value' => 'What Our Customers Are Saying',
				),
				array(
					'key'           => 'field_home_testi_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'testi_heading',
					'type'          => 'text',
					'default_value' => 'Hear From Our Happy Customers',
				),
				array(
					'key'           => 'field_home_testi_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'testi_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
				),
				array(
					'key'          => 'field_home_testimonials',
					'label'        => esc_html__('Testimonials', 'hvac'),
					'name'         => 'testimonials',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Testimonial', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_home_testi_image',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_home_testi_quote',
							'label' => esc_html__('Quote', 'hvac'),
							'name'  => 'quote',
							'type'  => 'textarea',
							'rows'  => 4,
						),
						array(
							'key'           => 'field_home_testi_headshot',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'headshot',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_home_testi_name',
							'label' => esc_html__('Name', 'hvac'),
							'name'  => 'name',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_testi_role',
							'label' => esc_html__('Role', 'hvac'),
							'name'  => 'role',
							'type'  => 'text',
						),
						array(
							'key'           => 'field_home_testi_rating',
							'label'         => esc_html__('Rating (1-5)', 'hvac'),
							'name'          => 'rating',
							'type'          => 'number',
							'min'           => 1,
							'max'           => 5,
							'default_value' => 5,
						),
					),
				),

				/* ---------------- NEWS / INSIGHTS ---------------- */
				array(
					'key'   => 'field_home_news_tab',
					'label' => esc_html__('News', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_news_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'news_eyebrow',
					'type'          => 'text',
					'default_value' => 'Blog & News',
				),
				array(
					'key'           => 'field_home_news_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'news_heading',
					'type'          => 'text',
					'default_value' => 'Updates, Tips, And Insights',
				),
				array(
							'key'   => 'field_home_news_subtext',
							'label' => esc_html__('Quote', 'hvac'),
							'name'  => 'news_subtext',
							'type'  => 'textarea',
							'rows'  => 4,
				),
				array(
					'key'           => 'field_home_news_source',
					'label'         => esc_html__('Source', 'hvac'),
					'name'          => 'news_source',
					'type'          => 'select',
					'choices'       => array(
						'latest' => esc_html__('Latest posts (automatic)', 'hvac'),
						'manual' => esc_html__('Manual cards', 'hvac'),
					),
					'default_value' => 'latest',
				),
				array(
					'key'               => 'field_home_news_cards',
					'label'             => esc_html__('Manual Cards', 'hvac'),
					'name'              => 'news_cards',
					'type'              => 'repeater',
					'layout'            => 'block',
					'button_label'      => esc_html__('Add Card', 'hvac'),
					'instructions'      => esc_html__('First card is shown large; the next two are shown in the side list.', 'hvac'),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_home_news_source',
								'operator' => '==',
								'value'    => 'manual',
							),
						),
					),
					'sub_fields'        => array(
						array(
							'key'           => 'field_home_news_card_image',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_home_news_card_category',
							'label' => esc_html__('Category', 'hvac'),
							'name'  => 'category',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_news_card_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_news_card_date',
							'label' => esc_html__('Date', 'hvac'),
							'name'  => 'date',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_news_card_excerpt',
							'label' => esc_html__('Excerpt', 'hvac'),
							'name'  => 'excerpt',
							'type'  => 'textarea',
							'rows'  => 2,
						),
						array(
							'key'           => 'field_home_news_card_link',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				/* ---------------- WHY IT MATTERS ---------------- */
				array(
					'key'   => 'field_home_matters_tab',
					'label' => esc_html__('Why It Matters', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_matters_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'matters_eyebrow',
					'type'          => 'text',
					'default_value' => 'Why It Matters',
				),
				array(
					'key'           => 'field_home_matters_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'matters_heading',
					'type'          => 'text',
					'default_value' => 'Why Professional HVAC Service Matters',
				),
				array(
					'key'   => 'field_home_matters_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'matters_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_matters_items',
					'label'        => esc_html__('Points', 'hvac'),
					'name'         => 'matters_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Point', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_matters_item_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_matters_item_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				/* ---------------- SYSTEM OPTIONS ---------------- */
				array(
					'key'   => 'field_home_options_tab',
					'label' => esc_html__('System Options', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_options_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'options_eyebrow',
					'type'          => 'text',
					'default_value' => 'System Options',
				),
				array(
					'key'           => 'field_home_options_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'options_heading',
					'type'          => 'text',
					'default_value' => 'Heating & Cooling System Options',
				),
				array(
					'key'   => 'field_home_options_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'options_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_options_items',
					'label'        => esc_html__('Systems', 'hvac'),
					'name'         => 'options_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add System', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_options_item_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_options_item_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				/* ---------------- RECENT PROJECTS ---------------- */
				array(
					'key'   => 'field_home_projects_tab',
					'label' => esc_html__('Recent Projects', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_projects_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'projects_eyebrow',
					'type'          => 'text',
					'default_value' => 'Our Work',
				),
				array(
					'key'           => 'field_home_projects_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'projects_heading',
					'type'          => 'text',
					'default_value' => 'Recent HVAC Projects',
				),
				array(
					'key'   => 'field_home_projects_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'projects_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_projects_items',
					'label'        => esc_html__('Projects', 'hvac'),
					'name'         => 'projects_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Project', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_home_projects_item_image',
							'label'         => esc_html__('Image', 'hvac'),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_home_projects_item_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_projects_item_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				/* ---------------- AREAS WE SERVE ---------------- */
				array(
					'key'   => 'field_home_areas_tab',
					'label' => esc_html__('Areas We Serve', 'hvac'),
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
					'default_value' => 'Areas We Serve',
				),
				array(
					'key'   => 'field_home_areas_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'areas_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_areas_items',
					'label'        => esc_html__('Areas', 'hvac'),
					'name'         => 'areas_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Area', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_home_areas_item_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_areas_item_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
						array(
							'key'           => 'field_home_areas_item_link',
							'label'         => esc_html__('Link', 'hvac'),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				/* ---------------- CTA BANNER ---------------- */
				array(
					'key'   => 'field_home_cta_tab',
					'label' => esc_html__('CTA Banner', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_home_cta_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'cta_heading',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Ready for Reliable Heating & Cooling?',
				),
				array(
					'key'   => 'field_home_cta_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'cta_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_home_cta_checklist',
					'label'        => esc_html__('Checklist', 'hvac'),
					'name'         => 'cta_checklist',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Checklist Item', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'  => 'field_home_cta_checklist_text',
							'label' => esc_html__('Text', 'hvac'),
							'name' => 'text',
							'type' => 'text',
						),
					),
				),
				array(
					'key'           => 'field_home_cta_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'cta_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_home_cta_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'cta_background_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
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
