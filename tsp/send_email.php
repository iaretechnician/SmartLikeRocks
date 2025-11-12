<?php
// TSP lost receipt handler with optional SMTP support.
// If a file `tsp/smtp_config.php` exists (returning an array with smtp settings),
// the script will attempt to send via SMTP. Otherwise it falls back to mail().

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

function get_post($k) {
    return isset($_POST[$k]) ? trim($_POST[$k]) : '';
}

$recipient_raw = get_post('recipient_email');
$cc_raw = get_post('cc_emails');
$sender = get_post('sender_email');
$subject = get_post('subject') ?: 'Lost Receipt Request';
$expense_date = get_post('expense_date');
$expense_type = get_post('expense_type');
$amount = get_post('amount');
$business_name = get_post('business_name');
$business_location = get_post('business_location');
$contract_number = get_post('contract_number');
$ticket_number = get_post('ticket_number');

if (!$recipient_raw || !$sender) {
    http_response_code(400);
    echo 'Recipient and sender email are required.';
    exit;
}

$recipients = array_filter(array_map('trim', explode(',', $recipient_raw)));
$valid_recipients = [];
foreach ($recipients as $r) {
    if (filter_var($r, FILTER_VALIDATE_EMAIL)) {
        $valid_recipients[] = $r;
    }
}

if (empty($valid_recipients)) {
    http_response_code(400);
    echo 'No valid recipient email addresses provided.';
    exit;
}

if (!filter_var($sender, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Sender email is not valid.';
    exit;
}

$to = array_shift($valid_recipients);
$cc = $valid_recipients ? implode(',', $valid_recipients) : '';

$body = "Lost Receipt Request\n\n";
$body .= "Submitted: " . date('Y-m-d H:i:s') . "\n";
$body .= "Sender: $sender\n";
$body .= "Recipients: $recipient_raw\n";
$body .= "Expense Date: $expense_date\n";
$body .= "Expense Type: $expense_type\n";
$body .= "Amount: $amount\n";
$body .= "Business Name: $business_name\n";
$body .= "Business Location: $business_location\n";
$body .= "Contract #: $contract_number\n";
$body .= "Ticket #: $ticket_number\n";

// Try SMTP if config exists
$smtpConfigPath = __DIR__ . '/smtp_config.php';
if (file_exists($smtpConfigPath)) {
    $smtp = include $smtpConfigPath; // expects array with keys: host, port, username, password, encryption (tls|ssl|null), from_email, from_name
    if (is_array($smtp)) {
        $sent = false;
        // minimal SMTP client using fsockopen + optional STARTTLS
        $host = $smtp['host'] ?? '';
        $port = $smtp['port'] ?? 587;
        $user = $smtp['username'] ?? '';
        $pass = $smtp['password'] ?? '';
        $enc = $smtp['encryption'] ?? 'tls';
        $from = $smtp['from_email'] ?? $sender;
        $fromName = $smtp['from_name'] ?? '';

        // Open socket
        $remote = ($enc === 'ssl') ? 'ssl://' . $host : $host;
        $fp = @stream_socket_client($remote . ':' . $port, $errno, $errstr, 20);
        if ($fp) {
            stream_set_timeout($fp, 20);
            $res = fgets($fp, 515);

            $send = function($cmd) use ($fp) {
                fwrite($fp, $cmd . "\r\n");
                return fgets($fp, 515);
            };

            $send("EHLO " . gethostname());
            if ($enc === 'tls') {
                $send("STARTTLS");
                stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                $send("EHLO " . gethostname());
            }
            if ($user) {
                $send("AUTH LOGIN");
                $send(base64_encode($user));
                $send(base64_encode($pass));
            }

            $send("MAIL FROM:<" . $from . ">");
            $send("RCPT TO:<" . $to . ">");
            if ($cc) {
                foreach (explode(',', $cc) as $ccaddr) {
                    $ccaddr = trim($ccaddr);
                    if ($ccaddr) $send("RCPT TO:<" . $ccaddr . ">");
                }
            }

            $send("DATA");
            $headers = [];
            $headers[] = 'From: ' . ($fromName ? "$fromName <$from>" : $from);
            $headers[] = 'To: ' . $to;
            if ($cc) $headers[] = 'Cc: ' . $cc;
            $headers[] = 'Subject: ' . $subject;
            $headers[] = 'Date: ' . date('r');
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-Type: text/plain; charset=utf-8';

            $data = implode("\r\n", $headers) . "\r\n\r\n" . $body . "\r\n.";
            $send($data);
            $last = fgets($fp, 515);
            $send("QUIT");
            fclose($fp);
            if (strpos($last, '250') !== false || strpos($last, '354') !== false) {
                $sent = true;
            }
        }

        if ($sent) {
            echo 'Lost receipt request submitted successfully.';
            exit;
        }
        // else fall through to mail() fallback
    }
}

// Fallback to mail()
$headers = [];
$headers[] = 'From: ' . $sender;
if ($cc) {
    $headers[] = 'Cc: ' . $cc;
}
$headers[] = 'Content-Type: text/plain; charset=utf-8';

$ok = @mail($to, $subject, $body, implode("\r\n", $headers));

if ($ok) {
    echo 'Lost receipt request submitted successfully.';
} else {
    http_response_code(500);
    echo 'Failed to send email. Please contact an administrator.';
}

?>
