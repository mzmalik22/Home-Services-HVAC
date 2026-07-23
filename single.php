<?php
/**
 * The template for displaying all single posts.
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

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'single' );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'hvac' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'hvac' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;
		?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php
get_footer();
