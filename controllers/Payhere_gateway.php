<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payhere_gateway extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('payhere_gateway_lib');
    }

    public function pay($invoice_id)
    {
        $invoice = $this->invoices_model->get($invoice_id);
        if (!$invoice) {
            show_404();
        }

        $this->payhere_gateway_lib->process_payment($invoice);
    }

    public function success()
    {
        // Handle success
        set_alert('success', 'Payment successful!');
        redirect(site_url('clients/invoices'));
    }

    public function cancel()
    {
        // Handle cancellation
        set_alert('warning', 'Payment canceled.');
        redirect(site_url('clients/invoices'));
    }

    public function notify()
    {
        $response = $this->input->post();
        $this->payhere_gateway_lib->handle_notification($response);
    }
}
