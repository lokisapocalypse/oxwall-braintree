<?php

class BILLINGBRAINTREE_CTRL_Admin extends ADMIN_CTRL_Abstract
{
    public function index()
    {
        // get the billing service
        $billingService = BOL_BillingService::getInstance();
        $language = OW::getLanguage();

        // get the configuration form
        $braintreeConfigForm = new BraintreeConfigForm();
        $this->addForm($braintreeConfigForm);

        // if we are making changes to the configuration form
        if (OW::getRequest()->isPost() && $braintreeConfigForm->isValid($_POST)) {
            $result = $braintreeConfigForm->process();
            OW::getFeedback()->info($language->text('billingbraintree', 'settings_updated'));
            $this->redirect();
        }

        $adapter = new BILLINGBRAINTREE_CLASS_BraintreeAdapter();
        $this->assign('logoUrl', $adapter->getLogoUrl());

        $gateway = $billingService->findGatewayByKey(BILLINGBRAINTREE_CLASS_BraintreeAdapter::GATEWAY_KEY);
        $this->assign('gateway', $gateway);

        $this->assign('activeCurrency', $billingService->getActiveCurrency());

        $supported = $billingService->currencyIsSupported($gateway->currencies);
        $this->assign('currSupported', $supported);

        $this->setPageHeading(OW::getLanguage()->text('billingbraintree', 'config_page_heading'));
        $this->setPageHeadingIconClass('ow_ic_app');
    }
}

class BraintreeConfigForm extends Form
{
    public function __construct()
    {
        parent::__construct('braintree-config-form');

        $language = OW::getLanguage();
        $billingService = BOL_BillingService::getInstance();
        $gwKey = BILLINGBRAINTREE_CLASS_BraintreeAdapter::GATEWAY_KEY;

        $business = new TextField('business');
        $business->setValue($billingService->getGatewayConfigValue($gwKey, 'business'));
        $this->addElement($business);

        $publicKey = new TextField('publicKey');
        $publicKey->setValue($billingService->getGatewayConfigValue($gwKey, 'publicKey'));
        $this->addElement($publicKey);

        $privateKey = new TextField('privateKey');
        $privateKey->setValue($billingService->getGatewayConfigValue($gwKey, 'privateKey'));
        $this->addElement($privateKey);

        $sandboxMode = new CheckboxField('sandboxMode');
        $sandboxMode->setValue($billingService->getGatewayConfigValue($gwKey, 'sandboxMode'));
        $this->addElement($sandboxMode);

        // submit
        $submit = new Submit('save');
        $submit->setValue($language->text('billingbraintree', 'btn_save'));
        $this->addElement($submit);
    }

    public function process()
    {
        $values = $this->getValues();

        $billingService = BOL_BillingService::getInstance();
        $gwKey = BILLINGBRAINTREE_CLASS_BraintreeAdapter::GATEWAY_KEY;

        $billingService->setGatewayConfigValue($gwKey, 'business', $values['business']);
        $billingService->setGatewayConfigValue($gwKey, 'publicKey', $values['publicKey']);
        $billingService->setGatewayConfigValue($gwKey, 'privateKey', $values['privateKey']);
        $billingService->setGatewayConfigValue($gwKey, 'sandboxMode', $values['sandboxMode']);
    }
}
