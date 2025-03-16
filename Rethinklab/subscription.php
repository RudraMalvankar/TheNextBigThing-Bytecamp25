<?php
session_start();
require_once('db_config.php');
// require_once('vendor/autoload.php'); // Ensure Stripe library is loaded

\Stripe\Stripe::setApiKey(STRIPE_SECRET);

// ✅ Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Fetch user email securely
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT email FROM entries WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = filter_var($row['email'], FILTER_SANITIZE_EMAIL); // ✅ Sanitize email
} else {
    die("Error: User email not found.");
}
$stmt->close();

try {
    // ✅ Create Stripe Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => 'price_1R2SyBSBfXJhVNZFvKXI85ly', // ✅ Replace with actual Stripe Price ID
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'customer_email' => $email,
        'billing_address_collection' => 'required',
        'shipping_address_collection' => ['allowed_countries' => ['IN']],
        'subscription_data' => ['trial_period_days' => 7], // ✅ 7-day trial period
        'success_url' => 'http://localhost/bytecamp/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/bytecamp/cancel.php',
    ]);

    // ✅ Redirect to Stripe Checkout
    header("Location: " . $checkout_session->url);
    exit();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
