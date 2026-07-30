<?php

/**
 * The template for displaying single blog posts.
 *
 * Themed to match the V2 design: a dark hero with post meta, an overlapping
 * featured image, a readable article body, tags, post navigation, related
 * posts, and comments. (The "service" CPT uses single-service.php.)
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

get_header();

while (have_posts()) :
	the_post();

	$cats     = get_the_category();
	$cat      = ! empty($cats) ? $cats[0] : null;
	$comments = (int) get_comments_number();
?>

	<section class="page-hero single-hero">
		<div class="container page-hero-inner">
			<nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'hvac'); ?>">
				<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'hvac'); ?></a>
				<span aria-hidden="true">/</span>
				<?php if ($cat) : ?>
					<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
					<span aria-hidden="true">/</span>
				<?php endif; ?>
				<span class="breadcrumb-current"><?php the_title(); ?></span>
			</nav>

			<?php if ($cat) : ?><span class="single-cat"><?php echo esc_html($cat->name); ?></span><?php endif; ?>
			<h1 class="page-hero-heading single-title"><?php the_title(); ?></h1>

			<div class="single-meta">
				<span class="single-meta-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
					<?php echo esc_html(get_the_date()); ?>
				</span>
				<span class="single-meta-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" /></svg>
					<?php echo esc_html(get_the_author()); ?>
				</span>
				<?php if ($comments > 0) : ?>
					<span class="single-meta-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" /></svg>
						<?php printf(esc_html(_n('%d Comment', '%d Comments', $comments, 'hvac')), $comments); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="single-wrap">
		<div class="container">

			<?php if (has_post_thumbnail()) : ?>
				<div class="single-feature">
					<?php the_post_thumbnail('large', array('class' => 'single-feature-image')); ?>
				</div>
			<?php endif; ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
				<div class="entry-content single-content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__('Pages:', 'hvac'),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<?php if (has_tag()) : ?>
					<footer class="single-tags">
						<?php hvac_entry_tags(); ?>
					</footer>
				<?php endif; ?>
			</article>

			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous', 'hvac') . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__('Next', 'hvac') . '</span> <span class="nav-title">%title</span>',
				)
			);
			?>
		</div>
	</div>

	<?php
	/* Related posts- same category, newest first. */
	$rel_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post__not_in'        => array(get_the_ID()),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	if ($cat) {
		$rel_args['cat'] = $cat->term_id;
	}
	$rel_q = new WP_Query($rel_args);
	if ($rel_q->have_posts()) :
		?>
		<section class="blog-listing-section single-related">
			<div class="container">
				<div class="section-head section-head-center">
					<span class="section-eyebrow"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('Keep Reading', 'hvac'); ?></span>
					<h2 class="section-heading"><?php esc_html_e('Related Articles', 'hvac'); ?></h2>
				</div>
				<div class="post-cards">
					<?php
					while ($rel_q->have_posts()) :
						$rel_q->the_post();
						get_template_part('template-parts/content', get_post_type());
					endwhile;
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
	wp_reset_postdata();
	?>

	<?php if (comments_open() || get_comments_number()) : ?>
		<div class="single-comments">
			<div class="container">
				<?php comments_template(); ?>
			</div>
		</div>
	<?php endif; ?>

<?php
endwhile;

get_footer();
