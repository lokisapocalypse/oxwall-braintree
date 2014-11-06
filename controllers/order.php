<?php
class BILLINGBRAINTREE_CTRL_Order extends OW_ActionController
{
    public function form()
    {
        // load the billing service
        $billingService = BOL_BillingService::getInstance();
        $adapter = new BILLINGBRAINTREE_CLASS_BraintreeAdapter($billingService);

        // load the form
        $form = new BILLINGBRAINTREE_CLASS_BillingForm($adapter);

        // convert the form to an array for rendering purposes
        $this->assign('fields', $form->oxwallControllerInterest());
    }
}
