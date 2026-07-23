<?php
/**
 * Coming Soon mode.
 *
 * Adds an ACF options page (Secure Custom Fields) so an admin can toggle a
 * "Coming Soon" page on/off and edit its content, then gates the front end
 * to show that page to visitors while it's enabled.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default content used until the admin saves their own.
 */
function hvac_coming_soon_defaults() {
	return array(
		'heading' => esc_html__( "We're Working On Something Great", 'hvac' ),
		'message' => '<p>' . esc_html__( 'Our website is currently undergoing scheduled maintenance. We will be back online shortly &mdash; thank you for your patience.', 'hvac' ) . '</p>',
	);
}

/**
 * Register the ACF options page.
 */
function hvac_coming_soon_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => esc_html__( 'Coming Soon', 'hvac' ),
			'menu_title' => esc_html__( 'Coming Soon', 'hvac' ),
			'menu_slug'  => 'hvac-coming-soon',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-clock',
			'position'   => 80,
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'hvac_coming_soon_options_page' );

/**
 * Register the fields for the Coming Soon options page.
 */
function hvac_coming_soon_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$hvac_cs_defaults = hvac_coming_soon_defaults();

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_coming_soon',
			'title'    => esc_html__( 'Coming Soon Page', 'hvac' ),
			'fields'   => array(
				array(
					'key'           => 'field_hvac_cs_enabled',
					'label'         => esc_html__( 'Enable Coming Soon Mode', 'hvac' ),
					'name'          => 'coming_soon_enabled',
					'type'          => 'true_false',
					'instructions'  => esc_html__( 'When enabled, visitors will see the Coming Soon page instead of the site. Logged-in administrators can still browse the site normally.', 'hvac' ),
					'default_value' => 0,
					'ui'            => 1,
				),
				array(
					'key'          => 'field_hvac_cs_heading',
					'label'        => esc_html__( 'Heading', 'hvac' ),
					'name'         => 'coming_soon_heading',
					'type'         => 'text',
					'default_value' => $hvac_cs_defaults['heading'],
				),
				array(
					'key'           => 'field_hvac_cs_message',
					'label'         => esc_html__( 'Message', 'hvac' ),
					'name'          => 'coming_soon_message',
					'type'          => 'wysiwyg',
					'default_value' => $hvac_cs_defaults['message'],
					'tabs'          => 'visual',
					'media_upload'  => 0,
					'toolbar'       => 'basic',
				),
				array(
					'key'           => 'field_hvac_cs_logo',
					'label'         => esc_html__( 'Logo (optional)', 'hvac' ),
					'name'          => 'coming_soon_logo',
					'type'          => 'image',
					'instructions'  => esc_html__( 'Defaults to the Site Identity logo if left empty.', 'hvac' ),
					'return_format' => 'url',
					'preview_size'  => 'medium',
				),
				array(
					'key'           => 'field_hvac_cs_background',
					'label'         => esc_html__( 'Background Image (optional)', 'hvac' ),
					'name'          => 'coming_soon_background',
					'type'          => 'image',
					'return_format' => 'url',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_hvac_cs_email',
					'label' => esc_html__( 'Contact Email (optional)', 'hvac' ),
					'name'  => 'coming_soon_email',
					'type'  => 'email',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-coming-soon',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'hvac_coming_soon_fields' );

/**
 * Show the Coming Soon template to visitors while it's enabled.
 */
function hvac_coming_soon_gate() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	global $pagenow;
	if ( 'wp-login.php' === $pagenow ) {
		return;
	}

	if ( ! function_exists( 'get_field' ) || ! get_field( 'coming_soon_enabled', 'option' ) ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		return;
	}

	$hvac_template = locate_template( 'coming-soon.php' );
	if ( ! $hvac_template ) {
		return;
	}

	status_header( 503 );
	nocache_headers();
	header( 'Retry-After: 3600' );

	require $hvac_template;
	exit;
}
add_action( 'template_redirect', 'hvac_coming_soon_gate' );
