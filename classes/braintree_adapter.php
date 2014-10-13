<?php

class LATTERDATEBRAINTREEBILLING_CLASS_BraintreeAdapter implements OW_BillingAdapter
{
    const GATEWAY_KEY = 'latterdatebraintreebilling';

/*
        \Braintree_Configuration::environment('sandbox');
        \Braintree_Configuration::merchantId('m6z63mr4rq78t2cw');
        \Braintree_Configuration::publicKey('jqk3mmxn376st37c');
        \Braintree_Configuration::privateKey('0bc6bbfa014b8371da7e873189a3b43a');
*/
    public function getLogoUrl()
    {
        $plugin = OW::getPluginManager()->getPlugin('latterdatebraintreebilling');
        return $plugin->getStaticUrl() . 'img/braintree.png';
    }
}
