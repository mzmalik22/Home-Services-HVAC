<?php

/**
 * SCF / ACF fields for the "Blog" page template (page-blog.php).
 *
 * Only appears on a Page using that template. Controls the hero, listing
 * options, and a CTA banner. The posts themselves come from the standard
 * WordPress posts.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_blog_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_blog_page',
			'title'    => esc_html__('Blog Page', 'hvac'),
			'fields'   => array(

				// --- Hero ---
				array('key' => 'field_hvac_bl_hero_tab', 'label' => esc_html__('Hero', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_bl_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'blog_eyebrow', 'type' => 'text', 'default_value' => 'Blog & News'),
				array('key' => 'field_hvac_bl_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'blog_heading', 'type' => 'text', 'default_value' => 'HVAC Tips, Guides & Updates'),
				array('key' => 'field_hvac_bl_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'blog_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Expert advice, maintenance tips, and the latest news to help you keep your home comfortable all year round.'),
				array('key' => 'field_hvac_bl_bg', 'label' => esc_html__('Background Image', 'hvac'), 'name' => 'blog_bg', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),

				// --- Listing options ---
				array('key' => 'field_hvac_bl_opts_tab', 'label' => esc_html__('Listing', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_bl_featured', 'label' => esc_html__('Show Featured Post', 'hvac'), 'name' => 'blog_show_featured', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1, 'instructions' => esc_html__('Highlight the most recent post at the top of page 1.', 'hvac')),
				array('key' => 'field_hvac_bl_perpage', 'label' => esc_html__('Posts Per Page', 'hvac'), 'name' => 'blog_per_page', 'type' => 'number', 'min' => 1, 'default_value' => 9),

				// --- CTA ---
				array('key' => 'field_hvac_bl_cta_tab', 'label' => esc_html__('CTA Banner', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_bl_cta_show', 'label' => esc_html__('Show CTA Banner', 'hvac'), 'name' => 'blog_cta_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
				array('key' => 'field_hvac_bl_cta_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'blog_cta_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Need Expert HVAC Help? Book a Service Today.'),
				array('key' => 'field_hvac_bl_cta_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'blog_cta_button', 'type' => 'link', 'return_format' => 'array'),
			),
			'location' => array(
				array(
					array('param' => 'page_template', 'operator' => '==', 'value' => 'page-blog.php'),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_blog_page_fields');
