<?php
/**
 * Template part for displaying posts in index/archive loops.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry post-card' ); ?>>

	<?php hvac_post_thumbnail(); ?>

	<div class="post-card-body">

		<header class="entry-header">
			<?php
			if ( is_singular() && get_queried_object_id() === get_the_ID() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
			<div class="entry-meta">
				<?php hvac_entry_meta(); ?>
			</div>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<a class="read-more btn" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Read More &raquo;', 'hvac' ); ?>
		</a>

	</div>

</article>
