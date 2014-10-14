<?php
$billingService = BOL_BillingService::getInstance();

$billingService->deleteConfig('latterdatebraintreebilling', 'business');
$billingService->deleteConfig('latterdatebraintreebilling', 'publicKey');
$billingService->deleteConfig('latterdatebraintreebilling', 'privateKey');
$billingService->deleteConfig('latterdatebraintreebilling', 'sandboxMode');

$billingService->deleteGateway('latterdatebraintreebilling');
