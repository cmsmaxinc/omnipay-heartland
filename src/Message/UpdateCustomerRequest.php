<?php

/**
 * Heartland Update Customer Request.
 */
namespace Omnipay\Heartland\Message;

/**
 * Heartland Update Customer Request.
 */
class UpdateCustomerRequest extends CreateCustomerRequest
{
    protected $allowedFields = array(
        'customerIdentifier',
        'firstName',
        'lastName',
        'company',
        'customerStatus',
        'title',
        'department',
        'primaryEmail',
        'secondaryEmail',
        'phoneDay',
        'phoneDayExt',
        'phoneEvening',
        'phoneEveningExt',
        'phoneMobile',
        'phoneMobileExt',
        'fax',
        'addressLine1',
        'addressLine2',
        'city',
        'stateProvince',
        'zipPostalCode',
        'country',
    );

    /**
     * @return string
     */
    public function getTransactionType()
    {
        return 'PayPlanCustomerEdit';
    }

    public function getData()
    {
        $data = parent::getData();
        $this->validate('customerKey');

        $data = array_intersect_key($data, array_flip($this->allowedFields));

        return array_merge($data, array(
            'http' => array(
                'uri' => 'customers/' . $this->getCustomerKey(),
                'verb' => 'PUT',
            ),
        ));
    }

    public function getCustomerKey()
    {
        return $this->getParameter('customerKey');
    }

    public function setCustomerKey($value)
    {
        $this->setParameter('customerKey', $value);
        return $this;
    }
}
