<?php
require 'db_config.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET);

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$endpoint_secret = STRIPE_WEBHOOK_SECRET;

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

    if ($event->type == "invoice.payment_succeeded") {
        $invoice = $event->data->object;
        $subscription_id = $invoice->subscription;

        // Get user_id based on subscription
        $stmt = $conn->prepare("SELECT user_id FROM subscriptions WHERE stripe_subscription_id = ?");
        $stmt->bind_param("s", $subscription_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $subscription = $result->fetch_assoc();
        $user_id = $subscription['user_id'];

        if ($user_id) {
            // Update subscription status and redirect user
            $stmt = $conn->prepare("UPDATE subscriptions SET status = 'active' WHERE stripe_subscription_id = ?");
            $stmt->bind_param("s", $subscription_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    if ($event->type == "customer.subscription.deleted") {
        $subscription = $event->data->object;
        $subscription_id = $subscription->id;

        // Mark subscription as canceled
        $stmt = $conn->prepare("UPDATE subscriptions SET status = 'canceled' WHERE stripe_subscription_id = ?");
        $stmt->bind_param("s", $subscription_id);
        $stmt->execute();
        $stmt->close();
    }

    http_response_code(200);
} catch (Exception $e) {
    http_response_code(400);
    error_log("Webhook error: " . $e->getMessage());
}
?>
