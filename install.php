<?php

$billingService = BOL_BillingService::getInstance();

$gateway = new BOL_BillingGateway();
$gateway->gatewayKey = 'latterdatebraintreebilling';
$gateway->adapterClassName = 'latterdatebraintreebilling_CLASS_PaypalAdapter';
$gateway->active = 0;
$gateway->mobile = 0;
$gateway->recurring = 1;
$gateway->currencies = 'AUD,BRL,CAD,CZK,DKK,EUR,HKD,HUF,ILS,JPY,MYR,MXN,NOK,NZD,PHP,PLN,GBP,SGD,SEK,CHF,TWD,THB,USD';

$billingService->addGateway($gateway);
$billingService->addConfig('latterdatebraintreebilling', 'business', '');
$billingService->addConfig('latterdatebraintreebilling', 'publicKey', '');
$billingService->addConfig('latterdatebraintreebilling', 'privateKey', '');
$billingService->addConfig('latterdatebraintreebilling', 'sandboxMode', '0');

OW::getPluginManager()->addPluginSettingsRouteName('latterdatebraintreebilling', 'braintree_billing_admin');

$path = OW::getPluginManager()->getPlugin('latterdatebraintreebilling')->getRootDir() . 'langs.zip';
OW::getLanguage()->importPluginLangs($path, 'latterdatebraintreebilling');

BOL_LanguageService::getInstance()->addPrefix('latterdatebraintreebilling', 'Braintree Billing');
