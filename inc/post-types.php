<?php

/**
 * Custom post types + their fields.
 *
 * Registers the "Service" CPT (used by archive-service.php) plus:
 *   - a per-service "Badge" field (Secure Custom Fields), and
 *   - a "Services Page" options subpage (under Theme Options) that controls the
 *     extra sections on the services listing page.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Register the "Service" custom post type.
 */
function hvac_register_service_cpt()
{
	$labels = array(
		'name'               => esc_html__('Services', 'hvac'),
		'singular_name'      => esc_html__('Service', 'hvac'),
		'add_new'            => esc_html__('Add New', 'hvac'),
		'add_new_item'       => esc_html__('Add New Service', 'hvac'),
		'edit_item'          => esc_html__('Edit Service', 'hvac'),
		'new_item'           => esc_html__('New Service', 'hvac'),
		'view_item'          => esc_html__('View Service', 'hvac'),
		'view_items'         => esc_html__('View Services', 'hvac'),
		'search_items'       => esc_html__('Search Services', 'hvac'),
		'not_found'          => esc_html__('No services found', 'hvac'),
		'not_found_in_trash' => esc_html__('No services found in Trash', 'hvac'),
		'all_items'          => esc_html__('All Services', 'hvac'),
		'menu_name'          => esc_html__('Services', 'hvac'),
	);

	register_post_type(
		'service',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-admin-tools',
			'menu_position' => 26,
			'show_in_rest' => true,
			'rewrite'      => array(
				'slug'       => 'services',
				'with_front' => false,
			),
			'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		)
	);
}
add_action('init', 'hvac_register_service_cpt');

/**
 * Flush rewrite rules once after the Service CPT is first registered, so the
 * /services/ archive URL works without a manual Permalinks re-save.
 */
function hvac_maybe_flush_service_rewrites()
{
	if ('1' !== get_option('hvac_service_rewrites_flushed')) {
		flush_rewrite_rules(false);
		update_option('hvac_service_rewrites_flushed', '1');
	}
}
add_action('init', 'hvac_maybe_flush_service_rewrites', 20);

/**
 * Per-service fields (badge shown over the card image).
 */
