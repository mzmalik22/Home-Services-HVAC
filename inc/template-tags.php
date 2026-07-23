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
