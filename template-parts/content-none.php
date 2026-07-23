<?php
/**
 * Template part shown when no content is found.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="no-results not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'hvac' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: link to add new post */
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'hvac' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with different keywords.', 'hvac' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hvac' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>

</section>
