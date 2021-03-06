<?php

namespace Omnipay\Heartland\Message;

use Omnipay\Tests\TestCase;

class FetchScheduleRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new FetchScheduleRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setSecretApiKey('skapi_cert_MTyMAQBiHVEAewvIzXVFcmUd2UcyBge_eCpaASUp0A');
        $this->request->setScheduleReference('1234');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchScheduleSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFailureNotFound()
    {
        $this->setMockHttpResponse('FetchScheduleFailureNotFound.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('404', $response->getCode());
    }
}
