<?php
/**
 * Template part for displaying a single post.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php hvac_post_thumbnail(); ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
			<?php hvac_entry_meta(); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hvac' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php hvac_entry_tags(); ?>
	</footer>

</article>
