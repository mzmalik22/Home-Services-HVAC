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
		'name'            => __('Name', 'hvac'),
		'email'           => __('Email', 'hvac'),
		'phone'           => __('Phone', 'hvac'),
		'service'         => __('Service', 'hvac'),
		'preferred_date'  => __('Preferred Date', 'hvac'),
		'subject'         => __('Subject', 'hvac'),
		'message'         => __('Message', 'hvac'),
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
				'subject' => __('New Booking Request', 'hvac'),
				'success' => __("Thanks- your request has been sent. We'll be in touch shortly.", 'hvac'),
			);
		case 'contact':
			return array(
				'subject' => __('New Contact Message', 'hvac'),
				'success' => __("Thanks for reaching out - we'll get back to you soon.", 'hvac'),
			);
		case 'subscribe':
			return array(
				'subject' => __('New Newsletter Signup', 'hvac'),
				'success' => __("You're subscribed. Thanks for signing up!", 'hvac'),
			);
		default:
			return array(
				'subject' => __('New Website Submission', 'hvac'),
				'success' => __('Thanks- your submission has been sent.', 'hvac'),
			);
	}
}

/**
 * Check whether a value is a valid 10-digit US/Canada (NANP) phone number,
 * regardless of formatting (spaces, dashes, parentheses, a leading "+1" or
 * "1" are all accepted). The area code and exchange code must not start
 * with 0 or 1, matching the real NANP numbering rules.
 *
 * @param string $value Raw phone input.
 * @return bool
 */
function hvac_is_us_phone($value)
{
	$digits = preg_replace('/\D/', '', (string) $value);
	if (11 === strlen($digits) && '1' === $digits[0]) {
		$digits = substr($digits, 1);
	}
	if (10 !== strlen($digits)) {
		return false;
	}
	return (bool) preg_match('/^[2-9]\d{2}[2-9]\d{6}$/', $digits);
}

/**
 * Format a validated 10-digit US phone number as "(XXX) XXX-XXXX".
 *
 * @param string $value Raw phone input (must already pass hvac_is_us_phone()).
 * @return string
 */
function hvac_format_us_phone($value)
{
	$digits = preg_replace('/\D/', '', (string) $value);
	if (11 === strlen($digits) && '1' === $digits[0]) {
		$digits = substr($digits, 1);
	}
	return sprintf('(%s) %s-%s', substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6, 4));
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
		return array('success' => false, 'message' => __('Sorry, that form could not be processed.', 'hvac'));
	}

	// Anti-spam: the honeypot field alone is not enough to act on- browser
	// password managers are known to bulk-fill every empty input on a form,
	// including hidden ones, which would otherwise silently drop real leads.
	// Only treat a submission as spam when the honeypot is filled AND the
	// form was submitted implausibly fast (a real visitor, even with
	// autofill, still takes at least a couple of seconds to submit).
	$honeypot_filled = ! empty($data['hvac_hp']);
	$loaded_at       = isset($data['hvac_ts']) ? (int) $data['hvac_ts'] : 0;
	$elapsed         = $loaded_at > 0 ? (time() - $loaded_at) : -1;
	$submitted_fast  = $elapsed >= 0 && $elapsed < 2;

	if ($honeypot_filled && $submitted_fast) {
		// Pretend success so bots don't learn anything, but send nothing.
		$meta = hvac_form_type_meta($form_type);
		return array('success' => true, 'message' => $meta['success']);
	}
	if ($honeypot_filled) {
		// Filled but not suspiciously fast- most likely a password manager,
		// not a bot. Log it and keep processing normally.
		error_log(sprintf('HVAC form: honeypot was filled but timing looks human (elapsed=%ds); sending normally. form_type=%s', max($elapsed, 0), $form_type));
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

	// Per-field validation, matching what each form marks as required on the
	// page. Re-checked here because client-side validation can be bypassed.
	if (in_array($form_type, array('booking', 'contact'), true) && empty($fields['name'])) {
		return array('success' => false, 'message' => __('Please enter your name.', 'hvac'));
	}
	if (isset($fields['name']) && mb_strlen($fields['name']) < 2) {
		return array('success' => false, 'message' => __('Please enter your full name.', 'hvac'));
	}

	// Email: required for contact + subscribe; optional (but validated if
	// given) for booking, which requires a phone number instead.
	$email_required = in_array($form_type, array('contact', 'subscribe'), true);
	if ($email_required && empty($fields['email'])) {
		return array('success' => false, 'message' => __('Please enter a valid email address.', 'hvac'));
	}
	if (! empty($fields['email']) && ! is_email($fields['email'])) {
		return array('success' => false, 'message' => __('Please enter a valid email address.', 'hvac'));
	}

	// Phone: required for booking; optional (but validated if given) for
	// contact. Only US numbers are accepted, matching the on-page +1 field.
	$phone_required = ('booking' === $form_type);
	if ($phone_required && empty($fields['phone'])) {
		return array('success' => false, 'message' => __('Please enter your phone number.', 'hvac'));
	}
	if (! empty($fields['phone'])) {
		if (! hvac_is_us_phone($fields['phone'])) {
			return array('success' => false, 'message' => __('Please enter a valid 10-digit US phone number, e.g. (555) 123-4567.', 'hvac'));
		}
		$fields['phone'] = hvac_format_us_phone($fields['phone']);
	}

	if ('contact' === $form_type) {
		if (empty($fields['message'])) {
			return array('success' => false, 'message' => __('Please enter a message.', 'hvac'));
		}
		if (mb_strlen($fields['message']) < 10) {
			return array('success' => false, 'message' => __('Please enter a message of at least 10 characters.', 'hvac'));
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
		$subject = sprintf('[%1$s] %2$s %3$s', $site, $meta['subject'], sprintf(__('from %s', 'hvac'), $fields['name']));
	}

	$body_lines = array();
	foreach ($labels as $key => $label) {
		if (isset($fields[$key])) {
			$body_lines[] = $label . ': ' . $fields[$key];
		}
	}
	$body_lines[] = '';
	$body_lines[] = __('Sent from the website contact form.', 'hvac');
	$page_url     = isset($data['hvac_page_url']) ? esc_url_raw(wp_unslash($data['hvac_page_url'])) : '';
	if ($page_url) {
		$body_lines[] = sprintf(__('Page: %s', 'hvac'), $page_url);
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
		return array('success' => false, 'message' => __('Sorry, something went wrong sending your message. Please try again or call us directly.', 'hvac'));
	}

	return array('success' => true, 'message' => $meta['success']);
}

/**
 * AJAX entry point (logged-in and logged-out visitors).
 */
function hvac_ajax_form_submit()
{
	if (! isset($_POST['hvac_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hvac_nonce'])), 'hvac_form_submit')) {
		wp_send_json_error(array('message' => __('Your session expired- please refresh the page and try again.', 'hvac')));
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
			$text = __('Sorry, something went wrong. Please check your details and try again.', 'hvac');
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
			'genericError' => __('Sorry, something went wrong. Please try again.', 'hvac'),
		)
	);
}
add_action('wp_enqueue_scripts', 'hvac_enqueue_form_script');
