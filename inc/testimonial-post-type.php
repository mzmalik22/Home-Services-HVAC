<?php

/**
 * "Testimonial" custom post type- the single source of truth for customer
 * reviews shown across the theme (Home, About Us, Location pages, Service
 * detail pages, and the Flexible Content "Testimonials" section).
 *
 * Each of those sections has a "Testimonials to Show" relationship field so
 * an editor can feature specific testimonials on a given page; leaving it
 * empty shows every published testimonial instead.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Register the "Testimonial" custom post type.
 */
function hvac_register_testimonial_cpt()
{
	$labels = array(
		'name'               => esc_html__('Testimonials', 'hvac'),
		'singular_name'      => esc_html__('Testimonial', 'hvac'),
		'add_new'            => esc_html__('Add New', 'hvac'),
		'add_new_item'       => esc_html__('Add New Testimonial', 'hvac'),
		'edit_item'          => esc_html__('Edit Testimonial', 'hvac'),
		'new_item'           => esc_html__('New Testimonial', 'hvac'),
		'view_item'          => esc_html__('View Testimonial', 'hvac'),
		'search_items'       => esc_html__('Search Testimonials', 'hvac'),
		'not_found'          => esc_html__('No testimonials found', 'hvac'),
		'not_found_in_trash' => esc_html__('No testimonials found in Trash', 'hvac'),
		'all_items'          => esc_html__('All Testimonials', 'hvac'),
		'menu_name'          => esc_html__('Testimonials', 'hvac'),
	);

	register_post_type(
		'testimonial',
		array(
			'labels'        => $labels,
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 27,
			'has_archive'   => false,
			'rewrite'       => false,
			'supports'      => array('title', 'page-attributes'),
		)
	);
}
add_action('init', 'hvac_register_testimonial_cpt');

/**
 * Fields for a single testimonial: reviewer role, star rating, an optional
 * wide card image, an optional round headshot, and the quote itself.
 *
 * The post title is the reviewer's name.
 */
function hvac_testimonial_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_testimonial',
			'title'    => esc_html__('Testimonial Details', 'hvac'),
			'fields'   => array(
				array(
					'key'          => 'field_hvac_testi_role',
					'label'        => esc_html__('Role', 'hvac'),
					'name'         => 'testimonial_role',
					'type'         => 'text',
					'instructions' => esc_html__('e.g. "Homeowner", "Business Owner", or a location such as "California".', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_testi_rating',
					'label'         => esc_html__('Rating (1-5)', 'hvac'),
					'name'          => 'testimonial_rating',
					'type'          => 'number',
					'min'           => 1,
					'max'           => 5,
					'default_value' => 5,
				),
				array(
					'key'   => 'field_hvac_testi_quote',
					'label' => esc_html__('Quote', 'hvac'),
					'name'  => 'testimonial_quote',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'           => 'field_hvac_testi_headshot',
					'label'         => esc_html__('Headshot', 'hvac'),
					'name'          => 'testimonial_headshot',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'thumbnail',
					'instructions'  => esc_html__('Small round avatar shown beside the name.', 'hvac'),
				),
				array(
					'key'           => 'field_hvac_testi_card_image',
					'label'         => esc_html__('Card Image', 'hvac'),
					'name'          => 'testimonial_card_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'instructions'  => esc_html__('Optional. Wide image shown at the top of the testimonial card.', 'hvac'),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'testimonial',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_testimonial_fields');
