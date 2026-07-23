<?php
/**
 * Theme Options.
 *
 * Registers a "Theme Options" parent page (ACF/Secure Custom Fields options
 * page) that acts as a container for theme modules, each living on its own
 * subpage. "Scripts" is the first module; add further modules by registering
 * another acf_add_options_sub_page() + field group pair below, following the
 * same pattern.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Theme Options parent page.
 */
function hvac_theme_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => esc_html__( 'Theme Options', 'hvac' ),
			'menu_title' => esc_html__( 'Theme Options', 'hvac' ),
			'menu_slug'  => 'hvac-theme-options',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-generic',
			'position'   => 81,
			'redirect'   => true,
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_page' );

/**
 * Register the "Header" subpage under Theme Options.
 */
function hvac_theme_options_header_page() {
	if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'Header', 'hvac' ),
			'menu_title'  => esc_html__( 'Header', 'hvac' ),
			'menu_slug'   => 'hvac-theme-options-header',
			'parent_slug' => 'hvac-theme-options',
			'capability'  => 'manage_options',
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_header_page' );

/**
 * Fields for the "Header" subpage.
 *
 * The primary navigation itself is a standard WordPress menu (Appearance >
 * Menus, "Primary Menu" location). These fields control the surrounding
 * header content: the top utility bar and the "Call" button.
 */
