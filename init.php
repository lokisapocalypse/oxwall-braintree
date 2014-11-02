<?php

// routes
OW::getRouter()->addRoute(new OW_Route('braintree_billing_admin', 'admin/braintree-billing', 'BILLINGBRAINTREE_CTRL_Admin', 'index'));

// initialize the event handler
BILLINGBRAINTREE_CLASS_EventHandler::getInstance()->init();
