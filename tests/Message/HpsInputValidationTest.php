<?php

namespace Omnipay\Heartland\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tests\TestCase;

/**
 * Class HpsInputValidationTest
 */
class HpsInputValidationTest extends TestCase
{    
    public function testCheckAmountRounded(){
        $amount = HpsInputValidation::checkAmount('10.555555');
        $this->assertEquals('10.56', $amount);
    }
    
    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage Amount must be greater than or equal to 0
     */
    public function testCheckInvalidAmount(){
        $amount = HpsInputValidation::checkAmount('-5');
    }       
    
    /**
     * @test
     * Testing get exception when first name length is greater than 26
     */
    public function testCardHolderInValidFirstNameLength()
    {
        try {
            $sanitizedValue = HpsInputValidation::checkCardHolderData('Lorem ipsum dolor sit amet, consectetur', 'FirstName');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for FirstName can be no more than 26 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception and error code when last name length is greater than 26
     */
    public function testCardHolderInValidLastNameLength()
    {
        try {
            $sanitizedValue = HpsInputValidation::checkCardHolderData('Lorem ipsum dolor sit amet, consectetur', 'LastName');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for LastName can be no more than 26 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception and error code when city length is greater than 20
     */
    public function testCardHolderInValidCityLength()
    {
        try {
            $sanitizedValue = HpsInputValidation::checkCardHolderData('Lorem ipsum dolor sit amet, consectetur', 'City');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for City can be no more than 20 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception and error code when state length is greater than 20
     */
    public function testCardHolderInValidStateLength()
    {
        try {
            $sanitizedValue = HpsInputValidation::checkCardHolderData('Lorem ipsum dolor sit amet, consectetur', 'State');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for State can be no more than 20 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception and error code when Email length is greater than 100
     */
    public function testCardHolderInValidEmailLength()
    {
        try {
            $emailId = 'Loremipsumdonsecthisisadum.mysLoremipsum+donsectetur@textthisisadummytextLoremipsuconsecteturthisisadummy.com';
            $sanitizedValue = HpsInputValidation::checkEmailAddress($emailId, 'Email');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for Email can be no more than 100 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception and error code when Email address is invalid
     */
    public function testCardHolderInValidEmailAddress()
    {
        try {
            $emailId = 'www.invalidmail.com';
            $sanitizedValue = HpsInputValidation::checkEmailAddress($emailId, 'Email');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("Invalid email address", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing sanitize phone number
     */
    public function testCardHolderInSanitizePhoneNumber()
    {
        try {
            $phoneNumberValue = HpsInputValidation::checkPhoneNumber('555-555-555');
            $this->assertEquals($phoneNumberValue, '555555555');
        } catch (InvalidRequestException $e) {
            $this->fail("Failed with exception: " . $e->getMessage());
        }
    }

    /**
     * @test
     * Testing sanitize zip code
     */
    public function testCardHolderSanitizeZipCode()
    {
        try {
            $zipCodeValue = HpsInputValidation::checkZipCode('CAD 123');
            $this->assertEquals($zipCodeValue, 'CAD123');
        } catch (InvalidRequestException $e) {
            $this->fail("Failed with exception: " . $e->getMessage());
        }
    }

    /**
     * @test
     * Testing get exception when phone number length is greater than 20
     */
    public function testCardHolderInValidPhoneNumberLength()
    {
        try {
            $phoneNumberValue = HpsInputValidation::checkPhoneNumber('555-555-555-555-555-555-555-555-555555-555-555-555-555-555-555-555-555');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for phone number can be no more than 20 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }

    /**
     * @test
     * Testing get exception when zip code length is greater than 9
     */
    public function testCardHolderInValidZipCodeLength()
    {
        try {
            $zipCodeValue = HpsInputValidation::checkZipCode('CAD 123 CAD 123 CAD 123');
        } catch (InvalidRequestException $e) {
            $this->assertEquals("The value for zip code can be no more than 9 characters, Please try again after making corrections", $e->getMessage());
            return;
        }

        $this->fail("No exception was thrown.");
    }


    /**
     * @test
     * Testing sanitize address
     */
    public function testCardHolderSanitizeAddress()
    {
        try {
            $userInput = '6860, "Irvine", <Tx>, 75024';
            $sanitizedAddress = HpsInputValidation::checkCardHolderData($userInput, 'Address');
            $this->assertEquals($sanitizedAddress, '6860, &#34;Irvine&#34;, &#60;Tx&#62;, 75024');
        } catch (InvalidRequestException $e) {
            $this->fail("Failed with exception: " . $e->getMessage());
        }
    }
}
