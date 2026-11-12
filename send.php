<?php
/**
 * Form handler for the static Fearless Tattoo Removal site.
 * Handles:
 *   - the booking form on /contact/ (WPForms)  -> success goes to the Thank You page
 *   - the newsletter email signup in the footer of every page (Elementor)
 * Replaces WordPress form processing. Uses PHP mail().
 */

$to       = 'fearlessremoval@gmail.com';
$fromAddr = 'no-reply@fearlesstattooremoval.com';

$allowedReturns = ['inclusion-statement/', './', 'mission-statement/', 'privacy-policy/', 'thank-you/', 'site-map/', 'how-it-works/', 'full-body-tattoo-removal/', 'services/', 'contact/', 'about/', 'secondchances/', 'pricing/', 'permanent-makeup-removal/', 'services/cosmetic-tattoo-removal/', 'blog/'];
$return = in_array($_POST['_return'] ?? '', $allowedReturns, true) ? $_POST['_return'] : './';
function back($return, $ok) { header('Location: ' . $return . '?sent=' . ($ok ? '1' : '0')); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ./'); exit; }

// Spam traps: our hidden honeypot, and WPForms' own hidden field 2 (real visitors never fill either).
$wp = $_POST['wpforms']['fields'] ?? null;
if (!empty($_POST['website_url']) || (is_array($wp) && trim((string)($wp[2] ?? '')) !== '')) {
    header('Location: ' . (is_array($wp) ? 'thank-you/' : $return . '?sent=1')); exit;
}

function clean_line($v) { return trim(str_replace(["\r", "\n", "%0a", "%0d"], ' ', (string)$v)); }

$headers  = "From: Fearless Tattoo Removal Website <{$fromAddr}>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (is_array($wp)) {
    // Booking form (/contact/)
    $name    = clean_line($wp[3] ?? '');
    $phone   = clean_line($wp[4] ?? '');
    $email   = clean_line($wp[1] ?? '');
    $message = trim((string)($wp[5] ?? ''));
    if ($name === '' || $phone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') back($return, false);

    $body  = "New booking request from the website\n\n";
    $body .= "Name: {$name}\nPhone: {$phone}\nEmail: {$email}\n\nMessage:\n{$message}\n";
    $body .= "\n--\nSent from fearlesstattooremoval.com (Book With Us page)";
    $headers .= "Reply-To: {$name} <{$email}>\r\n";

    $ok = mail($to, 'Booking request from ' . $name, $body, $headers, '-f' . $fromAddr);
    if ($ok) { header('Location: thank-you/'); exit; }
    back($return, false);
}

// Newsletter signup (email only)
$email = clean_line($_POST['form_fields']['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) back($return, false);
$page = $return === './' ? 'Home' : rtrim($return, '/');
$body  = "New newsletter signup\n\nEmail: {$email}\nSigned up on: {$page} page\n";
$body .= "\n--\nSent from fearlesstattooremoval.com";
$headers .= "Reply-To: {$email}\r\n";
$ok = mail($to, 'Newsletter signup: ' . $email, $body, $headers, '-f' . $fromAddr);
back($return, $ok);
