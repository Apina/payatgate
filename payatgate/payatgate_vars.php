<?php

function espresso_display_payatgate($payment_data) {
	global $org_options;
	extract($payment_data);
// Setup payment page
	$payatgate_payment_settings = get_option('event_espresso_payatgate_payment_settings');

	if ($payatgate_payment_settings['show'] == 'N') {
		return;
	}

	if (isset($default_gateway_version)) {
		echo '<!--Event Espresso Default Gateway Version ' . $default_gateway_version . '-->';
	}

	$args = array(
		'page_id' =>$org_options['return_url'],
		'r_id' =>$registration_id,
		'id' =>$attendee_id,
		'payment_type' => 'payatgate',
		'type' => 'payatgate',
	);
	$finalize_link = add_query_arg( $args, home_url() );

?>
<div id="payatgate-payment-option-dv" class="payment-option-dv">

	<a id="payatgate-payment-option-lnk" class="payment-option-lnk algn-vrt display-the-hidden" rel="payatgate-payment-option-form" style="display: table">
		<div class="vrt-cell">
			<div>
				<?php
					if ( isset( $payatgate_payment_settings['payatgate_title'] )) {
						echo stripslashes( $payatgate_payment_settings['payatgate_title'] );
					}
				?>
			</div>
		</div>
	</a>
	<br/>

	<div id="payatgate-payment-option-form-dv" class="hide-if-js">
		<div class="event-display-boxes">
			<h4 id="payatgate_title" class="payment_type_title section-heading">
				<?php
					if ( isset( $payatgate_payment_settings['payatgate_title'] )) {
						echo stripslashes( $payatgate_payment_settings['payatgate_title'] );
					}
				?>
			</h4>
			<p class="instruct">
				<?php echo wpautop( stripslashes_deep($payatgate_payment_settings['payatgate_instructions'] )); ?>
			</p>


		</div>
		<br/>
		<div class="event_espresso_attention event-messages ui-state-highlight">
			<span class="ui-icon ui-icon-alert"></span>
			<p>
				<strong><?php _e('Attention!', 'event_espresso'); ?></strong><br />
				<?php _e('Please click ', 'event_espresso'); ?>
				<a class="finalize_button allow-leave-page inline-link" href="<?php echo $finalize_link; ?>" title="<?php _e('HERE', 'event_espresso'); ?>">
					<?php _e('HERE', 'event_espresso'); ?>
				</a>
				<?php _e(' to compete your registration.'); ?>
				<div class="clear"></div>
			</p>
			<p><?php _e('Please note: failure to click the above link may result in your registration not being confirmed and your space being allocated to another customer.'); ?></p>
		</div>
		<br/>
		<p class="choose-diff-pay-option-pg">
			<a class="hide-the-displayed" rel="payatgate-payment-option-form" style="cursor:pointer;"><?php _e('Choose a different payment option', 'event_espresso'); ?></a>
		</p>

	</div>
</div>
<?php
}

add_action('action_hook_espresso_display_offline_payment_gateway', 'espresso_display_payatgate');
