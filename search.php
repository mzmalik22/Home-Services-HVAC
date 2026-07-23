<?php
/**
 * The template for displaying search results pages.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="site-main-inner <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : ''; ?>">

	<main id="primary" class="content-area">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query */
					printf( esc_html__( 'Search Results for: %s', 'hvac' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>

			<div class="post-cards">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				endwhile;
				?>
			</div>

			<?php hvac_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php
get_footer();
