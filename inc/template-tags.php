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
 * Render an image from an ACF image array, or a placeholder box.
 * Shared by the home template and the services archive.
 *
 * @param array|false $image ACF image array.
 * @param string      $size  Image size.
 * @param string      $class CSS class.
 */
if ( ! function_exists( 'hvac_acf_image' ) ) {
	function hvac_acf_image( $image, $size = 'large', $class = '' ) {
		if ( ! empty( $image['ID'] ) ) {
			echo wp_get_attachment_image( $image['ID'], $size, false, array( 'class' => $class ) );
		} elseif ( ! empty( $image['url'] ) ) {
			printf( '<img class="%1$s" src="%2$s" alt="%3$s">', esc_attr( $class ), esc_url( $image['url'] ), esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : '' ) );
		} else {
			printf( '<span class="img-placeholder %s" aria-hidden="true"></span>', esc_attr( $class ) );
		}
	}
}

/**
 * A small "wave" eyebrow icon (matches the Figma tilde/wave motif).
 *
 * @return string
 */
if ( ! function_exists( 'hvac_wave_icon' ) ) {
	function hvac_wave_icon() {
		return '<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1.64379 3.75726C3.39079 2.25726 4.77079 1.07126 8.51579 3.18726C10.3148 4.20326 11.7658 4.58726 12.9728 4.58526C15.0878 4.58526 16.4588 3.40926 17.6438 2.39226C17.8472 2.21532 17.9737 1.96612 17.9965 1.69749C18.0192 1.42886 17.9365 1.16192 17.7658 0.953261C17.6825 0.850869 17.5796 0.766217 17.463 0.704312C17.3464 0.642407 17.2187 0.604506 17.0872 0.592852C16.9557 0.581197 16.8233 0.596026 16.6976 0.636461C16.572 0.676895 16.4558 0.742115 16.3558 0.828261C14.6098 2.33026 13.2288 3.51626 9.48379 1.39826C4.53579 -1.39474 2.21779 0.595261 0.355789 2.19526C0.15254 2.37234 0.0262366 2.62161 0.00364913 2.89024C-0.0189384 3.15886 0.0639655 3.42572 0.234789 3.63426C0.318112 3.73648 0.421092 3.82094 0.537636 3.88265C0.65418 3.94436 0.78192 3.98207 0.913294 3.99354C1.04467 4.00501 1.17701 3.99 1.30248 3.94942C1.42796 3.90884 1.54402 3.84349 1.64379 3.75726ZM16.3558 5.93526C14.6098 7.43526 13.2288 8.62326 9.48379 6.50526C4.53579 3.71026 2.21779 5.70126 0.355789 7.30026C0.15254 7.47734 0.0262366 7.72661 0.00364913 7.99524C-0.0189384 8.26386 0.0639655 8.53072 0.234789 8.73926C0.317968 8.84162 0.420838 8.92625 0.53731 8.98815C0.653782 9.05004 0.781487 9.08794 0.912867 9.09959C1.04425 9.11125 1.17663 9.09642 1.30218 9.056C1.42773 9.01558 1.54389 8.95038 1.64379 8.86426C3.39079 7.36326 4.77079 6.17726 8.51579 8.29226C10.3148 9.31026 11.7658 9.69226 12.9728 9.69226C15.0878 9.69226 16.4588 8.51626 17.6438 7.49726C17.8473 7.32063 17.974 7.07157 17.9968 6.80303C18.0195 6.53449 17.9367 6.26766 17.7658 6.05926C17.6825 5.95682 17.5796 5.87215 17.463 5.81025C17.3464 5.74836 17.2185 5.71051 17.087 5.69894C16.9555 5.68738 16.823 5.70234 16.6974 5.74293C16.5718 5.78353 16.4556 5.84893 16.3558 5.93526ZM16.3558 11.0413C14.6098 12.5433 13.2288 13.7293 9.48379 11.6133C4.53579 8.81826 2.21779 10.8083 0.355789 12.4083C0.15254 12.5853 0.0262366 12.8346 0.00364913 13.1032C-0.0189384 13.3719 0.0639655 13.6387 0.234789 13.8473C0.31803 13.9496 0.420978 14.0342 0.537524 14.096C0.654071 14.1577 0.781842 14.1955 0.913256 14.207C1.04467 14.2184 1.17705 14.2034 1.30254 14.1627C1.42803 14.1221 1.54408 14.0566 1.64379 13.9703C3.39079 12.4703 4.77079 11.2853 8.51579 13.4003C10.3148 14.4163 11.7658 14.8003 12.9728 14.8003C15.0878 14.8003 16.4588 13.6223 17.6438 12.6053C17.8472 12.4283 17.9737 12.1791 17.9965 11.9105C18.0192 11.6419 17.9365 11.3749 17.7658 11.1663C17.6823 11.0642 17.5792 10.9799 17.4627 10.9182C17.3461 10.8566 17.2184 10.8188 17.0871 10.8071C16.9557 10.7955 16.8234 10.8102 16.6978 10.8504C16.5722 10.8906 16.4559 10.9555 16.3558 11.0413Z" fill="#F6F237"/></svg>';
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
