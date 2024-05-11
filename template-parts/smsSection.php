

<div class="container">

            <header>
                <h1>SMS Section<span> a product of <a href="https://www.rekinvest.com" target="blank">RekInvest</a></span></h1>
            </header>



            <div class="first-section">
                <div class="message-box">

                    <h2>Add your <span id="twilio-red"><a href="https://www.twilio.com/" target="_blank">Twilio</a></span> account details here</h2>

                    <form method="POST" id="twilio-details-form">

                        <?php if (isset($_POST['justsubmitted'])) $this->handleForm() ?>
                        <input type="hidden" name="justsubmitted" value="true">
                        <?php wp_nonce_field('twilioDetailsFormSubmitNonce', 'twilioDetailsNonce') ?>

                        <label for="sid" class="label">Account SID</label><br>
                        <input type="text" id="sid" name="twilio-sid" value="<?php echo Encryption::decrypt(esc_textarea(get_option('twilio_sid'))) ?>" class="input-field"><br>

                        <label for="token" class="label">Account Token</label><br>
                        <input type="text" id="token" name="twilio-token" value="<?php echo Encryption::decrypt(esc_textarea(get_option('twilio_token', ''))) ?>" class="input-field"><br>

                        <label for="twilio-number" class="label">My Twilio phone number</label><br>
                        <input type="text" id="number" name="twilio-number" value="<?php echo Encryption::decrypt(esc_textarea(get_option('twilio_number', ''))) ?>" class="input-field" placeholder="eg: +1 25472689"><br>

                        <button class="form-submit-btn">Save Changes</button>
                    </form>
                </div>





                <div class="message-box" id="test-section">
                    <h2>Test the service by sending an SMS</h2>
                    <p id="p-notification-red"></p>
                    <form method="POST">
                        <?php if (isset($_POST['smsTestFormSubmited'])) $this->smsTestFormHandle() ?>
                        <input type="hidden" name="smsTestFormSubmited" value="true">
                        <?php wp_nonce_field('testNonceSubmit', 'testNonce') ?>

                        <label for="user-number" class="label">The number to send SMS to</label><br>
                        <input name="user-number" type="text" class="input-field" placeholder="eg: +44 7326895" id="user-number"><br>

                        <label for="test-sms-body" class="label">SMS text with up to 159 characters</label><br>
                        <textarea name="test-sms-body" id="test-sms-body"></textarea><br>
                        <p id="test-sms-body-notification"></p>

                        <button class="form-submit-btn" type="submit">Send SMS</button>
                    </form>
                </div><!-- // end of message-box -->
            </div><!-- // end of twilio-banner -->
        </div><!-- // end of container -->


        <div class="container">
            <div class="message-box second-section">

                <div class="woo-forms">
                    <h2><b class="woo-b">WooCommerce</b> SMS notification</h2>
                    <p class="p-text">The plugin will send SMS confirmation to the client once an order is received. It can also, send SMS notification to the owner.</p>

                    <h3 class="client-h3"> Send yourself a notification on received order</h3>
                    <form method="POST">
                        <?php if (isset($_POST['woosubmitted'])) $this->handleWooForm() ?>
                        <input type="hidden" name="woosubmitted" value="true">
                        <?php wp_nonce_field('twilioDetailsFormSubmitNonce', 'twilioDetailsNonce') ?>


                        <div class="woo-checkbox" id="owner-section">
                            <label for="woo_checkbox_owner" class="label woo-labels">SMS notofication to the Shop Manager</label>
                            <input type="checkbox" name="woo_checkbox_owner" value="1" <?php checked(get_option('woo_checkbox_owner'), '1') ?> />

                            <p class="p-text inline">The confirmation should be send, when the order is
                                <select name="order_status_owner" class="inline">
                                    <?php if (get_option('order_status_owner')) {
                                        echo '<option value="' . get_option('order_status_owner') . '" selected=selected>' . get_option('order_status_owner') . '</option>';
                                    } ?>
                                    <option value="processing">processing</option>
                                    <option value="completed">completed</option>
                                    <option value="pending_payment">pending_payment</option>
                                    <option value="on-hold">on-hold</option>
                                    <option value="cancelled">cancelled</option>
                                </select>
                            </p>

                            <label for="owner-number" class="label">Shop manager's number</label><br>
                            <input name="owner_number" type="text" class="input-field" placeholder="eg: +444726895" id="owner-number" value="<?php echo esc_textarea(get_option('owner_number', '')) ?>">

                            <br>

                            <label for="woo_textarea_owner" class="p-text">What should the message say</label><br>
                            <textarea name="woo_textarea_owner" id="woo_textarea_owner">
                                <?php echo esc_textarea(get_option('woo_textarea_owner')) ?>
                            </textarea>
                            <p id="woo_textarea_owner-notification"></p>
                        </div>


                        <hr>



                        <div class="woo-checkbox" id="client-section">

                            <h3 class="client-h3">SMS notifications to clients are only sent from a paid Twilio account. Do not activate if you have a trail account.</h3 id="client-h3">
                            <label for="woo_checkbox_client" class="label woo-labels">SMS confirmation for the client</label>
                            <input type="checkbox" name="woo_checkbox_client" value="1" <?php checked(get_option('woo_checkbox_client'), '1') ?> />

                            <p class="p-text inline">The confirmation should be send, when the order is
                                <select name="order_status_client" class="inline">
                                    <?php if (get_option('order_status_client')) {
                                        echo '<option value="' . get_option('order_status_client') . '" selected=selected>' . get_option('order_status_client') . '</option>';
                                    } ?>
                                    <option value="processing">processing</option>
                                    <option value="completed">completed</option>
                                    <option value="pending_payment">pending_payment</option>
                                    <option value="on-hold">on-hold</option>
                                    <option value="cancelled">cancelled</option>
                                </select>
                            </p>

                            <label for="woo_textarea_client" class="p-text">What should the message say</label><br>
                            <textarea name="woo_textarea_client" id="woo_textarea_client">
                                <?php echo esc_textarea(get_option('woo_textarea_client')) ?>
                            </textarea>
                            <p id="woo_textarea_client-notification"></p>

                        </div> 
                        <br>


                        <button class="form-submit-btn" type="submit" name="woo_form_submit">Save Changes</button>
                    </form>
                </div><!-- // end of woo-forms -->



                <div class="woo-text">
                    <p class="p-text">An order also has a Status. Order statuses let you know how far along the order is, starting with “Pending payment” and ending with “Completed.” The following order statuses are used:</p>

                    <p class="p-text"><b>* Processing</b> — Payment received (paid) and stock has been reduced; order is awaiting fulfillment. All product orders require processing, except those that only contain products which are both Virtual and Downloadable.</p>

                    <p class="p-text"><b>* Pending payment</b> — Order received, no payment initiated. Awaiting payment (unpaid).</p>

                    <p class="p-text"><b>* Completed</b> — Order fulfilled and complete – requires no further action.</p>

                    <p class="p-text"><b>* On hold</b> — Awaiting payment – stock is reduced, but you need to confirm payment.</p>

                    <p class="p-text"><b>* Cancelled</b> — Cancelled by an admin or the customer – stock is increased, no further action required.
                        Please note: This status does not refund the customer.</p>

                </div>
            </div><!-- // end of message-box second-section-->
        </div><!-- // end of container -->