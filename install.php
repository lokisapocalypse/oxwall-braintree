<?php

// load the billing service
$billingService = BOL_BillingService::getInstance();

// build a new gateway
$gateway = new BOL_BillingGateway();
$gateway->gatewayKey = 'billingbraintree';
$gateway->adapterClassName = 'BILLINGBRAINTREE_CLASS_BraintreeAdapter';
$gateway->active = 0;
$gateway->mobile = 0;
$gateway->recurring = 1;
$gateway->currencies = 'USD';

// add the gateway to the billing service
$billingService->addGateway($gateway);

// set some defaults for this gateway
$billingService->addConfig('billingbraintree', 'business', '');
$billingService->addConfig('billingbraintree', 'publicKey', '');
$billingService->addConfig('billingbraintree', 'privateKey', '');
$billingService->addConfig('billingbraintree', 'sandboxMode', '0');

// define the admin settings page
OW::getPluginManager()->addPluginSettingsRouteName('billingbraintree', 'braintree_billing_admin');

// load the language keys
$path = OW::getPluginManager()->getPlugin('billingbraintree')->getRootDir() . 'langs.zip';
OW::getLanguage()->importPluginLangs($path, 'billingbraintree');
