<?php

/**
 * Template Name: Blog
 *
 * A blog listing page matching the theme's V2 design: a page hero, an optional
 * featured (latest) post, a paginated grid of posts (reusing the theme's post
 * card), and a CTA banner. Editable via the "Blog Page" field group (SCF).
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

$hvac_acf = function_exists('get_field');

get_header();

$bl_eyebrow = $hvac_acf ? get_field('blog_eyebrow') : '';
if (! $bl_eyebrow) {
	$bl_eyebrow = __('Blog & News', 'hvac');
}
$bl_heading = $hvac_acf ? get_field('blog_heading') : '';
if (! $bl_heading) {
	$bl_heading = __('HVAC Tips, Guides & Updates', 'hvac');
}
$bl_subtext = $hvac_acf ? get_field('blog_subtext') : '';
if (! $bl_subtext) {
	$bl_subtext = __('Expert advice, maintenance tips, and the latest news to help you keep your home comfortable all year round.', 'hvac');
}
$bl_bg = $hvac_acf ? get_field('blog_bg') : false;

$bl_show_featured = $hvac_acf ? (bool) get_field('blog_show_featured') : true;
$bl_per_page      = $hvac_acf ? (int) get_field('blog_per_page') : 9;
if ($bl_per_page < 1) {
	$bl_per_page = 9;
}

$bl_paged = get_query_var('paged') ? (int) get_query_var('paged') : (get_query_var('page') ? (int) get_query_var('page') : 1);

// Determine the featured (latest) post so it can be excluded from the grid
// consistently across all pages; it only renders at the top of page 1.
$bl_featured_id = 0;
if ($bl_show_featured) {
	$bl_latest = get_posts(array('numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids'));
	if (! empty($bl_latest)) {
		$bl_featured_id = (int) $bl_latest[0];
	}
}

$bl_args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => $bl_per_page,
	'paged'          => $bl_paged,
);
if ($bl_featured_id) {
	$bl_args['post__not_in'] = array($bl_featured_id);
}
$bl_query = new WP_Query($bl_args);

$bl_cta_show = $hvac_acf ? get_field('blog_cta_show') : true;
$bl_cta_head = $hvac_acf ? get_field('blog_cta_heading') : '';
if (! $bl_cta_head) {
	$bl_cta_head = __('Need Expert HVAC Help? Book a Service Today.', 'hvac');
}
$bl_cta_btn = $hvac_acf ? get_field('blog_cta_button') : false;
?>

<section class="page-hero"<?php echo (is_array($bl_bg) && ! empty($bl_bg['url'])) ? ' style="background-image:url(' . esc_url($bl_bg['url']) . ')"' : ''; ?>>
	<div class="container page-hero-inner">
		<?php if ($bl_eyebrow) : ?>
			<span class="section-eyebrow section-eyebrow-light"><?php echo hvac_wave_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($bl_eyebrow); ?></span>
		<?php endif; ?>
		<h1 class="page-hero-heading"><?php echo esc_html($bl_heading); ?></h1>
		<?php if ($bl_subtext) : ?><p class="page-hero-subtext"><?php echo esc_html($bl_subtext); ?></p><?php endif; ?>
	</div>
</section>

<section class="blog-listing-section">
	<div class="container">

		<?php
		/* Featured latest post- page 1 only. */
		if ($bl_featured_id && 1 === $bl_paged) :
			$bl_feat = new WP_Query(array('p' => $bl_featured_id, 'post_type' => 'post'));
			if ($bl_feat->have_posts()) :
				while ($bl_feat->have_posts()) :
					$bl_feat->the_post();
					$cats = get_the_category();
					?>
					<article class="blog-featured">
						<a class="blog-featured-media" href="<?php the_permalink(); ?>">
							<?php
							if (has_post_thumbnail()) {
								the_post_thumbnail('large', array('class' => 'blog-featured-image'));
							} else {
								echo '<span class="img-placeholder blog-featured-image" aria-hidden="true"></span>';
							}
							?>
						</a>
						<div class="blog-featured-body">
							<span class="blog-featured-tag"><?php esc_html_e('Latest Post', 'hvac'); ?></span>
							<h2 class="blog-featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="news-meta">
								<?php echo esc_html(get_the_date()); ?><?php echo ! empty($cats) ? ' · ' . esc_html($cats[0]->name) : ''; ?>
							</p>
							<div class="blog-featured-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 34)); ?></div>
							<a class="btn-accent btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read Article', 'hvac'); ?></a>
						</div>
					</article>
					<?php
				endwhile;
			endif;
			wp_reset_postdata();
		endif;
		?>

		<?php if ($bl_query->have_posts()) : ?>
			<div class="post-cards">
				<?php
				while ($bl_query->have_posts()) :
					$bl_query->the_post();
					get_template_part('template-parts/content', get_post_type());
				endwhile;
				?>
			</div>

			<?php
			$bl_big   = 999999999;
			$bl_links = paginate_links(
				array(
					'base'      => str_replace($bl_big, '%#%', esc_url(get_pagenum_link($bl_big))),
					'format'    => '?paged=%#%',
					'current'   => max(1, $bl_paged),
					'total'     => $bl_query->max_num_pages,
					'prev_text' => __('&laquo; Previous', 'hvac'),
					'next_text' => __('Next &raquo;', 'hvac'),
				)
			);
			if ($bl_links) :
				?>
				<nav class="pagination" aria-label="<?php esc_attr_e('Blog navigation', 'hvac'); ?>">
					<div class="nav-links"><?php echo $bl_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</nav>
			<?php endif; ?>

		<?php elseif (! $bl_featured_id) : ?>
			<p class="blog-empty"><?php esc_html_e('No posts have been published yet. Check back soon!', 'hvac'); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<?php if ($bl_cta_show) : ?>
	<?php
	$bl_cta_url = ! empty($bl_cta_btn['url']) ? $bl_cta_btn['url'] : '#';
	$bl_cta_txt = ! empty($bl_cta_btn['title']) ? $bl_cta_btn['title'] : __('Book Now', 'hvac');
	$bl_cta_tgt = ! empty($bl_cta_btn['target']) ? $bl_cta_btn['target'] : '';
	?>
	<section class="home-cta">
		<div class="container">
			<div class="home-cta-banner">
				<h2 class="home-cta-heading"><?php echo esc_html($bl_cta_head); ?></h2>
				<a class="btn-accent  home-cta-btn" href="<?php echo esc_url($bl_cta_url); ?>"<?php echo hvac_link_target_attrs($bl_cta_tgt); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($bl_cta_txt); ?></a>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
