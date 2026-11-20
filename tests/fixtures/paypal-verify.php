<?php
// Stand-in for PayPal's notice check, used only by the automated tests
// (MMSG_PAYPAL_VERIFY_URL). A notice containing test_forged=1 is treated as
// not genuine. tests/ returns 404 on the live site.
header('Content-Type: text/plain');
$body = (string) file_get_contents('php://input');
echo (strpos($body, 'cmd=_notify-validate&') === 0 && strpos($body, 'test_forged=1') === false) ? 'VERIFIED' : 'INVALID';
