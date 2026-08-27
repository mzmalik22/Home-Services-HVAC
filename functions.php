<?php
/**
 * HVAC theme functions and definitions.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Disallow direct access.
}

define( 'HVAC_VERSION', '1.28.0' );

/**
 * Theme setup.
 */
function hvac_setup() {
	// Translations.
	load_theme_textdomain( 'hvac', get_template_directory() . '/languages' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Featured images.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true );

	// HTML5 markup for core features.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Editor / block styles pick up theme fonts & colors.
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );

	// RSS feed links.
	add_theme_support( 'automatic-feed-links' );

	// Nav menus.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'hvac' ),
			'footer'  => esc_html__( 'Footer Menu', 'hvac' ),
		)
	);
}
add_action( 'after_setup_theme', 'hvac_setup' );

/**
 * Set the content width in pixels, for embeds and images.
 */
function hvac_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hvac_content_width', 800 );
}
add_action( 'after_setup_theme', 'hvac_content_width', 0 );

/**
 * Register widget areas.
 */
function hvac_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main Sidebar', 'hvac' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Appears on blog posts and pages.', 'hvac' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer widget area number */
				'name'          => sprintf( esc_html__( 'Footer Widget Area %d', 'hvac' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Appears in the site footer.', 'hvac' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'hvac_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hvac_scripts() {
	// Google Fonts- Inter, Mulish, Lato, Manrope (see CSS font-family variables).
	wp_enqueue_style(
		'hvac-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Mulish:wght@400;500;600;700;800&family=Lato:wght@300;400;700;900&family=Manrope:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'hvac-style', get_stylesheet_uri(), array( 'hvac-fonts' ), HVAC_VERSION );

	wp_enqueue_script( 'hvac-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), HVAC_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hvac_scripts' );

/**
 * Preconnect to Google Fonts hosts for faster font loading.
 */
function hvac_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'hvac-fonts', 'enqueued' ) ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'hvac_resource_hints', 10, 2 );

/**
 * Custom excerpt length.
 */
function hvac_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'hvac_excerpt_length' );

/**
 * Custom excerpt "read more" ellipsis.
 */
function hvac_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'hvac_excerpt_more' );

/**
 * Template tags and helper functions.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Coming Soon mode (ACF-powered options page + front-end gate).
 */
require get_template_directory() . '/inc/coming-soon.php';

/**
 * Theme Options (ACF-powered options page with per-module subpages).
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Global business details (phone, email, address, hours, socials)- the
 * single source of truth read by the header, footer, and every page that
 * shows contact info.
 */
require get_template_directory() . '/inc/business-info-fields.php';

/**
 * Handles submissions from the theme's built-in forms (booking widgets,
 * Contact Us, footer newsletter signup), emailing them to the global
 * business email and showing a confirmation message on the page.
 */
require get_template_directory() . '/inc/form-handler.php';

/**
 * Media support (WebP + admin-only, sanitised SVG uploads).
 */
require get_template_directory() . '/inc/media-support.php';

/**
 * Secure Custom Fields for the "Home Page" template.
 */
require get_template_directory() . '/inc/home-page-fields.php';

/**
 * Per-page settings (transparent header toggle).
 */
require get_template_directory() . '/inc/page-settings.php';

/**
 * Custom post types (Service) and their fields.
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Custom post type (Testimonial) and its fields- the single source of truth
 * for customer reviews shown across the theme.
 */
require get_template_directory() . '/inc/testimonial-post-type.php';

/**
 * Contact Us page template fields.
 */
require get_template_directory() . '/inc/contact-fields.php';

/**
 * Location page template fields.
 */
require get_template_directory() . '/inc/location-fields.php';

/**
 * Privacy Policy page template fields.
 */
require get_template_directory() . '/inc/privacy-fields.php';

/**
 * FAQ page template fields.
 */
require get_template_directory() . '/inc/faq-fields.php';

/**
 * Blog page template fields.
 */
require get_template_directory() . '/inc/blog-fields.php';

/**
 * About Us page template fields.
 */
require get_template_directory() . '/inc/about-fields.php';

/**
 * Flexible Content "page builder" fields (Pages using that template, and
 * every standard blog Post automatically- see hvac_use_flexible_content_for_posts()
 * below).
 */
require get_template_directory() . '/inc/flexible-content-fields.php';

/**
 * Automatically serve every standard blog Post with the Flexible Content
 * template, so editors get the page-builder sections without having to pick
 * a template by hand (the "post" post type has no template picker by
 * default). Pages still choose this template manually in the usual way.
 */
function hvac_use_flexible_content_for_posts( $template ) {
	if ( is_singular( 'post' ) ) {
		$flexible = locate_template( 'page-flexible-content.php' );
		if ( $flexible ) {
			return $flexible;
		}
	}
	return $template;
}
add_filter( 'template_include', 'hvac_use_flexible_content_for_posts' );
