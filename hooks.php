<?php
defined('BASEPATH') or exit('No direct script access allowed');


// Register the activation hook
register_activation_hook('payhere_gateway', 'payhere_gateway_activation');

function payhere_gateway_activation()
{
    add_option('payhere_merchant_id', '');
    add_option('payhere_secret_key', '');
    add_option('payhere_environment', 'sandbox'); // Default to sandbox
}

// Register the deactivation hook
register_deactivation_hook('payhere_gateway', 'payhere_gateway_deactivation');

function payhere_gateway_deactivation()
{
    delete_option('payhere_merchant_id');
    delete_option('payhere_secret_key');
    delete_option('payhere_environment');
}

// Register the payment gateway
hooks()->add_action('app_init', 'register_payhere_gateway');

function register_payhere_gateway()
{
    $CI = &get_instance();
    $CI->load->library('app_payment_gateways');
    $CI->app_payment_gateways->add_gateway('payhere_gateway');
}
