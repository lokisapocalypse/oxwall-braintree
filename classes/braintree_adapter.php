<?php

class BILLINGBRAINTREE_CLASS_BraintreeAdapter implements OW_BillingAdapter
{
    const GATEWAY_KEY = 'billingbraintree';

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

    public function prepareSale(BOL_BillingSale $sale)
    {
        throw new Exception('Not yet implemented');
    }

    public function verifySale(BOL_BillingSale $sale)
    {
        throw new Exception('Not yet implemented');
    }
}
