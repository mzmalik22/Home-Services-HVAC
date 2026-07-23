<?php
/**
 * The template for displaying archive pages (category, tag, author, date).
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

			<header class="page-header archive-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<div class="post-cards">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
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