function hvac_theme_options_header_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_theme_options_header',
			'title'    => esc_html__( 'Header', 'hvac' ),
			'fields'   => array(

				// --- Top utility bar ---
				array(
					'key'          => 'field_hvac_header_topbar_tab',
					'label'        => esc_html__( 'Top Bar', 'hvac' ),
					'type'         => 'tab',
				),
				array(
					'key'           => 'field_hvac_header_show_topbar',
					'label'         => esc_html__( 'Show Top Bar', 'hvac' ),
					'name'          => 'header_show_topbar',
					'type'          => 'true_false',
					'instructions'  => esc_html__( 'Toggle the thin announcement bar above the main header.', 'hvac' ),
					'ui'            => 1,
					'default_value' => 1,
				),
				array(
					'key'           => 'field_hvac_header_topbar_message',
					'label'         => esc_html__( 'Announcement Text', 'hvac' ),
					'name'          => 'header_topbar_message',
					'type'          => 'text',
					'instructions'  => esc_html__( 'Short message shown on the left of the top bar.', 'hvac' ),
					'default_value' => esc_html__( 'HVAC Services Available Across the USA', 'hvac' ),
				),
				array(
					'key'           => 'field_hvac_header_topbar_rating',
					'label'         => esc_html__( 'Rating Text', 'hvac' ),
					'name'          => 'header_topbar_rating',
					'type'          => 'text',
					'instructions'  => esc_html__( 'Shown on the right, preceded by star icons. e.g. "4.9 Google Rating".', 'hvac' ),
					'default_value' => esc_html__( '4.9 Google Rating', 'hvac' ),
				),
				array(
					'key'           => 'field_hvac_header_topbar_highlight',
					'label'         => esc_html__( 'Highlight Text', 'hvac' ),
					'name'          => 'header_topbar_highlight',
					'type'          => 'text',
					'instructions'  => esc_html__( 'Accent note on the far right, e.g. "24/7 Emergency".', 'hvac' ),
					'default_value' => esc_html__( '24/7 Emergency', 'hvac' ),
				),

				// --- Call to action ---
				array(
					'key'          => 'field_hvac_header_cta_tab',
					'label'        => esc_html__( 'Call Button', 'hvac' ),
					'type'         => 'tab',
				),
				array(
					'key'           => 'field_hvac_header_phone',
					'label'         => esc_html__( 'Phone Number', 'hvac' ),
					'name'          => 'header_phone',
					'type'          => 'text',
					'instructions'  => esc_html__( 'Displayed on the header button and used for the click-to-call link. Leave empty to hide the button.', 'hvac' ),
					'default_value' => esc_html__( '(512) 555-0199', 'hvac' ),
				),
				array(
					'key'           => 'field_hvac_header_cta_label',
					'label'         => esc_html__( 'Button Label', 'hvac' ),
					'name'          => 'header_cta_label',
					'type'          => 'text',
					'instructions'  => esc_html__( 'Text shown before the phone number, e.g. "Call".', 'hvac' ),
					'default_value' => esc_html__( 'Call', 'hvac' ),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-theme-options-header',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_header_fields' );

/**
 * Register the "Footer" subpage under Theme Options.
 */
function hvac_theme_options_footer_page() {
	if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'Footer', 'hvac' ),
			'menu_title'  => esc_html__( 'Footer', 'hvac' ),
			'menu_slug'   => 'hvac-theme-options-footer',
			'parent_slug' => 'hvac-theme-options',
			'capability'  => 'manage_options',
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_footer_page' );

/**
 * Fields for the "Footer" subpage.
 */
function hvac_theme_options_footer_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_theme_options_footer',
			'title'    => esc_html__( 'Footer', 'hvac' ),
			'fields'   => array(

				// --- Brand / about ---
				array(
					'key'   => 'field_hvac_footer_brand_tab',
					'label' => esc_html__( 'Brand', 'hvac' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_hvac_footer_logo',
					'label'         => esc_html__( 'Footer Logo', 'hvac' ),
					'name'          => 'footer_logo',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'instructions'  => esc_html__( 'Optional. Falls back to the site logo / name if left empty.', 'hvac' ),
				),
				array(
					'key'          => 'field_hvac_footer_tagline',
					'label'        => esc_html__( 'Tagline', 'hvac' ),
					'name'         => 'footer_tagline',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => esc_html__( 'Short description shown under the logo.', 'hvac' ),
				),
				array(
					'key'   => 'field_hvac_footer_phone',
					'label' => esc_html__( 'Phone', 'hvac' ),
					'name'  => 'footer_phone',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_hvac_footer_email',
					'label' => esc_html__( 'Email', 'hvac' ),
					'name'  => 'footer_email',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_hvac_footer_location',
					'label' => esc_html__( 'Location', 'hvac' ),
					'name'  => 'footer_location',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_hvac_footer_socials',
					'label'        => esc_html__( 'Social Links', 'hvac' ),
					'name'         => 'footer_socials',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__( 'Add Social Link', 'hvac' ),
					'sub_fields'   => array(
						array(
							'key'     => 'field_hvac_footer_social_network',
							'label'   => esc_html__( 'Network', 'hvac' ),
							'name'    => 'network',
							'type'    => 'select',
							'choices' => array(
								'facebook'  => 'Facebook',
								'instagram' => 'Instagram',
								'x'         => 'X (Twitter)',
								'linkedin'  => 'LinkedIn',
								'youtube'   => 'YouTube',
							),
						),
						array(
							'key'           => 'field_hvac_footer_social_url',
							'label'         => esc_html__( 'Link', 'hvac' ),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),

				// --- Link columns ---
				array(
					'key'   => 'field_hvac_footer_columns_tab',
					'label' => esc_html__( 'Link Columns', 'hvac' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_hvac_footer_columns',
					'label'        => esc_html__( 'Columns', 'hvac' ),
					'name'         => 'footer_columns',
					'type'         => 'repeater',
					'layout'       => 'block',
					'max'          => 4,
					'button_label' => esc_html__( 'Add Column', 'hvac' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_hvac_footer_col_title',
							'label' => esc_html__( 'Column Title', 'hvac' ),
							'name'  => 'col_title',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_hvac_footer_col_links',
							'label'        => esc_html__( 'Links', 'hvac' ),
							'name'         => 'col_links',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => esc_html__( 'Add Link', 'hvac' ),
							'sub_fields'   => array(
								array(
									'key'           => 'field_hvac_footer_col_link',
									'label'         => esc_html__( 'Link', 'hvac' ),
									'name'          => 'link',
									'type'          => 'link',
									'return_format' => 'array',
									'instructions'  => esc_html__( 'Set the link text, URL, and whether it opens in a new tab.', 'hvac' ),
								),
							),
						),
					),
				),

				// --- Bottom bar ---
				array(
					'key'   => 'field_hvac_footer_bottom_tab',
					'label' => esc_html__( 'Bottom Bar', 'hvac' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_hvac_footer_copyright',
					'label'        => esc_html__( 'Copyright Text', 'hvac' ),
					'name'         => 'footer_copyright',
					'type'         => 'text',
					'instructions' => esc_html__( 'Use {year} for the current year. e.g. "© {year} Sample HVAC Co. | Licensed & Insured".', 'hvac' ),
				),
				array(
					'key'          => 'field_hvac_footer_bottom_links',
					'label'        => esc_html__( 'Bottom Links', 'hvac' ),
					'name'         => 'footer_bottom_links',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => esc_html__( 'Add Link', 'hvac' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_hvac_footer_bottom_link',
							'label'         => esc_html__( 'Link', 'hvac' ),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-theme-options-footer',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_footer_fields' );

/**
 * Register the "Scripts" subpage under Theme Options.
 */
function hvac_theme_options_scripts_page() {
	if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'Scripts', 'hvac' ),
			'menu_title'  => esc_html__( 'Scripts', 'hvac' ),
			'menu_slug'   => 'hvac-theme-options-scripts',
			'parent_slug' => 'hvac-theme-options',
			'capability'  => 'manage_options',
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_scripts_page' );

/**
 * Fields for the "Scripts" subpage.
 */
function hvac_theme_options_scripts_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_hvac_theme_options_scripts',
			'title'    => esc_html__( 'Scripts', 'hvac' ),
			'fields'   => array(
				array(
					'key'          => 'field_hvac_header_scripts',
					'label'        => esc_html__( 'Header Scripts', 'hvac' ),
					'name'         => 'header_scripts',
					'type'         => 'textarea',
					'instructions' => esc_html__( 'Pasted verbatim just before the closing </head> tag on every page. Use for analytics, site verification tags, etc.', 'hvac' ),
					'rows'         => 10,
				),
				array(
					'key'          => 'field_hvac_footer_scripts',
					'label'        => esc_html__( 'Footer Scripts', 'hvac' ),
					'name'         => 'footer_scripts',
					'type'         => 'textarea',
					'instructions' => esc_html__( 'Pasted verbatim just before the closing </body> tag on every page. Use for chat widgets, tracking pixels, etc.', 'hvac' ),
					'rows'         => 10,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hvac-theme-options-scripts',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'hvac_theme_options_scripts_fields' );

/**
 * Output the header scripts just before </head>.
 */
function hvac_output_header_scripts() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$hvac_header_scripts = get_field( 'header_scripts', 'option' );
	if ( $hvac_header_scripts ) {
		echo $hvac_header_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- admin-only raw script field.
	}
}
add_action( 'wp_head', 'hvac_output_header_scripts', 100 );

/**
 * Output the footer scripts just before </body>.
 */
function hvac_output_footer_scripts() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$hvac_footer_scripts = get_field( 'footer_scripts', 'option' );
	if ( $hvac_footer_scripts ) {
		echo $hvac_footer_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- admin-only raw script field.
	}
}
add_action( 'wp_footer', 'hvac_output_footer_scripts', 100 );
