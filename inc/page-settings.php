<?php

/**
 * Per-page settings.
 *
 * Adds a "Header Settings" box (Secure Custom Fields) to every Page, letting
 * the admin choose a transparent header per page. Transparent headers overlay
 * the page content and turn solid + sticky on scroll (handled in CSS/JS). The
 * top utility bar is never affected by this setting.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Register the per-page "Header Settings" field group.
 */
function hvac_page_header_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_page_header',
			'title'    => esc_html__('Header Settings', 'hvac'),
			'fields'   => array(
				array(
					'key'           => 'field_hvac_page_header_transparent',
					'label'         => esc_html__('Transparent Header', 'hvac'),
					'name'          => 'header_transparent',
					'type'          => 'true_false',
					'ui'            => 1,
					'instructions'  => esc_html__('Overlay the main header on top of the page content (ideal for pages that open with a dark hero). The header stays transparent at the top of the page and turns solid, sticking to the top, once the visitor scrolls. This does not affect the top utility bar.', 'hvac'),
					'default_value' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
			'menu_order' => -10,
			'position'   => 'side',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_page_header_fields');

/**
 * Whether the current page requests a transparent header.
 *
 * @return bool
 */
if (! function_exists('hvac_is_transparent_header')) {
	function hvac_is_transparent_header()
	{
		if (! function_exists('get_field')) {
			return false;
		}
		$id = get_queried_object_id();
		if (! $id) {
			return false;
		}
		return (bool) get_field('header_transparent', $id);
	}
}

/**
 * Add a body class when the current page uses a transparent header.
 *
 * @param array $classes Body classes.
 * @return array
 */
function hvac_transparent_header_body_class($classes)
{
	if (hvac_is_transparent_header()) {
		$classes[] = 'has-transparent-header';
	}
	return $classes;
}
add_filter('body_class', 'hvac_transparent_header_body_class');
