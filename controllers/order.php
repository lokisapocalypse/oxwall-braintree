<?php
class BILLINGBRAINTREE_CTRL_Order extends OW_ActionController
{
    public function form()
    {
        // load the form
        $form = new BILLINGBRAINTREE_CLASS_BillingForm();

        // convert the form to an array for rendering purposes
        $this->assign('fields', $form->oxwallControllerInterest());
    }
}
