<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="site-main-inner">

	<main id="primary" class="content-area">

		<section class="error-404 not-found">

			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'hvac' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'hvac' ); ?></p>

				<?php get_search_form(); ?>

				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<nav class="error-404-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
							)
						);
						?>
					</nav>
				<?php endif; ?>
			</div>

		</section>

	</main>

</div>

<?php
get_footer();
