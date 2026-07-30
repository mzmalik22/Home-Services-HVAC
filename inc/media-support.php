<?php
/**
 * Media support: enable WebP and SVG uploads.
 *
 * WebP is enabled for all users. SVG is enabled for administrators only and
 * every uploaded SVG is run through a lightweight sanitiser that strips
 * scripts and event handlers. For untrusted, multi-author sites you should
 * still use a dedicated SVG sanitiser plugin (e.g. "Safe SVG").
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the additional MIME types WordPress will accept.
 *
 * @param array $mimes Allowed MIME types.
 * @return array
 */
function hvac_allow_mime_types( $mimes ) {
	// WebP images.
	$mimes['webp'] = 'image/webp';

	// SVG- administrators only, for security.
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'hvac_allow_mime_types' );

/**
 * Help WordPress correctly identify WebP and SVG files on upload.
 *
 * Some server/WordPress combinations fail the "real MIME type" check for these
 * extensions and reject the upload; this restores the correct type/ext.
 *
 * @param array  $data     File data (ext, type, proper_filename).
 * @param string $file     Full path to the file.
 * @param string $filename The name of the file.
 * @param array  $mimes    Allowed MIME types.
 * @return array
 */
function hvac_fix_filetype_check( $data, $file, $filename, $mimes ) {
	$ext = isset( $data['ext'] ) ? $data['ext'] : '';

	if ( empty( $ext ) ) {
		$check = wp_check_filetype( $filename, $mimes );
		$ext   = $check['ext'];
	}

	if ( 'webp' === $ext ) {
		$data['ext']  = 'webp';
		$data['type'] = 'image/webp';
	}

	if ( 'svg' === $ext || 'svgz' === $ext ) {
		if ( current_user_can( 'manage_options' ) ) {
			$data['ext']  = $ext;
			$data['type'] = 'image/svg+xml';
		}
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'hvac_fix_filetype_check', 10, 4 );

/**
 * Sanitise SVG files on upload: strip scripts, event handlers and external
 * entities. Best-effort defence in depth on top of the admin-only restriction.
 *
 * @param array $file An element of the $_FILES array.
 * @return array
 */
function hvac_sanitize_svg_upload( $file ) {
	if ( empty( $file['type'] ) || 'image/svg+xml' !== $file['type'] ) {
		return $file;
	}

	// Only administrators can upload SVGs at all.
	if ( ! current_user_can( 'manage_options' ) ) {
		$file['error'] = esc_html__( 'Sorry, you are not allowed to upload SVG files.', 'hvac' );
		return $file;
	}

	if ( empty( $file['tmp_name'] ) || ! is_readable( $file['tmp_name'] ) ) {
		return $file;
	}

	$contents = file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $contents || '' === trim( $contents ) ) {
		$file['error'] = esc_html__( 'The SVG file could not be read.', 'hvac' );
		return $file;
	}

	$clean = hvac_sanitize_svg_markup( $contents );

	if ( '' === trim( $clean ) || false === strpos( $clean, '<svg' ) ) {
		$file['error'] = esc_html__( 'The SVG file failed the security check and was not uploaded.', 'hvac' );
		return $file;
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
	file_put_contents( $file['tmp_name'], $clean );

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'hvac_sanitize_svg_upload' );

/**
 * Strip dangerous constructs from SVG markup.
 *
 * @param string $svg Raw SVG contents.
 * @return string Sanitised SVG.
 */
function hvac_sanitize_svg_markup( $svg ) {
	// Remove DOCTYPE / ENTITY declarations (billion-laughs / XXE vectors).
	$svg = preg_replace( '/<!DOCTYPE[^>]*>/is', '', $svg );
	$svg = preg_replace( '/<!ENTITY[^>]*>/is', '', $svg );

	// Remove <script> and <foreignObject> blocks entirely.
	$svg = preg_replace( '#<script.*?</script>#is', '', $svg );
	$svg = preg_replace( '#<foreignObject.*?</foreignObject>#is', '', $svg );

	// Remove inline event handlers (onload, onclick, onmouseover, ...).
	$svg = preg_replace( '/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/is', '', $svg );

	// Remove javascript: URIs in href/xlink:href.
	$svg = preg_replace( '/((?:xlink:)?href)\s*=\s*("|\')\s*javascript:[^"\']*(\2)/is', '$1=$2#$3', $svg );

	return trim( $svg );
}

/**
 * Make SVGs display at a sensible size in the Media Library grid/list.
 */
function hvac_svg_admin_styles() {
	?>
	<style>
		.attachment .thumbnail img[src$=".svg"],
		.media-icon img[src$=".svg"],
		img.attachment-thumbnail[src$=".svg"] {
			width: 100% !important;
			height: auto !important;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'hvac_svg_admin_styles' );
