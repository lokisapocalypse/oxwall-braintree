<?php

BOL_LanguageService::getInstance()->addPrefix('latterdatebraintreebilling', 'Braintree Billing');
OW::getPluginManager()->addPluginSettingsRouteName('latterdatebraintreebilling', 'braintree_billing_admin');
