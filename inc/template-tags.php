<?php
/**
 * Custom template tags for this theme.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints the entry meta (date, author, category) for posts.
 */
if ( ! function_exists( 'hvac_entry_meta' ) ) {
	function hvac_entry_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		printf(
			/* translators: 1: date, 2: author */
			esc_html__( 'Posted on %1$s by %2$s', 'hvac' ),
			$time_string, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<span class="author vcard">' . esc_html( get_the_author() ) . '</span>'
		);

		$categories_list = get_the_category_list( esc_html__( ', ', 'hvac' ) );
		if ( $categories_list ) {
			echo ' <span class="cat-links">' . esc_html__( 'in', 'hvac' ) . ' ' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

/**
 * Prints a comma separated list of tags for a single post.
 */
if ( ! function_exists( 'hvac_entry_tags' ) ) {
	function hvac_entry_tags() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'hvac' ) );
		if ( $tags_list ) {
			printf( '<div class="entry-tags">' . esc_html__( 'Tagged: %1$s', 'hvac' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

/**
 * Numeric pagination for archives.
 */
if ( ! function_exists( 'hvac_pagination' ) ) {
	function hvac_pagination() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( '&laquo; Previous', 'hvac' ),
				'next_text' => esc_html__( 'Next &raquo;', 'hvac' ),
			)
		);
	}
}

/**
 * Return an inline SVG icon for a social network (shared by header + footer).
 *
 * @param string $network Network slug.
 * @return string
 */
if ( ! function_exists( 'hvac_social_icon' ) ) {
	function hvac_social_icon( $network ) {
		$icons = array(
			'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
			'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
			'x'         => '<path d="M4 4l16 16M20 4L4 20"/>',
			'linkedin'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
			'youtube'   => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>',
		);
		$path  = isset( $icons[ $network ] ) ? $icons[ $network ] : '';
		if ( '' === $path ) {
			return '';
		}
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
	}
}

/**
 * Return target/rel attributes for a link, based on an ACF link "target" value.
 *
 * @param string $target The ACF link target ('_blank' or '').
 * @return string Ready-to-print attribute string (leading space included).
 */
if ( ! function_exists( 'hvac_link_target_attrs' ) ) {
	function hvac_link_target_attrs( $target ) {
		if ( '_blank' === $target ) {
			return ' target="_blank" rel="noopener noreferrer"';
		}
		return '';
	}
}

/**
 * Displays the post thumbnail wrapped in a link, if one exists.
 */
if ( ! function_exists( 'hvac_post_thumbnail' ) ) {
	function hvac_post_thumbnail() {
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( is_singular() ? 'large' : 'medium_large' ); ?>
			</a>
		</div>
		<?php
	}
}
