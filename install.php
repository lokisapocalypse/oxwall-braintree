<?php

$billingService = BOL_BillingService::getInstance();

$gateway = new BOL_BillingGateway();
$gateway->gatewayKey = 'billingbraintree';
$gateway->adapterClassName = 'billingbraintree_CLASS_PaypalAdapter';
$gateway->active = 0;
$gateway->mobile = 0;
$gateway->recurring = 1;
$gateway->currencies = 'AUD,BRL,CAD,CZK,DKK,EUR,HKD,HUF,ILS,JPY,MYR,MXN,NOK,NZD,PHP,PLN,GBP,SGD,SEK,CHF,TWD,THB,USD';

$billingService->addGateway($gateway);
$billingService->addConfig('billingbraintree', 'business', '');
$billingService->addConfig('billingbraintree', 'publicKey', '');
$billingService->addConfig('billingbraintree', 'privateKey', '');
$billingService->addConfig('billingbraintree', 'sandboxMode', '0');

OW::getPluginManager()->addPluginSettingsRouteName('billingbraintree', 'braintree_billing_admin');

$path = OW::getPluginManager()->getPlugin('billingbraintree')->getRootDir() . 'langs.zip';
OW::getLanguage()->importPluginLangs($path, 'billingbraintree');

BOL_LanguageService::getInstance()->addPrefix('billingbraintree', 'Braintree Billing');
