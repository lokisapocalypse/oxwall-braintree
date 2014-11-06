<?php

// not sure how autoloading works in oxwall
require_once('ow_plugins/billing_braintree/vendor/autoload.php');

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class BILLINGBRAINTREE_CLASS_BillingForm extends Form
{
    protected $braintreeAdapter;

    /**
     * This function creates the billing form. Because we aren't using Zend stuff for
     * models, we create our own validators here.
     *
     * @return void
     */
    public function __construct(BILLINGBRAINTREE_CLASS_BraintreeAdapter $adapter)
    {
        // create the zend form
        parent::__construct();

        // save the braintree adapter
        $this->braintreeAdapter = $adapter;

        // make it a bootstrap form
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        // first name on the credit card
        $this->add([
            'attributes' => [
                'id' => 'first-name',
                'placeholder' => 'First name',
                'required' => 'required',
            ],
            'name' => 'firstName',
            'options' => [
                'label' => 'First name',
            ],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // last name on the credit card
        $this->add([
            'attributes' => [
                'id' => 'last-name',
                'placeholder' => 'Last name',
                'required' => 'required',
            ],
            'name' => 'lastName',
            'options' => ['label' => 'Last name'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // card number
        $this->add([
            'attributes' => [
                'id' => 'number',
                'placeholder' => 'Credit card number',
                'required' => 'required',
            ],
            'name' => 'number',
            'options' => ['label' => 'Card number'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // credit card expiration month
        $this->add([
            'attributes' => [
                'class' => 'col-sm-3',
                'data-placeholder' => '-- Month --',
                'id' => 'month',
                'required' => 'required',
            ],
            'name' => 'month',
            'options' => [
                'label' => 'Month',
                'value_options' => $this->months(),
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        // credit card expiration year
        $this->add([
            'attributes' => [
                'class' => 'col-sm-3',
                'data-placeholder' => '-- Year --',
                'id' => 'year',
                'required' => 'required',
            ],
            'name' => 'year',
            'options' => [
                'label' => 'Year',
                'value_options' => $this->years(),
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        // security code
        $this->add([
            'attributes' => [
                'id' => 'security-code',
                'required' => 'required',
                'placeholder' => 'Security code',
            ],
            'name' => 'securityCode',
            'options' => ['label' => 'Security code (on back of card)'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // address line 1
        $this->add([
            'attributes' => [
                'id' => 'address-one',
                'required' => 'required',
                'placeholder' => 'Address line one',
            ],
            'name' => 'addressOne',
            'options' => ['label' => 'Address line 1'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // address line 2
        $this->add([
            'attributes' => [
                'id' => 'address-two',
                'placeholder' => 'Address line two',
            ],
            'name' => 'addressTwo',
            'options' => ['label' => 'Address line 2'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // city
        $this->add([
            'attributes' => [
                'id' => 'city',
                'required' => 'required',
                'placeholder' => 'City',
            ],
            'name' => 'city',
            'options' => ['label' => 'City'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // state / province
        $this->add([
            'attributes' => [
                'id' => 'state-province',
                'required' => 'required',
                'placeholder' => 'State / province',
            ],
            'name' => 'stateProvince',
            'options' => ['label' => 'State / Province'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // country
        $this->add([
            'attributes' => [
                'class' => 'col-sm-3',
                'data-placeholder' => '-- Country --',
                'id' => 'country',
                'required' => 'required',
            ],
            'name' => 'country',
            'options' => [
                'label' => 'Country',
                'value_options' => $this->countries(),
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        // zipcode
        $this->add([
            'attributes' => [
                'id' => 'zip',
                'required' => 'required',
                'placeholder' => 'Zip / Postal code',
            ],
            'name' => 'zip',
            'options' => ['label' => 'Zip'],
            'type' => 'Zend\Form\Element\Text',
        ]);

        // which plan the user is signing up for
        $this->add([
            'name' => 'plan',
            'options' => [
                'label' => 'Which plan would you like to sign up for?',
                'value_options' => $this->plans(),
            ],
            'type' => 'Zend\Form\Element\Radio',
        ]);

        // submit button
        $this->add([
            'attributes' => [
                'class' => 'btn btn-primary',
                'data-loading-text' => 'Saving...',
                'value' => 'Save',
            ],
            'options' => ['label' => 'Submit'],
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
        ]);

        $this->createValidators();
        $this->prepare();
    }

    /**
     * This function attaches all the filters and validators to the various
     * form elements.
     *
     * @return array with filter and validator definitions
     */
    public function createValidators()
    {
        // create filters and validators
        $standardFilters = [['name' => 'StripTags'], ['name' => 'StringTrim']];
        $validateNotEmpty = ['name' => 'NotEmpty'];

        // create the input filter
        $inputFilter = new \Zend\InputFilter\InputFilter();
        $inputFilter->add([
            'name' => 'addressOne',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'addressTwo',
            'required' => false,
            'filters' => $standardFilters,
        ]);
        $inputFilter->add([
            'name' => 'city',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'country',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$this->validateInArray(array_keys($this->countries())), $validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'firstName',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'lastName',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'month',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$this->validateInArray(array_keys($this->months())), $validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'number',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'plan',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$this->validateInArray(array_keys($this->plans())), $validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'securityCode',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'stateProvince',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'year',
            'required' => true,
            'filters' => $standardFilters,
            'validators' => [$this->validateInArray(array_keys($this->years())), $validateNotEmpty],
        ]);
        $inputFilter->add([
            'name' => 'zip',
            'required' => false,
            'filters' => $standardFilters,
        ]);
        $this->setInputFilter($inputFilter);
    }

    /**
     * This function creates the array of valid countries for credit card processing
     *
     * @return array of valid countries
     */
    protected function countries()
    {
        return ['' => '', 'United States of America' => 'United States'];
    }

    /**
     * This function constructs the array used for month validation and element.
     *
     * @return an array representing months
     */
    protected function months()
    {
        return array_merge(array('' => ''), range(1, 12));
    }

    /**
     * This function converts the form into an array so that it can be rendered
     * in the oxwall template file.
     *
     * @return an array of this form
     */
    public function oxwallControllerInterest()
    {
        $array = [];

        foreach ($this->getElements() as $name => $element) {
            $array[$name]['attributes'] = $element->getAttributes();

            if (!isset($array[$name]['attributes']['class'])) {
                $array[$name]['attributes']['class'] = '';
            }

            $array[$name]['attributes']['class'] = trim('form-control '.$array[$name]['attributes']['class']);
            $array[$name]['label'] = $element->getLabel();
            $array[$name]['options'] = $element->getOptions();
        }

        return $array;
    }

    /**
     * This function constructrs the array used for getting all the plans a user
     * can sign up for.
     *
     * @return an array representation of the plans
     */
    protected function plans()
    {
        $plans = [];

        foreach ($this->braintreeAdapter->plans() as $plan) {
            $plans[$plan->id] = $plan->description.' ($'.sprintf('%01.2f', $plan->price).')';
        }

        return $plans;
    }

    /**
     * This function builds an in array validator. This is done in a function to
     * make the constructor cleaner.
     *
     * @param $haystack : the items in the haystack
     * @return an array defining the validator
     */
    protected function validateInArray($haystack)
    {
        return ['name' => 'inArray', 'options' => ['haystack' => $haystack]];
    }

    /**
     * This function builds the years that are generally valid for credit
     * card processing. It contains an array for this year + 15 years.
     *
     * @return array consisting of valid years for credit card processing
     */
    protected function years()
    {
        $y = array_merge(array(''), range(date('Y'), date('Y') + 15));
        return array_combine($y, $y);
    }
}
