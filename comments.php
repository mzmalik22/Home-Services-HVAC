<?php
/**
 * The template for displaying comments.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$hvac_comment_count = get_comments_number();
			if ( 1 === (int) $hvac_comment_count ) {
				esc_html_e( '1 Comment', 'hvac' );
			} else {
				printf(
					/* translators: %s: number of comments */
					esc_html( _n( '%s Comment', '%s Comments', $hvac_comment_count, 'hvac' ) ),
					esc_html( number_format_i18n( $hvac_comment_count ) )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'hvac' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'btn',
		)
	);
	?>

</div>
