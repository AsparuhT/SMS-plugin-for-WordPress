<?php
// uninstall.php

// If uninstall is not called from WordPress, exit.
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Delete plugin options

// Delete Twilio account details
delete_option('twilio_sid');
delete_option('twilio_token');
delete_option('twilio_number');

// Delete WooForm options
delete_option('woo_checkbox_owner');
delete_option('order_status_owner');
delete_option('woo_textarea_owner');
delete_option('owner_number');

delete_option('woo_checkbox_client');
delete_option('order_status_client');
delete_option('woo_textarea_client');





