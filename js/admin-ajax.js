

if (document.getElementById('woo_textarea_owner')) {

    // Remove the white space from the textarea
    const textareaOwnerTrim = document.getElementById('woo_textarea_owner');
    textareaOwnerTrim.value = textareaOwnerTrim.value.trim();
    const textareaClientTrim = document.getElementById('woo_textarea_client');
    textareaClientTrim.value = textareaClientTrim.value.trim();

    // Get the textarea elements and character count notification elements
    const textareaOwner = document.getElementById("woo_textarea_owner");
    const notificationOwner = document.getElementById("woo_textarea_owner-notification");
    const textareaClient = document.getElementById("woo_textarea_client");
    const notificationClient = document.getElementById("woo_textarea_client-notification");
    const textareaSMS = document.getElementById("test-sms-body");
    const notificationSMS = document.getElementById("test-sms-body-notification");

    // Function to update character count and display notifications
    function updateCharacterCount(textarea, notification, maxLength) {
        // Get the current input value
        const inputValue = textarea.value;

        // Check if the input exceeds the maximum limit
        if (inputValue.length > maxLength) {
            // Trim the input to the maximum limit
            let trimmedValue = inputValue.substring(0, maxLength);
            // Update the textarea value with the trimmed value
            textarea.value = trimmedValue;
            // Show warning message
            notification.textContent = "Warning: Character limit exceeded!";
            notification.style.color = "red";
        } else {
            // Update character count
            notification.textContent = "Characters added: " + inputValue.length;
            notification.style.color = "black";
        }
    }

    // Add input event listeners to monitor user input for each textarea
    textareaOwner.addEventListener("input", function () {
        updateCharacterCount(textareaOwner, notificationOwner, 159);
    });

    textareaClient.addEventListener("input", function () {
        updateCharacterCount(textareaClient, notificationClient, 159);
    });

    textareaSMS.addEventListener("input", function () {
        updateCharacterCount(textareaSMS, notificationSMS, 159);
    });








} // end of if