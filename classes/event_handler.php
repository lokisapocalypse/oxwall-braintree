<?php

class BILLINGBRAINTREE_CLASS_EventHandler
{
    private static $instance;

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {}

    public function addAdminNotification(BASE_CLASS_EventCollector $coll)
    {
        // get the billing service to make sure the variables are set
        $billingService = BOL_BillingService::getInstance();
        $gatewayKey = BILLINGBRAINTREE_CLASS_BraintreeAdapter::GATEWAY_KEY;

        // grab all the variables
        $business = $billingService->getGatewayConfigValue($gatewayKey, 'business');
        $publicKey = $billingService->getGatewayConfigValue($gatewayKey, 'publicKey');
        $privateKey = $billingService->getGatewayConfigValue($gatewayKey, 'privateKey');

        // if any of them are missing, alert the village
        if (empty($business) || empty($publicKey) || empty($privateKey)) {
            $coll->add(
                OW::getLanguage()->text(
                    'billingbraintree',
                    'plugin_configuration_notice',
                    array('url' => OW::getRouter()->urlForRoute('braintree_billing_admin'))
                )
            );
        }
    }

    public function addAccessException(BASE_CLASS_EventCollector $e)
    {
        $e->add(array('controller' => 'BILLINGBRAINTREE_CTRL_Order', 'action' => 'postback'));
    }

    public function init()
    {
        $em = OW::getEventManager();

        $em->bind('admin.add_admin_notification', array($this, 'addAdminNotification'));
        $em->bind('base.members_only_exceptions', array($this, 'addAccessException'));
        $em->bind('base.password_protected_exceptions', array($this, 'addAccessException'));
        $em->bind('base.splash_screen_exceptions', array($this, 'addAccessException'));
    }
}
