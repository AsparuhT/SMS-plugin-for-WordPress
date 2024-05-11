<?php
/*

    Plugin Name: SMS Plugin
    Description: A plugin that provides an easy way to set up SMS sending functionality for a website using your Twilio account. It allows for general SMS sending, or SMS notifications triggered by WooCommerce events, as well as one-time passcode (OTP) verification.
    Version: 1.0
    Author: Asparuh Tenev
    Author URI: https://atenev.com

*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// load Twilio Classes
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

// load the rest of the classes
require __DIR__ . '/classes/SMSconfirmation.php';
require __DIR__ . '/classes/Encryption.php';




function on_plugin_activate()
{
    register_uninstall_hook(__FILE__, 'on_plugin_uninstall'); // adding uninstall hook
}
register_activation_hook(__FILE__, 'on_plugin_activate'); // adding activation hook



// And here goes the uninstallation function:
function on_plugin_uninstall()
{
    require plugin_dir_path(__FILE__) . "/uninstall/uninstall.php";
}




class SMSplugin
{

    function __construct()
    {
        // Initiating the classes
        $sms_confirmation = new SMSconfirmation();

        // Initiating functions and actions
        add_action('admin_menu', array($this, 'mainMenu'));

        // add JS scripts for the admin area
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        // enqueue scripts
        add_action('wp_enqueue_scripts', array($this,  'enqueue_custom_scripts'));
    } // end of __construct




    //the plugin details callback function
    function mainMenu()
    {
        // The main plugin page
        $mainPageHandle = add_menu_page('SMS plugin', 'SMS', 'manage_options', 'smsplugin', array($this, 'mainPluginPageHTML'), 'dashicons-format-status', 40);
        // load the CSS for it
        add_action("load-{$mainPageHandle}", array($this, 'smsPagesAssets'));

        // Dashboard submenu
        $smsPageHandle = add_submenu_page('smsplugin', 'SMS', 'Dashboard', 'manage_options', 'smsplugin', array($this, 'mainPageAssets'));
        // load the CSS for it 
        add_action("load-{$smsPageHandle}", array($this, 'smsPagesAssets'));

        // SMS submenu
        $smsPageHandle = add_submenu_page('smsplugin', 'SMS', 'SMS', 'manage_options', 'sms_section', array($this, 'smsSectionHTML'));
        // load the CSS for it 
        add_action("load-{$smsPageHandle}", array($this, 'smsPagesAssets'));
    }



    // Indlude the admin page assets function
    function mainPageAssets()
    {
        //wp_enqueue_style('adminPageCSS', plugin_dir_url(__FILE__) . "/css/main-style.css");
    }

    // Indlude the submenu pages assets function
    function smsPagesAssets()
    {
        wp_enqueue_style('smsPageCSS', plugin_dir_url(__FILE__) . "/css/sms-otp-style.css");
    }

    // Include custom Admin section scrits ( AJAX for the menu)
    function enqueue_admin_scripts()
    {
        wp_enqueue_script('admin-ajax', plugin_dir_url(__FILE__) . "/js/admin-ajax.js", array(), '1.0', true);
    }

    // Include custom Page scripts
    function enqueue_custom_scripts()
    {
        // wp_enqueue_script('country_code_script', plugin_dir_url(__FILE__) . "/js/country-code.js", array(), '1.0', true);
        //wp_enqueue_script('otp_script', plugin_dir_url(__FILE__) . "/js/otp.js", array(), '1.0', true);
    }






    // Handle the options table update and display success or error messages
    function handleForm()
    {
        if (wp_verify_nonce($_POST['twilioDetailsNonce'], 'twilioDetailsFormSubmitNonce') and current_user_can('manage_options')) {
            update_option('twilio_sid', Encryption::encrypt(sanitize_text_field($_POST['twilio-sid'])));
            update_option('twilio_token', Encryption::encrypt(sanitize_text_field($_POST['twilio-token'])));

            if (isset($_POST['twilio-number'])) {
                update_option('twilio_number', Encryption::encrypt(sanitize_text_field($_POST['twilio-number'])));
            }
?>
            <div class="updated"> <!-- updated class provided by WP -->
                <p>Twilio account details were saved.</p>
            </div>
        <?php } else { ?>
            <div class="error"> <!-- updated class provided by WP -->
                <p>Sorry, you don't have permissions to perform this action.</p>
            </div>
        <?php } // end of if
    } // end of handleForm



    function handleWooForm()
    {
        if (wp_verify_nonce($_POST['twilioDetailsNonce'], 'twilioDetailsFormSubmitNonce') and current_user_can('manage_options')) {

            if (isset($_POST['woo_form_submit'])) {

                // Get the Woo client chekbox settings
                if (isset($_POST['woo_checkbox_client'])) {
                    update_option('woo_checkbox_client', sanitize_text_field($_POST['woo_checkbox_client']));
                } else {
                    update_option('woo_checkbox_client', '0');
                }

                // Get the Woo owner chekbox settings
                if (isset($_POST['woo_checkbox_owner'])) {
                    update_option('woo_checkbox_owner', sanitize_text_field($_POST['woo_checkbox_owner']));
                } else {
                    update_option('woo_checkbox_owner', '0');
                }

                update_option('order_status_client', sanitize_text_field($_POST['order_status_client']));
                update_option('order_status_owner', sanitize_text_field($_POST['order_status_owner']));

                if (isset($_POST['woo_textarea_client'])) {
                    update_option('woo_textarea_client', sanitize_text_field($_POST['woo_textarea_client']));
                }
                if (isset($_POST['woo_textarea_owner'])) {
                    update_option('woo_textarea_owner', sanitize_text_field($_POST['woo_textarea_owner']));
                }

                if (isset($_POST['owner_number'])) {
                    update_option('owner_number', sanitize_text_field($_POST['owner_number']));
                }
            }


        ?>
            <div class="updated"> <!-- updated class provided by WP -->
                <p>WooCommerce settings were saved.</p>
            </div>
        <?php } else { ?>
            <div class="error"> <!-- updated class provided by WP -->
                <p>Sorry, you don't have permissions to perform this action.</p>
            </div>
<?php } // end of if
    } // end of handleWooForm






    // *********************************** Main *********************************** //

    // adding admin page's HTML
    function mainPluginPageHTML()
    {
        require plugin_dir_path(__FILE__) . "/template-parts/dashboard.php";
    }



    // *********************************** SMS *********************************** //

    // adding SMS page HTML
    function smsSectionHTML()
    {
        require plugin_dir_path(__FILE__) . "/template-parts/smsSection.php";
    }



    // Handling the PHP for the test SMS sending
    function smsTestFormHandle()
    {

        if (wp_verify_nonce($_POST['testNonce'], 'testNonceSubmit') and current_user_can('manage_options')) {

            try {

                // Your Account SID and Auth Token from twilio.com/console
                // To set up environmental variables, see http://twil.io/secure
                $account_sid = Encryption::decrypt(get_option('twilio_sid'));
                $auth_token = Encryption::decrypt(get_option('twilio_token'));
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

                // A Twilio number you own with SMS capabilities
                $twilio_number = Encryption::decrypt(get_option('twilio_number'));
                $user_number = sanitize_text_field($_POST['user-number']);
                $sms_body = sanitize_text_field($_POST['test-sms-body']);

                $client = new Client($account_sid, $auth_token);
                $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    $user_number,
                    array(
                        'from' => $twilio_number,
                        'body' => $sms_body
                    )
                );
            } catch (Twilio\Exceptions\ConfigurationException $e) {
                // Error message for missing or incorrect Twilio credentials
                $response = "Twilio credentials are missing or incorrect. Please check your configuration.";
            } catch (Twilio\Exceptions\RestException $e) {
                // Custom error message for RestException
                $response = "Unable to send message. Please check the phone number and try again.";
            }

            if (isset($response)) {
                echo "<p>" . $response . "</p>";
            }
        } // end of if
    } // end of smsTestFormHandle()
} // end of class

$smsPlugin = new SMSplugin();
