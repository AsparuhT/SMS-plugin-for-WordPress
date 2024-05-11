




        <div class="container">

            <header>
                <h1>SMS Plugin<span> by <a href="https://www.rekinvest.com" target="blank">RekInvest</a></span></h1>

                <div class="message-box" id="top-banner">
                    <div class="header-banner__img">
                        <img src="<?php echo plugin_dir_url(__FILE__). '/images/icons8-sms-64.png'?>" alt="Phonne image" id="phone-img">
                    </div>
                    <div class="header-banner__text">
                    Allow your WordPress website to send SMS messages on events such as order submissions, or verify the phone number of a client.
                    </div>
                </div>
            </header>


            <h3>Important Information</h3>
            <div class="twilio-banner message-box">
                <div class="twilio-banner__img">
                    <img src="<?php echo plugin_dir_url(__FILE__). '/images/twilio-logo.png'?>" alt="Twilio logo" id="twilio-img">
                </div>
                <div class="twilio-banner__text" id="wilio-banner__text">
                    This plugin works with a <b>Twilio account</b>, which you can create for <b>free</b> and trail the service. It takes just a minute to register <b><a href="https://www.twilio.com/" target="_blank">here</a></b>. Add your Twilio account details in the plugin's' SMS or OTP sections and get mobile! Let's go and send your first SMS. Yay!
                </div>
                <div class="twilio-banner__btn">
                    <div id="call-to-action-div">
                        <button id="call-to-action-btn"><a href="https://www.twilio.com/" target="_blank" class="a-btn">Create Account</a></button>
                    </div>
                </div>
            </div>



            <main>
                <div class="main-col message-box">
                    <h2>SMS</h2>
                    Enchance the <b class="woo-b">WooCommerce</b> experience of your <b>clients</b> and <b>yourself</b>, by sending SMS confirmations and notofications of received orders.
                    <br>
                    <button class="main-col-btn"><a href="<?php echo admin_url('admin.php?page=sms_section'); ?>" class="a-btn">SMS Section</a></button>
                </div>
            </main>



        </div><!-- end of container -->