function hvac_service_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_service',
			'title'    => esc_html__('Service Details', 'hvac'),
			'fields'   => array(
				array(
					'key'          => 'field_hvac_service_badge',
					'label'        => esc_html__('Badge', 'hvac'),
					'name'         => 'service_badge',
					'type'         => 'text',
					'instructions' => esc_html__('Small label shown over the image on the services grid, e.g. "24/7 Support".', 'hvac'),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'service',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'side',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_service_fields');

/**
 * Service detail page fields (single-service.php). Every section is optional
 * and only renders when it has content.
 */
function hvac_service_detail_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_service_detail',
			'title'    => esc_html__('Service Detail Page', 'hvac'),
			'fields'   => array(

				// --- Hero ---
				array(
					'key'   => 'field_hvac_sd_hero_tab',
					'label' => esc_html__('Hero', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_hvac_sd_intro',
					'label'        => esc_html__('Intro', 'hvac'),
					'name'         => 'detail_intro',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => esc_html__('Short paragraph under the service title in the hero.', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_sd_cta',
					'label'         => esc_html__('Hero Button', 'hvac'),
					'name'          => 'detail_cta',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'          => 'field_hvac_sd_phone',
					'label'        => esc_html__('Phone', 'hvac'),
					'name'         => 'detail_phone',
					'type'         => 'text',
					'instructions' => esc_html__('Optional click-to-call shown next to the hero button.', 'hvac'),
				),

				// --- Overview ---
				array(
					'key'   => 'field_hvac_sd_overview_tab',
					'label' => esc_html__('Overview', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sd_overview_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'overview_heading',
					'type'          => 'text',
				),
				array(
					'key'          => 'field_hvac_sd_overview_content',
					'label'        => esc_html__('Content', 'hvac'),
					'name'         => 'overview_content',
					'type'         => 'wysiwyg',
					'toolbar'      => 'full',
					'media_upload' => 1,
					'instructions' => esc_html__('Main body copy. Falls back to the post editor content if left empty.', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_sd_overview_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'overview_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'instructions'  => esc_html__('Image shown beside the overview text. Upload one here- the featured image is no longer used for this section.', 'hvac'),
				),

				// --- Highlights / what you get ---
				array(
					'key'   => 'field_hvac_sd_highlights_tab',
					'label' => esc_html__('Highlights', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sd_highlights_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'highlights_heading',
					'type'          => 'text',
					'default_value' => 'What You Get',
				),
				array(
					'key'          => 'field_hvac_sd_highlights',
					'label'        => esc_html__('Highlight Items', 'hvac'),
					'name'         => 'highlights',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__('Add Item', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_hvac_sd_highlight_item',
							'label' => esc_html__('Item', 'hvac'),
							'name'  => 'item',
							'type'  => 'text',
						),
					),
				),

				// --- Why choose us ---
				array(
					'key'   => 'field_hvac_sd_whyus_tab',
					'label' => esc_html__('Why Us', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_hvac_sd_whyus_heading',
					'label' => esc_html__('Heading', 'hvac'),
					'name'  => 'whyus_heading',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_hvac_sd_whyus_text',
					'label'        => esc_html__('Intro Text', 'hvac'),
					'name'         => 'whyus_text',
					'type'         => 'wysiwyg',
					'toolbar'      => 'basic',
					'media_upload' => 0,
					'instructions' => esc_html__('Short lead paragraph shown above the point cards.', 'hvac'),
				),
				array(
					'key'          => 'field_hvac_sd_whyus_points',
					'label'        => esc_html__('Points', 'hvac'),
					'name'         => 'whyus_points',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Point', 'hvac'),
					'instructions' => esc_html__('Shown as cards. Leave empty to use sensible defaults.', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_hvac_sd_whyus_point_icon',
							'label'         => esc_html__('Icon', 'hvac'),
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'thumbnail',
							'instructions'  => esc_html__('Optional. Falls back to a built-in icon.', 'hvac'),
						),
						array(
							'key'   => 'field_hvac_sd_whyus_point_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_hvac_sd_whyus_point_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				// --- FAQ ---
				array(
					'key'   => 'field_hvac_sd_faq_tab',
					'label' => esc_html__('FAQ', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_hvac_sd_faqs',
					'label'        => esc_html__('FAQs', 'hvac'),
					'name'         => 'faqs',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add FAQ', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_hvac_sd_faq_q',
							'label' => esc_html__('Question', 'hvac'),
							'name'  => 'question',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_hvac_sd_faq_a',
							'label' => esc_html__('Answer', 'hvac'),
							'name'  => 'answer',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),

				// --- How it works / process ---
				array(
					'key'   => 'field_hvac_sd_process_tab',
					'label' => esc_html__('How It Works', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sd_process_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'process_heading',
					'type'          => 'text',
					'default_value' => 'How It Works',
				),
				array(
					'key'   => 'field_hvac_sd_process_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'process_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_hvac_sd_process_image',
					'label'         => esc_html__('Image', 'hvac'),
					'name'          => 'process_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'          => 'field_hvac_sd_process_steps',
					'label'        => esc_html__('Steps', 'hvac'),
					'name'         => 'process_steps',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Step', 'hvac'),
					'instructions' => esc_html__('Numbered automatically. Leave empty to use sensible defaults.', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'   => 'field_hvac_sd_process_step_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_hvac_sd_process_step_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				// --- Reviews ---
				array(
					'key'   => 'field_hvac_sd_reviews_tab',
					'label' => esc_html__('Reviews', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sd_reviews_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'reviews_heading',
					'type'          => 'text',
					'default_value' => 'What Our Customers Say',
				),
				array(
					'key'   => 'field_hvac_sd_reviews_subtext',
					'label' => esc_html__('Subtext', 'hvac'),
					'name'  => 'reviews_subtext',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_hvac_sd_reviews_selected',
					'label'         => esc_html__('Testimonials to Show', 'hvac'),
					'name'          => 'reviews_selected',
					'type'          => 'relationship',
					'post_type'     => array('testimonial'),
					'filters'       => array('search'),
					'return_format' => 'id',
					'instructions'  => esc_html__('Optional. Leave empty to show every published testimonial.', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_sd_reviews_count',
					'label'         => esc_html__('Number to Show', 'hvac'),
					'name'          => 'reviews_count',
					'type'          => 'number',
					'default_value' => 3,
					'min'           => 1,
					'instructions'  => esc_html__('Used when no testimonials are selected above. Leave blank to show all.', 'hvac'),
				),

				// --- Related + CTA ---
				array(
					'key'   => 'field_hvac_sd_more_tab',
					'label' => esc_html__('Related & CTA', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sd_related_heading',
					'label'         => esc_html__('Related Heading', 'hvac'),
					'name'          => 'related_heading',
					'type'          => 'text',
					'default_value' => 'Related Services',
				),
				array(
					'key'          => 'field_hvac_sd_cta_heading',
					'label'        => esc_html__('CTA Heading', 'hvac'),
					'name'         => 'detail_cta_heading',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => esc_html__('Bottom banner heading. Falls back to the global Services Page CTA.', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_sd_cta_button',
					'label'         => esc_html__('CTA Button', 'hvac'),
					'name'          => 'detail_cta_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'service',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_service_detail_fields');

/**
 * "Services Page" options subpage (under Theme Options)- controls the extra
 * sections on the services listing page (archive-service.php).
 */
function hvac_services_page_options()
{
	if (! function_exists('acf_add_options_sub_page')) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__('Services Page', 'hvac'),
			'menu_title'  => esc_html__('Services Page', 'hvac'),
			'menu_slug'   => 'hvac-theme-options-services',
			'parent_slug' => 'hvac-theme-options',
			'capability'  => 'manage_options',
		)
	);
}
add_action('acf/init', 'hvac_services_page_options');

/**
 * Fields for the "Services Page" options subpage.
 */
function hvac_services_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_services_page',
			'title'    => esc_html__('Services Page', 'hvac'),
			'fields'   => array(

				// --- Page hero ---
				array(
					'key'   => 'field_hvac_sp_hero_tab',
					'label' => esc_html__('Hero', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sp_hero_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'services_hero_eyebrow',
					'type'          => 'text',
					'default_value' => 'Our Services',
				),
				array(
					'key'           => 'field_hvac_sp_hero_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_hero_heading',
					'type'          => 'text',
					'default_value' => 'Professional AC Services for Ultimate Comfort',
				),
				array(
					'key'           => 'field_hvac_sp_hero_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'services_hero_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Explore our full range of AC repair, maintenance, and installation services designed to keep your home cool and comfortable all year round.',
				),
				array(
					'key'           => 'field_hvac_sp_hero_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'services_hero_bg',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				// --- Benefits ---
				array(
					'key'   => 'field_hvac_sp_benefits_tab',
					'label' => esc_html__('Benefits', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sp_benefits_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'services_benefits_eyebrow',
					'type'          => 'text',
					'default_value' => 'Why Choose Us',
				),
				array(
					'key'           => 'field_hvac_sp_benefits_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_benefits_heading',
					'type'          => 'text',
					'default_value' => 'Comfort You Can Count On',
				),
				array(
					'key'          => 'field_hvac_sp_benefits',
					'label'        => esc_html__('Benefit Cards', 'hvac'),
					'name'         => 'services_benefits',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Benefit', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_hvac_sp_benefit_icon',
							'label'         => esc_html__('Icon', 'hvac'),
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'thumbnail',
							'instructions'  => esc_html__('Optional. Falls back to a built-in icon.', 'hvac'),
						),
						array(
							'key'   => 'field_hvac_sp_benefit_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_hvac_sp_benefit_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				// --- CTA banner ---
				array(
					'key'   => 'field_hvac_sp_cta_tab',
					'label' => esc_html__('CTA Banner', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_sp_cta_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_cta_heading',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Ready to Enjoy Reliable, Worry-Free Cooling? Book Your AC Service Today.',
				),
				array(
					'key'           => 'field_hvac_sp_cta_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'services_cta_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_hvac_sp_cta_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'services_cta_bg',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-theme-options-services',
					),
				),
			),
		)
	);
}
add_action('acf/init', 'hvac_services_page_fields');

/**
 * Page-level fields for the "Service" page template (page-services.php).
 *
 * Mirrors the "Services Page" options fields so the same sections can be edited
 * directly on a Page, and adds a Relationship field to choose which services to
 * list (empty = all services).
 */
function hvac_services_page_template_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_services_page_tpl',
			'title'    => esc_html__('Services Page', 'hvac'),
			'fields'   => array(

				// --- Page hero ---
				array(
					'key'   => 'field_hvac_spt_hero_tab',
					'label' => esc_html__('Hero', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_spt_hero_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'services_hero_eyebrow',
					'type'          => 'text',
					'default_value' => 'Our Services',
				),
				array(
					'key'           => 'field_hvac_spt_hero_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_hero_heading',
					'type'          => 'text',
					'default_value' => 'Professional AC Services for Ultimate Comfort',
				),
				array(
					'key'           => 'field_hvac_spt_hero_subtext',
					'label'         => esc_html__('Subtext', 'hvac'),
					'name'          => 'services_hero_subtext',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Explore our full range of AC repair, maintenance, and installation services designed to keep your home cool and comfortable all year round.',
				),
				array(
					'key'           => 'field_hvac_spt_hero_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'services_hero_bg',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				// --- Services to list ---
				array(
					'key'   => 'field_hvac_spt_list_tab',
					'label' => esc_html__('Services List', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_spt_services_selected',
					'label'         => esc_html__('Services to Show', 'hvac'),
					'name'          => 'services_selected',
					'type'          => 'relationship',
					'post_type'     => array('service'),
					'filters'       => array('search'),
					'return_format' => 'id',
					'instructions'  => esc_html__('Leave empty to show all services (paginated). Select specific services to show only those, in the order chosen.', 'hvac'),
				),

				// --- Benefits ---
				array(
					'key'   => 'field_hvac_spt_benefits_tab',
					'label' => esc_html__('Benefits', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_spt_benefits_eyebrow',
					'label'         => esc_html__('Eyebrow', 'hvac'),
					'name'          => 'services_benefits_eyebrow',
					'type'          => 'text',
					'default_value' => 'Why Choose Us',
				),
				array(
					'key'           => 'field_hvac_spt_benefits_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_benefits_heading',
					'type'          => 'text',
					'default_value' => 'Comfort You Can Count On',
				),
				array(
					'key'          => 'field_hvac_spt_benefits',
					'label'        => esc_html__('Benefit Cards', 'hvac'),
					'name'         => 'services_benefits',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => esc_html__('Add Benefit', 'hvac'),
					'sub_fields'   => array(
						array(
							'key'           => 'field_hvac_spt_benefit_icon',
							'label'         => esc_html__('Icon', 'hvac'),
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'array',
							'preview_size'  => 'thumbnail',
							'instructions'  => esc_html__('Optional. Falls back to a built-in icon.', 'hvac'),
						),
						array(
							'key'   => 'field_hvac_spt_benefit_title',
							'label' => esc_html__('Title', 'hvac'),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_hvac_spt_benefit_text',
							'label' => esc_html__('Text', 'hvac'),
							'name'  => 'text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),

				// --- CTA banner ---
				array(
					'key'   => 'field_hvac_spt_cta_tab',
					'label' => esc_html__('CTA Banner', 'hvac'),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_spt_cta_heading',
					'label'         => esc_html__('Heading', 'hvac'),
					'name'          => 'services_cta_heading',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Ready to Enjoy Reliable, Worry-Free Cooling? Book Your AC Service Today.',
				),
				array(
					'key'           => 'field_hvac_spt_cta_button',
					'label'         => esc_html__('Button', 'hvac'),
					'name'          => 'services_cta_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_hvac_spt_cta_bg',
					'label'         => esc_html__('Background Image', 'hvac'),
					'name'          => 'services_cta_bg',
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
						'value'    => 'page-services.php',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_services_page_template_fields');
