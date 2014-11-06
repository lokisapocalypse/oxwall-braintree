<?php

require_once('ow_plugins/billing_braintree/vendor/autoload.php');

class BILLINGBRAINTREE_CLASS_BraintreeAdapter implements OW_BillingAdapter
{
    const GATEWAY_KEY = 'billingbraintree';

    public function __construct(BOL_BillingService $billingService)
    {
        $isSandbox = $billingService->getGatewayConfigValue(self::GATEWAY_KEY, 'sandboxMode');
        \Braintree_Configuration::environment($isSandbox ? 'sandbox' : 'sandbox');
        \Braintree_Configuration::merchantId($billingService->getGatewayConfigValue(self::GATEWAY_KEY, 'business'));
        \Braintree_Configuration::publicKey($billingService->getGatewayConfigValue(self::GATEWAY_KEY, 'publicKey'));
        \Braintree_Configuration::privateKey($billingService->getGatewayConfigValue(self::GATEWAY_KEY, 'privateKey'));
    }

    public function getFields($params = NULL)
    {
        throw new Exception('Not yet implemented');
    }

    public function getLogoUrl()
    {
        $plugin = OW::getPluginManager()->getPlugin('billingbraintree');
        return $plugin->getStaticUrl() . 'img/braintree.png';
    }

    public function getOrderFormUrl()
    {
        return OW::getRouter()->urlForRoute('billing_braintree_order_form');
    }

    public function plans()
    {
        return \Braintree_Plan::all();
    }

    public function prepareSale(BOL_BillingSale $sale)
    {
        throw new Exception('Not yet implemented');
    }

    public function verifySale(BOL_BillingSale $sale)
    {
        throw new Exception('Not yet implemented');
    }
}
