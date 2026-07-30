<?php

/**
 * The template for displaying archive pages (category, tag, author, date).
 *
 * Uses the same layout as the Blog page template: a page hero followed by the
 * post-card grid and pagination.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

get_header();
?>

<section class="page-hero">
	<div class="container page-hero-inner">
		<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Blog & News', 'hvac'); ?></span>
		<?php the_archive_title('<h1 class="page-hero-heading">', '</h1>'); ?>
		<?php the_archive_description('<div class="page-hero-subtext">', '</div>'); ?>
	</div>
</section>

<section class="blog-listing-section">
	<div class="container">
		<?php if (have_posts()) : ?>
			<div class="post-cards">
				<?php
				while (have_posts()) :
					the_post();
					get_template_part('template-parts/content', get_post_type());
				endwhile;
				?>
			</div>

			<?php hvac_pagination(); ?>

		<?php else : ?>
			<?php get_template_part('template-parts/content', 'none'); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
