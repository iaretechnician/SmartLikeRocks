<?php
// Set content type to plain text for simple responses to AJAX
header('Content-Type: text/plain');

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Sanitize and Validate Inputs ---
    // Using filter_var for basic email validation and sanitization
    $recipient_email = filter_var($_POST['recipient_email'] ?? '', FILTER_SANITIZE_EMAIL);
    $cc_emails       = filter_var($_POST['cc_emails'] ?? '', FILTER_SANITIZE_EMAIL);
    $sender_email    = filter_var($_POST['sender_email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject         = htmlspecialchars($_POST['subject'] ?? ''); // Sanitize subject
    $expense_date    = htmlspecialchars($_POST['expense_date'] ?? '');
    $expense_type    = htmlspecialchars($_POST['expense_type'] ?? '');
    $amount          = filter_var($_POST['amount'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Sanitize amount
    $business_name   = htmlspecialchars($_POST['business_name'] ?? '');
    $business_location = htmlspecialchars($_POST['business_location'] ?? '');
    $contract_number = htmlspecialchars($_POST['contract_number'] ?? '');
    $ticket_number   = htmlspecialchars($_POST['ticket_number'] ?? '');

    // Basic validation (more robust validation might be needed for production)
    if (empty($recipient_email) || !filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        die("Error: Recipient email is required and must be valid.");
    }
    if (empty($sender_email) || !filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        die("Error: Sender email is required and must be valid.");
    }
    if (empty($subject) || empty($expense_date) || empty($expense_type) || empty($amount) || empty($business_name) || empty($business_location)) {
        http_response_code(400); // Bad Request
        die("Error: All required expense details (Date, Type, Amount, Business Name, Location) and Subject are mandatory.");
    }

    // --- Construct Email Body ---
    $email_body .= "----------------------------------------\n";
    $email_body .= "Date: " . $expense_date . "\n";
    $email_body .= "Expense Type: " . $expense_type . "\n";
    $email_body .= "Amount: $" . number_format((float)$amount, 2) . "\n"; // Format amount to 2 decimal places
    $email_body .= "Business Name: " . $business_name . "\n";
    $email_body .= "Business Location: " . $business_location . "\n";

    if (!empty($contract_number)) {
        $email_body .= "Contract #: " . $contract_number . "\n";
    }
    if (!empty($ticket_number)) {
        $email_body .= "Ticket #: " . $ticket_number . "\n";
    }
    $email_body .= "----------------------------------------\n\n";
    $email_body .= "Thank you.\n";

    // --- Construct Email Headers ---
    $headers = "From: " . $sender_email . "\r\n";
    $headers .= "Reply-To: " . $sender_email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Add CC recipients if provided
    if (!empty($cc_emails)) {
        // Split CC emails by comma and trim whitespace, then filter valid emails
        $cc_array = array_map('trim', explode(',', $cc_emails));
        $valid_cc_emails = [];
        foreach ($cc_array as $cc_email) {
            if (filter_var($cc_email, FILTER_VALIDATE_EMAIL)) {
                $valid_cc_emails[] = $cc_email;
            }
        }
        if (!empty($valid_cc_emails)) {
            $headers .= "Cc: " . implode(', ', $valid_cc_emails) . "\r\n";
        }
    }

    // --- Send Email ---
    // The mail() function returns true on success, false on failure.
    // However, it does not indicate if the email was actually delivered,
    // only if it was successfully handed over to the local mail server.
    if (mail($recipient_email, $subject, $email_body, $headers)) {
        http_response_code(200); // OK
        echo "Email sent successfully!";
    } else {
        http_response_code(500); // Internal Server Error
        // You might want to log the error for debugging purposes
        error_log("Failed to send email to " . $recipient_email . " from " . $sender_email);
        echo "Failed to send email. Please try again later.";
    }

} else {
    // If accessed directly without POST request
    http_response_code(405); // Method Not Allowed
    echo "This script only accepts POST requests.";
}
?>
