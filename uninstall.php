<?php
$billingService = BOL_BillingService::getInstance();

$billingService->deleteConfig('billingbraintree', 'business');
$billingService->deleteConfig('billingbraintree', 'publicKey');
$billingService->deleteConfig('billingbraintree', 'privateKey');
$billingService->deleteConfig('billingbraintree', 'sandboxMode');

$billingService->deleteGateway('billingbraintree');
