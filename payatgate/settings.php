<?php

function event_espresso_payatgate_payment_settings() {
	global $espresso_premium, $active_gateways, $org_options;
	if (!$espresso_premium)
		return;
	if (isset($_POST['update_payatgate_payment_settings'])) {
		$payatgate_payment_settings['payatgate_title'] = strip_tags($_POST['payatgate_title']);
		$payatgate_payment_settings['image_url'] = strip_tags($_POST['image_url']);
		$payatgate_payment_settings['show'] = strip_tags($_POST['show']);
		update_option('event_espresso_payatgate_payment_settings', $payatgate_payment_settings);
		echo '<div id="message" class="updated fade"><p><strong>' . __('Pay At The Gate Payment settings saved.', 'event_espresso') . '</strong></p></div>';
	}
	$payatgate_payment_settings = get_option('event_espresso_payatgate_payment_settings');
	if (empty($payatgate_payment_settings)) {
		$payatgate_payment_settings['payatgate_title'] = __('Pay At The Gate', 'event_espresso');
		$payatgate_payment_settings['image_url'] = '';
		$payatgate_payment_settings['show'] = 'Y';
		if (add_option('event_espresso_payatgate_payment_settings', $payatgate_payment_settings, '', 'no') == false) {
			update_option('event_espresso_payatgate_payment_settings', $payatgate_payment_settings);
		}
	}

	//Open or close the postbox div
	if (empty($_REQUEST['deactivate_payatgate_payment'])
					&& (!empty($_REQUEST['activate_payatgate_payment'])
					|| array_key_exists('payatgate', $active_gateways))) {
		$postbox_style = '';
	} else {
		$postbox_style = 'closed';
	}
	?>

	<div class="metabox-holder">
		<div class="postbox <?php echo $postbox_style; ?>">
			<div title="Click to toggle" class="handlediv"><br /></div>
			<h3 class="hndle">
				<?php _e('Pay At The Gate Payment Settings', 'event_espresso'); ?>
			</h3>
			<div class="inside">
				<div class="padding">
					<?php
					if (!empty($_REQUEST['activate_payatgate_payment'])) {
						$active_gateways['payatgate'] = dirname(__FILE__);
						update_option('event_espresso_active_gateways', $active_gateways);
					}
					if (!empty($_REQUEST['deactivate_payatgate_payment'])) {
						unset($active_gateways['payatgate']);
						update_option('event_espresso_active_gateways', $active_gateways);
					}
					echo '<ul>';
					if (array_key_exists('payatgate', $active_gateways)) {
						echo '<li id="deactivate_payatgate" style="width:30%;" onclick="location.href=\'' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=payment_gateways&deactivate_payatgate_payment=true\';" class="red_alert pointer"><strong>' . __('Deactivate Pay At The Gate Payments?', 'event_espresso') . '</strong></li>';
						event_espresso_display_payatgate_payment_settings();
					} else {
						echo '<li id="activate_payatgate" style="width:30%;" onclick="location.href=\'' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=payment_gateways&activate_payatgate_payment=true\';" class="green_alert pointer"><strong>' . __('Activate Pay At The Gate Payments?', 'event_espresso') . '</strong></li>';
					}
					echo '</ul>';
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

//payatgate Payments Settings Form
function event_espresso_display_payatgate_payment_settings() {
	$payatgate_payment_settings = get_option('event_espresso_payatgate_payment_settings');
	?>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
		<table width="99%" border="0" cellspacing="5" cellpadding="5">
			<tr>
				<td valign="top">
					<ul>
						<li>
							<label for="payatgate_title">
								<?php _e('Title', 'event_espresso'); ?>
							</label>
							<input type="text" name="payatgate_title" size="30" value="<?php echo stripslashes_deep($payatgate_payment_settings['payatgate_title']); ?>" />
						</li>
						<li>
							<label for="payatgate_instructions">
								<?php _e('Pay At The Gate Instructions', 'event_espresso'); ?>
							</label>
							<textarea name="payatgate_instructions" cols="30" rows="5"><?php echo stripslashes_deep($payatgate_payment_settings['payatgate_instructions']); ?></textarea>
						</li>
					</ul>
				</td>

			</tr>
		</table>
		<input type="hidden" name="update_payatgate_payment_settings" value="update_payatgate_payment_settings">
		<p>
			<input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Pay At The Gate Payment Settings', 'event_espresso') ?>" id="save_payatgate_payment_settings" />
		</p>
	</form>
	<?php
}

add_action('action_hook_espresso_display_gateway_settings', 'event_espresso_payatgate_payment_settings');
