<?php

/**
 * SCF / ACF fields for the "FAQ" page template (page-faq.php).
 *
 * Only appears on a Page using that template. FAQs are organised into optional
 * groups (categories); each group has a title and a set of question/answer
 * rows. Defaults render when empty.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

function hvac_faq_page_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_faq_page',
			'title'    => esc_html__('FAQ Page', 'hvac'),
			'fields'   => array(

				// --- Hero ---
				array('key' => 'field_hvac_fq_hero_tab', 'label' => esc_html__('Hero', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_fq_eyebrow', 'label' => esc_html__('Eyebrow', 'hvac'), 'name' => 'faq_eyebrow', 'type' => 'text', 'default_value' => 'FAQ'),
				array('key' => 'field_hvac_fq_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'faq_heading', 'type' => 'text', 'default_value' => 'Frequently Asked Questions'),
				array('key' => 'field_hvac_fq_subtext', 'label' => esc_html__('Subtext', 'hvac'), 'name' => 'faq_subtext', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Answers to the questions we hear most about our heating and cooling services. Can\'t find what you\'re looking for? Get in touch.'),
				array('key' => 'field_hvac_fq_bg', 'label' => esc_html__('Background Image', 'hvac'), 'name' => 'faq_bg', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'),

				// --- FAQs ---
				array('key' => 'field_hvac_fq_groups_tab', 'label' => esc_html__('FAQs', 'hvac'), 'type' => 'tab'),
				array(
					'key' => 'field_hvac_fq_groups', 'label' => esc_html__('FAQ Groups', 'hvac'), 'name' => 'faq_groups',
					'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Group', 'hvac'),
					'instructions' => esc_html__('Each group is a category. Leave the group title empty for an ungrouped list.', 'hvac'),
					'sub_fields' => array(
						array('key' => 'field_hvac_fq_group_title', 'label' => esc_html__('Group Title', 'hvac'), 'name' => 'group_title', 'type' => 'text'),
						array(
							'key' => 'field_hvac_fq_items', 'label' => esc_html__('Questions', 'hvac'), 'name' => 'items',
							'type' => 'repeater', 'layout' => 'block', 'button_label' => esc_html__('Add Question', 'hvac'),
							'sub_fields' => array(
								array('key' => 'field_hvac_fq_q', 'label' => esc_html__('Question', 'hvac'), 'name' => 'question', 'type' => 'text'),
								array('key' => 'field_hvac_fq_a', 'label' => esc_html__('Answer', 'hvac'), 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
							),
						),
					),
				),

				// --- CTA ---
				array('key' => 'field_hvac_fq_cta_tab', 'label' => esc_html__('CTA Banner', 'hvac'), 'type' => 'tab'),
				array('key' => 'field_hvac_fq_cta_show', 'label' => esc_html__('Show CTA Banner', 'hvac'), 'name' => 'faq_cta_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
				array('key' => 'field_hvac_fq_cta_heading', 'label' => esc_html__('Heading', 'hvac'), 'name' => 'faq_cta_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Still Have Questions? Our Team Is Here to Help.'),
				array('key' => 'field_hvac_fq_cta_button', 'label' => esc_html__('Button', 'hvac'), 'name' => 'faq_cta_button', 'type' => 'link', 'return_format' => 'array'),
			),
			'location' => array(
				array(
					array('param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php'),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
		)
	);
}
add_action('acf/init', 'hvac_faq_page_fields');
