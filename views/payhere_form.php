<h1>Pay Invoice #<?php echo $invoice->id; ?></h1>
<form action="https://sandbox.payhere.lk/pay/checkout" method="POST">
    <input type="hidden" name="merchant_id" value="<?php echo get_option('payhere_merchant_id'); ?>">
    <input type="hidden" name="order_id" value="<?php echo $invoice->id; ?>">
    <input type="hidden" name="items" value="Invoice #<?php echo $invoice->id; ?>">
    <input type="hidden" name="amount" value="<?php echo $invoice->total; ?>">
    <input type="hidden" name="currency" value="<?php echo $invoice->currency_name; ?>">
    <input type="hidden" name="return_url" value="<?php echo site_url('payhere_gateway/success'); ?>">
    <input type="hidden" name="cancel_url" value="<?php echo site_url('payhere_gateway/cancel'); ?>">
    <input type="hidden" name="notify_url" value="<?php echo site_url('payhere_gateway/notify'); ?>">
    <button type="submit">Pay Now</button>
</form>
