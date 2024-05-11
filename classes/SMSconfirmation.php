<?php




// load Twilio Classes
//require dirname(__DIR__) . '/vendor/autoload.php';
use Twilio\Rest\Client;

// The class that is responsiblle for the SMS order conformation 

class SMSconfirmation
{
    function __construct()
    {
        // Add action that check for order upgrade after functions.php is loaded
        add_action('after_setup_theme', array($this, 'initOrderCompleteAction'));
    } // end of construct




    function initOrderCompleteAction()
    {
        if (get_option('woo_checkbox_client') == '1') {
            $order_status_client = get_option('order_status_client');
            add_action('woocommerce_order_status_' . $order_status_client, array($this, 'send_sms_confirmation_client'), 100, 1);
        }

        if (get_option('woo_checkbox_owner') == '1') {
            $order_status_owner = get_option('order_status_owner');
            add_action('woocommerce_order_status_' . $order_status_owner, array($this, 'send_sms_confirmation_owner'), 10, 1);
        }
    }








    function send_sms_confirmation_client($order_id)
    {
        try {

            // Get the order object
            $order = wc_get_order($order_id);

            // Extract order information
            $billing_phone = $order->get_billing_phone();
            $order_number = $order->get_order_number();
            $items = $order->get_items();

            // Extract item names and store them in an array
            $item_names = array();
            foreach ($items as $item) {
                $item_names[] = $item->get_name();
            }

            // Output the item names separated by commas
            echo implode(', ', $item_names);

            // Send the SMS function 
            // Your Account SID and Auth Token from twilio.com/console
            // To set up environmental variables, see http://twil.io/secure
            $account_sid = Encryption::decrypt(get_option('twilio_sid'));
            $auth_token = Encryption::decrypt(get_option('twilio_token'));
            // In production, these should be environment variables. E.g.:
            // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

            // A Twilio number you own with SMS capabilities
            $twilio_number = Encryption::decrypt(get_option('twilio_number'));
            $sms_body = get_option('woo_textarea_client');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                $billing_phone,
                array(
                    'from' => $twilio_number,
                    'body' => $sms_body ? $sms_body : ""
                )
            );
        } catch (Twilio\Exceptions\ConfigurationException $e) {
            // Error message for missing or incorrect Twilio credentials
        } catch (Twilio\Exceptions\RestException $e) {
            // Custom error message for RestException
        }
    } // end of sms_client





    function send_sms_confirmation_owner($order_id)
    {

        try {

            // Get the order object
            $order = wc_get_order($order_id);

            // Extract order information
            //$billing_phone = $order->get_billing_phone();
            $order_number = $order->get_order_number();
            $items = $order->get_items();

            // Extract item names and store them in an array
            $item_names = array();
            foreach ($items as $item) {
                $item_names[] = $item->get_name();
            }

            // Output the item names separated by commas
            echo implode(', ', $item_names);

            // Send the SMS function 
            // Your Account SID and Auth Token from twilio.com/console
            // To set up environmental variables, see http://twil.io/secure
            $account_sid = Encryption::decrypt(get_option('twilio_sid'));
            $auth_token = Encryption::decrypt(get_option('twilio_token'));

            // A Twilio number you own with SMS capabilities
            $twilio_number = Encryption::decrypt(get_option('twilio_number'));
            $sms_body = get_option('woo_textarea_owner');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                get_option('owner_number'),
                array(
                    'from' => $twilio_number,
                    'body' => $sms_body ? $sms_body : ""
                )
            );

        } catch (Twilio\Exceptions\ConfigurationException $e) {
            // Error message for missing or incorrect Twilio credentials
        } catch (Twilio\Exceptions\RestException $e) {
            // Custom error message for RestException
        }
    } // end of sms_owner







} // end of class SMSconfirmation