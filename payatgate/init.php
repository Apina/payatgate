<?php
// This is for the gateway display
$payatgate_payment_settings = get_option('event_espresso_payatgate_payment_settings');
if ($payatgate_payment_settings['show'] != 'N') {
	add_action('action_hook_espresso_display_offline_payment_header', 'espresso_display_offline_payment_header');
	add_action('action_hook_espresso_display_offline_payment_footer', 'espresso_display_offline_payment_footer');
	event_espresso_require_gateway("payatgate/payatgate_vars.php");
}