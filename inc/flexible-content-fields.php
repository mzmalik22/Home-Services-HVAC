<?php

/**
 * "Page Builder" flexible content field- one layout per reusable section
 * design already used across this theme (hero, content+image, services grid,
 * feature grids, process steps, checklist, testimonials, news, project
 * gallery, stats, FAQ, CTA banner, related services, related posts, rich
 * text, and a plain image block).
 *
 * Available on:
 *  - any Page using the "Flexible Content" template (page-flexible-content.php)
 *  - every standard blog Post automatically (see the template_include filter
 *    in functions.php- no manual template selection needed for posts)
 *
 * Every layout renders with the same markup/CSS classes already used
 * elsewhere in the theme, so no new styling is required.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Small shared field snippets (kept local to avoid coupling to other files).
 */
if (! function_exists('hvac_fc_icon_field')) {
	function hvac_fc_icon_field($key, $name = 'icon')
	{
		return array(
			'key'           => $key,
			'label'         => esc_html__('Icon', 'hvac'),
			'name'          => $name,
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'thumbnail',
			'instructions'  => esc_html__('Optional. Falls back to a built-in icon.', 'hvac'),
		);
	}
}

function hvac_flexible_content_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_hvac_flexible_content',
			'title'  => esc_html__('Page Builder', 'hvac'),
			'fields' => array(
				array(
					'key'          => 'field_hvac_fc_sections',
					'label'        => esc_html__('Sections', 'hvac'),
					'name'         => 'page_sections',
					'type'         => 'flexible_content',
					'button_label' => esc_html__('Add Section', 'hvac'),
					'layouts'      => array(

						/* ============================== HERO ============================== */
						'layout_hero' => array(
							'key'        => 'layout_hvac_fc_hero',
							'name'       => 'hero',
							'label'      => esc_html__('Hero', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_hero_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text'),
								array('key' => 'field_hvac_fc_hero_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'required' => 1),
								array('key' => 'field_hvac_fc_hero_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 3),
								array('key' => 'field_hvac_fc_hero_phone', 'label' => esc_html__('Phone', 'hvac'), 'name' => 'phone', 'type' => 'text', 'instructions' => esc_html__('Optional click-to-call shown next to the button.', 'hvac')),
								array('key' => 'field_hvac_fc_hero_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'button', 'type' => 'link', 'return_format' => 'array'),
								array('key' => 'field_hvac_fc_hero_bg', 'label' => esc_html__('Background Image', 'hvac'), 'name' => 'background_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
							),
						),

						/* ========================= CONTENT + IMAGE ========================= */
						'layout_content_image' => array(
							'key'        => 'layout_hvac_fc_content_image',
							'name'       => 'content_image',
							'label'      => esc_html__('Content + Image', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_ci_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text'),
								array('key' => 'field_hvac_fc_ci_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_ci_content', 'label' => esc_html__('Content', 'hvac'), 'name' => 'content', 'type' => 'wysiwyg', 'toolbar' => 'full', 'media_upload' => 1),
								array('key' => 'field_hvac_fc_ci_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
								array(
									'key'           => 'field_hvac_fc_ci_position',
									'label'         => esc_html__('Image Position', 'hvac'),
									'name'          => 'image_position',
									'type'          => 'select',
									'choices'       => array('right' => esc_html__('Right', 'hvac'), 'left' => esc_html__('Left', 'hvac')),
									'default_value' => 'right',
								),
								array('key' => 'field_hvac_fc_ci_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'button', 'type' => 'link', 'return_format' => 'array'),
							),
						),

						/* ============================ SERVICES GRID ============================ */
						'layout_services_grid' => array(
							'key'        => 'layout_hvac_fc_services_grid',
							'name'       => 'services_grid',
							'label'      => esc_html__('Services Grid', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_sg_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Our Services'),
								array('key' => 'field_hvac_fc_sg_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'default_value' => 'Our HVAC Services'),
								array('key' => 'field_hvac_fc_sg_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'           => 'field_hvac_fc_sg_selected',
									'label'         => esc_html__('Services to Show', 'hvac'),
									'name'          => 'services',
									'type'          => 'relationship',
									'post_type'     => array('service'),
									'filters'       => array('search'),
									'return_format' => 'id',
									'instructions'  => esc_html__('Optional. Leave empty to show the latest services automatically.', 'hvac'),
								),
								array('key' => 'field_hvac_fc_sg_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'count', 'type' => 'number', 'default_value' => 6, 'min' => 1, 'instructions' => esc_html__('Used when no services are selected above.', 'hvac')),
							),
						),

						/* ========================== FEATURE GRID ========================== */
						'layout_feature_grid' => array(
							'key'        => 'layout_hvac_fc_feature_grid',
							'name'       => 'feature_grid',
							'label'      => esc_html__('Feature Grid (Why Choose Us style)', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_fg_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text'),
								array('key' => 'field_hvac_fc_fg_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_fg_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'          => 'field_hvac_fc_fg_items',
									'label'        => esc_html__('Items', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add Item', 'hvac'),
									'sub_fields'   => array(
										hvac_fc_icon_field('field_hvac_fc_fg_item_icon'),
										array('key' => 'field_hvac_fc_fg_item_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
										array('key' => 'field_hvac_fc_fg_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
									),
								),
							),
						),

						/* ========================== BENEFITS GRID ========================== */
						'layout_benefits_grid' => array(
							'key'        => 'layout_hvac_fc_benefits_grid',
							'name'       => 'benefits_grid',
							'label'      => esc_html__('Benefits Grid', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_bg_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text'),
								array('key' => 'field_hvac_fc_bg_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_bg_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'          => 'field_hvac_fc_bg_items',
									'label'        => esc_html__('Items', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add Item', 'hvac'),
									'sub_fields'   => array(
										hvac_fc_icon_field('field_hvac_fc_bg_item_icon'),
										array('key' => 'field_hvac_fc_bg_item_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
										array('key' => 'field_hvac_fc_bg_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
										array('key' => 'field_hvac_fc_bg_item_link', 'label' => esc_html__('Link', 'hvac'), 'name' => 'link', 'type' => 'link', 'return_format' => 'array', 'instructions' => esc_html__('Optional.', 'hvac')),
									),
								),
							),
						),

						/* ============================ PROCESS STEPS ============================ */
						'layout_process' => array(
							'key'        => 'layout_hvac_fc_process',
							'name'       => 'process_steps',
							'label'      => esc_html__('Process Steps', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_pr_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'How It Works'),
								array('key' => 'field_hvac_fc_pr_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_pr_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array('key' => 'field_hvac_fc_pr_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
								array(
									'key'          => 'field_hvac_fc_pr_steps',
									'label'        => esc_html__('Steps', 'hvac'),
									'name'         => 'steps',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add Step', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_pr_step_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
										array('key' => 'field_hvac_fc_pr_step_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 3),
									),
								),
							),
						),

						/* =============================== CHECKLIST =============================== */
						'layout_checklist' => array(
							'key'        => 'layout_hvac_fc_checklist',
							'name'       => 'checklist',
							'label'      => esc_html__('Checklist', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_cl_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_cl_dark', 'label' => esc_html__('Dark Background', 'hvac'), 'name' => 'dark_bg', 'type' => 'true_false', 'ui' => 1),
								array(
									'key'          => 'field_hvac_fc_cl_items',
									'label'        => esc_html__('Items', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => esc_html__('Add Item', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_cl_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'text'),
									),
								),
							),
						),

						/* ============================== TESTIMONIALS ============================== */
						'layout_testimonials' => array(
							'key'        => 'layout_hvac_fc_testimonials',
							'name'       => 'testimonials',
							'label'      => esc_html__('Testimonials', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_ts_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Reviews'),
								array('key' => 'field_hvac_fc_ts_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'default_value' => 'What Our Customers Say'),
								array('key' => 'field_hvac_fc_ts_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'          => 'field_hvac_fc_ts_items',
									'label'        => esc_html__('Testimonials', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add Testimonial', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_ts_item_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
										array('key' => 'field_hvac_fc_ts_item_headshot', 'label' => esc_html__('Headshot', 'hvac'), 'name' => 'headshot', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail'),
										array('key' => 'field_hvac_fc_ts_item_quote', 'label' => esc_html__('Quote', 'hvac'), 'name' => 'quote', 'type' => 'textarea', 'rows' => 4),
										array('key' => 'field_hvac_fc_ts_item_name', 'label' => esc_html__('Name', 'hvac'), 'name' => 'name', 'type' => 'text'),
										array('key' => 'field_hvac_fc_ts_item_role', 'label' => esc_html__('Role', 'hvac'), 'name' => 'role', 'type' => 'text'),
										array('key' => 'field_hvac_fc_ts_item_rating', 'label' => esc_html__('Rating (1-5)', 'hvac'), 'name' => 'rating', 'type' => 'number', 'min' => 1, 'max' => 5, 'default_value' => 5),
									),
								),
							),
						),

						/* ================================ NEWS GRID ================================ */
						'layout_news' => array(
							'key'        => 'layout_hvac_fc_news',
							'name'       => 'news_grid',
							'label'      => esc_html__('Blog / News Grid', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_nw_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Blog & News'),
								array('key' => 'field_hvac_fc_nw_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_nw_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'           => 'field_hvac_fc_nw_source',
									'label'         => esc_html__('Source', 'hvac'),
									'name'          => 'source',
									'type'          => 'select',
									'choices'       => array('latest' => esc_html__('Latest posts (automatic)', 'hvac'), 'manual' => esc_html__('Manual cards', 'hvac')),
									'default_value' => 'latest',
								),
								array(
									'key'               => 'field_hvac_fc_nw_cards',
									'label'             => esc_html__('Manual Cards', 'hvac'),
									'name'              => 'manual_cards',
									'type'              => 'repeater',
									'layout'            => 'block',
									'button_label'      => esc_html__('Add Card', 'hvac'),
									'conditional_logic' => array(array(array('field' => 'field_hvac_fc_nw_source', 'operator' => '==', 'value' => 'manual'))),
									'sub_fields'        => array(
										array('key' => 'field_hvac_fc_nw_card_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
										array('key' => 'field_hvac_fc_nw_card_category', 'label' => esc_html__('Category', 'hvac'), 'name' => 'category', 'type' => 'text'),
										array('key' => 'field_hvac_fc_nw_card_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
										array('key' => 'field_hvac_fc_nw_card_date', 'label' => esc_html__('Date', 'hvac'), 'name' => 'date', 'type' => 'text'),
										array('key' => 'field_hvac_fc_nw_card_excerpt', 'label' => esc_html__('Excerpt', 'hvac'), 'name' => 'excerpt', 'type' => 'textarea', 'rows' => 2),
										array('key' => 'field_hvac_fc_nw_card_link', 'label' => esc_html__('Link', 'hvac'), 'name' => 'link', 'type' => 'link', 'return_format' => 'array'),
									),
								),
							),
						),

						/* ============================= PROJECTS GALLERY ============================= */
						'layout_projects' => array(
							'key'        => 'layout_hvac_fc_projects',
							'name'       => 'projects_gallery',
							'label'      => esc_html__('Projects Gallery', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_pj_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Our Work'),
								array('key' => 'field_hvac_fc_pj_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_pj_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'          => 'field_hvac_fc_pj_items',
									'label'        => esc_html__('Projects', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add Project', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_pj_item_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
										array('key' => 'field_hvac_fc_pj_item_title', 'label' => esc_html__('Title', 'hvac'), 'name' => 'title', 'type' => 'text'),
										array('key' => 'field_hvac_fc_pj_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
									),
								),
							),
						),

						/* =================================== STATS =================================== */
						'layout_stats' => array(
							'key'        => 'layout_hvac_fc_stats',
							'name'       => 'stats',
							'label'      => esc_html__('Stats', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_st_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array(
									'key'          => 'field_hvac_fc_st_items',
									'label'        => esc_html__('Stats', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => esc_html__('Add Stat', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_st_item_value', 'label' => esc_html__('Value', 'hvac'), 'name' => 'value', 'type' => 'text'),
										array('key' => 'field_hvac_fc_st_item_label', 'label' => esc_html__('Label', 'hvac'), 'name' => 'label', 'type' => 'text'),
									),
								),
							),
						),

						/* ================================= TABLE ================================= */
						'layout_table' => array(
							'key'        => 'layout_hvac_fc_table',
							'name'       => 'comparison_table',
							'label'      => esc_html__('Table', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_tb_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text'),
								array('key' => 'field_hvac_fc_tb_col1', 'label' => esc_html__('Column 1 Label', 'hvac'), 'name' => 'col1_label', 'type' => 'text', 'default_value' => 'Item'),
								array('key' => 'field_hvac_fc_tb_col2', 'label' => esc_html__('Column 2 Label', 'hvac'), 'name' => 'col2_label', 'type' => 'text', 'default_value' => 'Details'),
								array('key' => 'field_hvac_fc_tb_col3', 'label' => esc_html__('Column 3 Label', 'hvac'), 'name' => 'col3_label', 'type' => 'text', 'instructions' => esc_html__('Optional. Leave empty for a 2-column table.', 'hvac')),
								array(
									'key'          => 'field_hvac_fc_tb_rows',
									'label'        => esc_html__('Rows', 'hvac'),
									'name'         => 'rows',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => esc_html__('Add Row', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_tb_row_col1', 'label' => esc_html__('Column 1', 'hvac'), 'name' => 'col1', 'type' => 'text'),
										array('key' => 'field_hvac_fc_tb_row_col2', 'label' => esc_html__('Column 2', 'hvac'), 'name' => 'col2', 'type' => 'text'),
										array('key' => 'field_hvac_fc_tb_row_col3', 'label' => esc_html__('Column 3', 'hvac'), 'name' => 'col3', 'type' => 'text'),
									),
								),
								array('key' => 'field_hvac_fc_tb_note', 'label' => esc_html__('Note', 'hvac'), 'name' => 'note', 'type' => 'textarea', 'rows' => 2, 'instructions' => esc_html__('Optional short line shown below the table.', 'hvac')),
							),
						),

						/* ==================================== FAQ ==================================== */
						'layout_faq' => array(
							'key'        => 'layout_hvac_fc_faq',
							'name'       => 'faq',
							'label'      => esc_html__('FAQ', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_fq_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'FAQ'),
								array('key' => 'field_hvac_fc_fq_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'default_value' => 'Frequently Asked Questions'),
								array(
									'key'          => 'field_hvac_fc_fq_items',
									'label'        => esc_html__('Questions', 'hvac'),
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => esc_html__('Add FAQ', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_fq_item_q', 'label' => esc_html__('Question', 'hvac'), 'name' => 'question', 'type' => 'text'),
										array('key' => 'field_hvac_fc_fq_item_a', 'label' => esc_html__('Answer', 'hvac'), 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
									),
								),
							),
						),

						/* ================================ CTA BANNER ================================ */
						'layout_cta' => array(
							'key'        => 'layout_hvac_fc_cta',
							'name'       => 'cta_banner',
							'label'      => esc_html__('CTA Banner', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_cta_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'textarea', 'rows' => 2, 'required' => 1),
								array('key' => 'field_hvac_fc_cta_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'subtext', 'type' => 'textarea', 'rows' => 2),
								array(
									'key'          => 'field_hvac_fc_cta_checklist',
									'label'        => esc_html__('Checklist', 'hvac'),
									'name'         => 'checklist',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => esc_html__('Add Checklist Item', 'hvac'),
									'sub_fields'   => array(
										array('key' => 'field_hvac_fc_cta_item_text', 'label' => esc_html__('Text', 'hvac'), 'name' => 'text', 'type' => 'text'),
									),
								),
								array('key' => 'field_hvac_fc_cta_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'button', 'type' => 'link', 'return_format' => 'array'),
								array('key' => 'field_hvac_fc_cta_bg', 'label' => esc_html__('Background Image', 'hvac'), 'name' => 'background_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),
							),
						),

						/* ============================= RELATED SERVICES ============================= */
						'layout_related_services' => array(
							'key'        => 'layout_hvac_fc_related_services',
							'name'       => 'related_services',
							'label'      => esc_html__('Related Services', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_rs_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'default_value' => 'Related Services'),
								array('key' => 'field_hvac_fc_rs_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'count', 'type' => 'number', 'default_value' => 3, 'min' => 1),
							),
						),

						/* =============================== RELATED POSTS =============================== */
						'layout_related_posts' => array(
							'key'        => 'layout_hvac_fc_related_posts',
							'name'       => 'related_posts',
							'label'      => esc_html__('Related Posts', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_rp_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'heading', 'type' => 'text', 'default_value' => 'Related Articles'),
								array('key' => 'field_hvac_fc_rp_count', 'label' => esc_html__('Number to Show', 'hvac'), 'name' => 'count', 'type' => 'number', 'default_value' => 3, 'min' => 1),
								array('key' => 'field_hvac_fc_rp_same_cat', 'label' => esc_html__('Same Category Only', 'hvac'), 'name' => 'same_category', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => esc_html__('Only relevant when this section is used on a blog post.', 'hvac')),
							),
						),

						/* ================================= RICH TEXT ================================= */
						'layout_rich_text' => array(
							'key'        => 'layout_hvac_fc_rich_text',
							'name'       => 'rich_text',
							'label'      => esc_html__('Rich Text', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_rt_content', 'label' => esc_html__('Content', 'hvac'), 'name' => 'content', 'type' => 'wysiwyg', 'toolbar' => 'full', 'media_upload' => 1),
							),
						),

						/* =================================== IMAGE =================================== */
						'layout_image' => array(
							'key'        => 'layout_hvac_fc_image',
							'name'       => 'image_block',
							'label'      => esc_html__('Image', 'hvac'),
							'display'    => 'block',
							'sub_fields' => array(
								array('key' => 'field_hvac_fc_img_image', 'label' => esc_html__('Image', 'hvac'), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'required' => 1),
								array('key' => 'field_hvac_fc_img_caption', 'label' => esc_html__('Caption', 'hvac'), 'name' => 'caption', 'type' => 'text'),
								array('key' => 'field_hvac_fc_img_full', 'label' => esc_html__('Full Width', 'hvac'), 'name' => 'full_width', 'type' => 'true_false', 'ui' => 1),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-flexible-content.php',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_flexible_content_fields');
