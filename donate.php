<?php
// PayPal's payment notice (IPN) for donations. PayPal posts here from its own
// servers, so there is no logged-in player: the player comes from the signed
// "custom" code the Donate button sent (see lib/donations.php).
require_once "config.php";

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: index.php');
    exit();
}

$mmsgResult = handle_paypal_ipn($link, (string) file_get_contents('php://input'), $_POST);
if (!in_array($mmsgResult, ['credited', 'credited-guest', 'refunded', 'duplicate', 'ignored-status'], true)) {
    error_log('MMsGaming: PayPal notice ' . $mmsgResult . ' (txn ' . substr((string) ($_POST['txn_id'] ?? ''), 0, 64) . ')');
}
// Always answer 200 so PayPal doesn't keep re-sending; the result is logged.
header('Content-Type: text/plain');
echo $mmsgResult;
