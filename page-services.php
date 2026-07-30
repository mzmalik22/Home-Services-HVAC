<?php

/**
 * Template Name: Service
 *
 * A page template that lists the "Service" CPT along with the supporting
 * sections (page hero, benefits, CTA banner). Assign it to any Page via
 * Page Attributes > Template. Content is shared with the CPT archive through
 * the template-parts/services-listing part and is editable under
 * Theme Options > Services Page.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

get_header();

get_template_part('template-parts/services-listing');

get_footer();
