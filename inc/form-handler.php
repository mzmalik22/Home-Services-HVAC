<?php

/**
 * Handles submissions from the theme's built-in forms (hero booking forms on
 * the Home and Location templates, the Contact Us form, and the footer
 * newsletter signup), whenever no third-party form shortcode/action has been
 * configured for that field.
 *
 * Two entry points share one processing function so the form works with and
 * without JavaScript:
 *  - AJAX (admin-ajax.php): shows a confirmation/error message on the page
 *    with no reload.
 *  - Native POST (admin-post.php): redirects back to the same page with a
 *    `hvac_form` query var, so the message still renders if JS is unavailable.
 *
 * Every submission is emailed to the global business email (Theme Options >
 * Business Info), with the submitter's own email/phone set as Reply-To so a
 * reply goes straight to them.
 *
 * @package HVAC
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Field labels shown in the notification email, per form type. Any of these
 * present (and non-empty) in $_POST are included, in this order.
 */
function hvac_form_field_labels($form_type)
{
	$common = array(
		'name'            => esc_html__('Name', 'hvac'),
		'email'           => esc_html__('Email', 'hvac'),
		'phone'           => esc_html__('Phone', 'hvac'),
		'service'         => esc_html__('Service', 'hvac'),
		'preferred_date'  => esc_html__('Preferred Date', 'hvac'),
		'subject'         => esc_html__('Subject', 'hvac'),
		'message'         => esc_html__('Message', 'hvac'),
	);

	switch ($form_type) {
		case 'booking':
			return array_intersect_key($common, array_flip(array('name', 'phone', 'email', 'service', 'preferred_date')));
		case 'contact':
			return array_intersect_key($common, array_flip(array('name', 'email', 'phone', 'subject', 'message')));
		case 'subscribe':
			return array_intersect_key($common, array_flip(array('email')));
		default:
			return array();
	}
}

/**
 * Human-readable subject line + success message per form type.
 */
function hvac_form_type_meta($form_type)
{
	switch ($form_type) {
		case 'booking':
			return array(
				'subject' => esc_html__('New Booking Request', 'hvac'),
				'success' => esc_html__("Thanks- your request has been sent. We'll be in touch shortly.", 'hvac'),
			);
		case 'contact':
			return array(
				'subject' => esc_html__('New Contact Message', 'hvac'),
				'success' => esc_html__("Thanks for reaching out- we'll get back to you soon.", 'hvac'),
			);
		case 'subscribe':
			return array(
				'subject' => esc_html__('New Newsletter Signup', 'hvac'),
				'success' => esc_html__("You're subscribed. Thanks for signing up!", 'hvac'),
			);
		default:
			return array(
				'subject' => esc_html__('New Website Submission', 'hvac'),
				'success' => esc_html__('Thanks- your submission has been sent.', 'hvac'),
			);
	}
}

/**
 * Validate, sanitize, and email one form submission.
 *
 * @param array $data Raw $_POST data.
 * @return array{success: bool, message: string}
 */
function hvac_process_form_submission($data)
{
	$form_type = isset($data['form_type']) ? sanitize_key($data['form_type']) : '';
	if (! in_array($form_type, array('booking', 'contact', 'subscribe'), true)) {
		return array('success' => false, 'message' => esc_html__('Sorry, that form could not be processed.', 'hvac'));
	}

	// Honeypot: a hidden field real visitors never fill in.
	if (! empty($data['hvac_hp'])) {
		// Pretend success so bots don't learn anything, but send nothing.
		$meta = hvac_form_type_meta($form_type);
		return array('success' => true, 'message' => $meta['success']);
	}

	$labels = hvac_form_field_labels($form_type);
	$fields = array();
	foreach ($labels as $key => $label) {
		if (! empty($data[$key])) {
			$value = 'message' === $key
				? sanitize_textarea_field(wp_unslash($data[$key]))
				: sanitize_text_field(wp_unslash($data[$key]));
			if ('' !== $value) {
				$fields[$key] = $value;
			}
		}
	}

	// Minimal validation- lenient, since the on-page forms mark nothing as
	// required, but we still need enough to act on.
	if ('subscribe' === $form_type) {
		if (empty($fields['email']) || ! is_email($fields['email'])) {
			return array('success' => false, 'message' => esc_html__('Please enter a valid email address.', 'hvac'));
		}
	} else {
		if (empty($fields['name'])) {
			return array('success' => false, 'message' => esc_html__('Please enter your name.', 'hvac'));
		}
		if (empty($fields['phone']) && empty($fields['email'])) {
			return array('success' => false, 'message' => esc_html__('Please provide a phone number or email so we can reach you.', 'hvac'));
		}
		if (! empty($fields['email']) && ! is_email($fields['email'])) {
			return array('success' => false, 'message' => esc_html__('Please enter a valid email address.', 'hvac'));
		}
		if ('contact' === $form_type && empty($fields['message'])) {
			return array('success' => false, 'message' => esc_html__('Please enter a message.', 'hvac'));
		}
	}

	$to = function_exists('get_field') ? get_field('business_email', 'option') : '';
	if (! $to || ! is_email($to)) {
		$to = get_option('admin_email');
	}

	$meta    = hvac_form_type_meta($form_type);
	$site    = wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES);
	$subject = sprintf('[%1$s] %2$s', $site, $meta['subject']);
	if (! empty($fields['name'])) {
		/* translators: %s: submitter's name. */
		$subject = sprintf('[%1$s] %2$s %3$s', $site, $meta['subject'], sprintf(esc_html__('from %s', 'hvac'), $fields['name']));
	}

	$body_lines = array();
	foreach ($labels as $key => $label) {
		if (isset($fields[$key])) {
			$body_lines[] = $label . ': ' . $fields[$key];
		}
	}
	$body_lines[] = '';
	$body_lines[] = esc_html__('Sent from the website contact form.', 'hvac');
	$page_url     = isset($data['hvac_page_url']) ? esc_url_raw(wp_unslash($data['hvac_page_url'])) : '';
	if ($page_url) {
		$body_lines[] = sprintf(esc_html__('Page: %s', 'hvac'), $page_url);
	}

	// WordPress' default From address (wordpress@localhost, or wordpress@<host>
	// on some setups) is often rejected outright or spam-filtered because it
	// doesn't belong to the sending domain. Send from an address on the
	// site's own domain instead- this is what actually gets these emails
	// delivered, both here and on most real hosts.
	$site_host = wp_parse_url(home_url(), PHP_URL_HOST);
	$from_addr = 'noreply@' . ($site_host ? $site_host : 'example.com');

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: ' . $site . ' <' . $from_addr . '>',
	);
	if (! empty($fields['email']) && is_email($fields['email'])) {
		$reply_name = ! empty($fields['name']) ? $fields['name'] : $fields['email'];
		$headers[]  = 'Reply-To: ' . $reply_name . ' <' . $fields['email'] . '>';
	}

	$sent = wp_mail($to, $subject, implode("\n", $body_lines), $headers);

	if (! $sent) {
		return array('success' => false, 'message' => esc_html__('Sorry, something went wrong sending your message. Please try again or call us directly.', 'hvac'));
	}

	return array('success' => true, 'message' => $meta['success']);
}

