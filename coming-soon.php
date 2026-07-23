<?php
/**
 * Standalone Coming Soon page, shown to visitors while Coming Soon mode
 * is enabled from the ACF "Coming Soon" options page.
 *
 * @package HVAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hvac_cs_defaults = hvac_coming_soon_defaults();

$hvac_cs_heading = get_field( 'coming_soon_heading', 'option' );
$hvac_cs_message  = get_field( 'coming_soon_message', 'option' );
$hvac_cs_logo     = get_field( 'coming_soon_logo', 'option' );
$hvac_cs_bg       = get_field( 'coming_soon_background', 'option' );
$hvac_cs_email    = get_field( 'coming_soon_email', 'option' );

if ( ! $hvac_cs_heading ) {
	$hvac_cs_heading = $hvac_cs_defaults['heading'];
}
if ( ! $hvac_cs_message ) {
	$hvac_cs_message = $hvac_cs_defaults['message'];
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?> &mdash; <?php esc_html_e( 'Coming Soon', 'hvac' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'coming-soon-page' ); ?>>
<?php wp_body_open(); ?>

<div class="coming-soon-wrap"<?php echo $hvac_cs_bg ? ' style="background-image:url(' . esc_url( $hvac_cs_bg ) . ');"' : ''; ?>>
	<div class="coming-soon-card">

		<?php if ( $hvac_cs_logo ) : ?>
			<img class="coming-soon-logo" src="<?php echo esc_url( $hvac_cs_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<?php elseif ( has_custom_logo() ) : ?>
			<div class="coming-soon-logo"><?php the_custom_logo(); ?></div>
		<?php else : ?>
			<p class="coming-soon-sitename"><?php bloginfo( 'name' ); ?></p>
		<?php endif; ?>

		<h1 class="coming-soon-heading"><?php echo esc_html( $hvac_cs_heading ); ?></h1>

		<div class="coming-soon-message">
			<?php echo wp_kses_post( $hvac_cs_message ); ?>
		</div>

		<?php if ( $hvac_cs_email ) : ?>
			<p class="coming-soon-contact">
				<?php esc_html_e( 'Get in touch:', 'hvac' ); ?>
				<a href="mailto:<?php echo esc_attr( $hvac_cs_email ); ?>"><?php echo esc_html( $hvac_cs_email ); ?></a>
			</p>
		<?php endif; ?>

	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
