<?php

/**
 * The services listing page (archive for the "Service" CPT).
 *
 * The layout (page hero, services grid, benefits, CTA banner) is shared with
 * the "Service" page template via the template-parts/services-listing part, so
 * both stay in sync. Editable under Theme Options > Services Page.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

get_header();

get_template_part('template-parts/services-listing');

get_footer();
