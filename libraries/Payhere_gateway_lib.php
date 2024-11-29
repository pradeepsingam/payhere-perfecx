<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payhere_gateway_lib
{
    public function process_payment($invoice)
    {
        $merchant_id = get_option('payhere_merchant_id');
        $secret_key = get_option('payhere_secret_key');
        $environment = get_option('payhere_environment');
        $endpoint = $environment === 'sandbox' ? 'https://sandbox.payhere.lk/pay/checkout' : 'https://www.payhere.lk/pay/checkout';

        $data = [
            'merchant_id' => $merchant_id,
            'order_id'    => $invoice->id,
            'items'       => 'Invoice #' . $invoice->id,
            'amount'      => $invoice->total,
            'currency'    => $invoice->currency_name,
            'return_url'  => site_url('payhere_gateway/success'),
            'cancel_url'  => site_url('payhere_gateway/cancel'),
            'notify_url'  => site_url('payhere_gateway/notify'),
        ];

        echo '<form id="payhereForm" action="' . $endpoint . '" method="post">';
        foreach ($data as $key => $value) {
            echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("payhereForm").submit();</script>';
    }

    public function handle_notification($response)
    {
        $order_id = $response['order_id'];
        $status = $response['status_code'];

        if ($status == '2') { // Payment success
            $this->mark_invoice_as_paid($order_id);
        }
    }

    private function mark_invoice_as_paid($invoice_id)
    {
        $CI = &get_instance();
        $CI->db->where('id', $invoice_id);
        $CI->db->update('tblinvoices', ['status' => 2]); // Mark as paid
    }
}
