<?php
session_start();
require 'db_config.php';
// require 'vendor/autoload.php'; // Ensure Stripe SDK is loaded

\Stripe\Stripe::setApiKey(STRIPE_SECRET);

// ✅ Check if session ID is set
if (!isset($_GET['session_id'])) {
    header("Location: questions.php");
    exit();
}

$session_id = $_GET['session_id'];

try {
    // ✅ Retrieve Stripe session
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    $subscription_id = $session->subscription;
    $email = $session->customer_email;
    $amount_paid = $session->amount_total / 100; // Convert cents to actual currency

    // ✅ Get the username from the session
    if (!isset($_SESSION['username'])) {
        die("Error: No active session. Please log in.");
    }

    $username = $_SESSION['username'];

    // ✅ Get user_id from username
    $stmt = $conn->prepare("SELECT id FROM entries WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("Error: User not found.");
    }

    $row = $result->fetch_assoc();
    $user_id = $row['id'];
    $stmt->close();

    // ✅ Store Subscription Data in Database
    $sql = "INSERT INTO subscriptions (user_id, stripe_subscription_id, amount_paid, status, created_at) 
            VALUES (?, ?, ?, 'active', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $subscription_id, $amount_paid);
    
    if ($stmt->execute()) {
        // ✅ Redirect to questions page after payment
        header("Location: questions.php");
        exit();
    } else {
        die("Database Error: " . $stmt->error);
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