/**
 * AJAX entry point (logged-in and logged-out visitors).
 */
function hvac_ajax_form_submit()
{
	if (! isset($_POST['hvac_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hvac_nonce'])), 'hvac_form_submit')) {
		wp_send_json_error(array('message' => esc_html__('Your session expired- please refresh the page and try again.', 'hvac')));
	}

	$result = hvac_process_form_submission($_POST); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified above.

	if ($result['success']) {
		wp_send_json_success($result);
	}
	wp_send_json_error($result);
}
add_action('wp_ajax_hvac_form_submit', 'hvac_ajax_form_submit');
add_action('wp_ajax_nopriv_hvac_form_submit', 'hvac_ajax_form_submit');

/**
 * Non-JS entry point: process, then redirect back to the referring page with
 * a query var so the page can render the same confirmation/error message.
 */
function hvac_post_form_submit()
{
	$redirect  = wp_get_referer() ? wp_get_referer() : home_url('/');
	$form_type = isset($_POST['form_type']) ? sanitize_key($_POST['form_type']) : '';

	if (! isset($_POST['hvac_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hvac_nonce'])), 'hvac_form_submit')) {
		$result = array('success' => false);
	} else {
		$result = hvac_process_form_submission($_POST); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified above.
	}

	$redirect = remove_query_arg(array('hvac_form', 'hvac_form_type'), $redirect);
	$redirect = add_query_arg(
		array(
			'hvac_form'      => $result['success'] ? 'success' : 'error',
			'hvac_form_type' => $form_type,
		),
		$redirect
	);
	$redirect .= '#' . $form_type . '-form-message';

	wp_safe_redirect($redirect);
	exit;
}
add_action('admin_post_hvac_form_submit', 'hvac_post_form_submit');
add_action('admin_post_nopriv_hvac_form_submit', 'hvac_post_form_submit');

/**
 * Render the non-JS confirmation/error banner for a given form type, based on
 * the `hvac_form` / `hvac_form_type` query vars set by the redirect above.
 * Returns an empty string when there is nothing to show. Also provides the
 * empty message container JS updates for the AJAX path.
 *
 * @param string $form_type 'booking', 'contact', or 'subscribe'.
 * @return string
 */
function hvac_form_message_html($form_type)
{
	$state = '';
	$text  = '';

	if (
		isset($_GET['hvac_form'], $_GET['hvac_form_type']) // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only display, no state change.
		&& sanitize_key(wp_unslash($_GET['hvac_form_type'])) === $form_type
	) {
		$state = ('success' === $_GET['hvac_form']) ? 'success' : 'error';
		if ('success' === $state) {
			$meta = hvac_form_type_meta($form_type);
			$text = $meta['success'];
		} else {
			$text = esc_html__('Sorry, something went wrong. Please check your details and try again.', 'hvac');
		}
	}

	ob_start();
	?>
	<div id="<?php echo esc_attr($form_type); ?>-form-message" class="hvac-form-message<?php echo $state ? ' is-' . esc_attr($state) : ''; ?>" role="status" aria-live="polite"<?php echo $state ? '' : ' hidden'; ?>><?php echo esc_html($text); ?></div>
	<?php
	return ob_get_clean();
}

/**
 * Enqueue the shared form-submission script and localize the AJAX endpoint,
 * nonce, and per-type success/generic-error strings it needs.
 */
function hvac_enqueue_form_script()
{
	wp_enqueue_script('hvac-forms', get_template_directory_uri() . '/assets/js/forms.js', array(), HVAC_VERSION, true);
	wp_localize_script(
		'hvac-forms',
		'hvacForms',
		array(
			'ajaxUrl'      => admin_url('admin-ajax.php'),
			'nonce'        => wp_create_nonce('hvac_form_submit'),
			'genericError' => esc_html__('Sorry, something went wrong. Please try again.', 'hvac'),
		)
	);
}
add_action('wp_enqueue_scripts', 'hvac_enqueue_form_script');
