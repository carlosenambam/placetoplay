<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\DataStructures\DataStructuresFactory;

class DataStructuresFactoryTest extends TestCase
{

    public function testAuth()
    {
        $ds = new DataStructuresFactory();
        $auth = $ds->auth();
        $this->assertEquals('6dd490faf9cb87a9862245da41170ff2', $auth->login);
    }

    public function testCreateTransactionParams()
    {
        $params = array(
            'person' => array(
                'document' => '3515153',
                'documentType' => 'CC',
                'firstName' => 'Carlos',
                'lastName' => 'Alvarez',
                'company' => 'PlaceToPay',
                'emailAddress' => 'carlosenam@hotmail.com',
                'address' => 'Calle 1',
                'city' => 'Medellin',
                'province' => 'Antioquia',
                'country' => 'CO',
                'phone' => '6315315',
                'mobile' => '3005194470'
            ),
            'transaction' => array(
                'bankCode' => '1022',
                'bankInterface' => '0',
                'reference' => uniqid(),
                'language' => 'ES',
                'totalAmount' => '12000.00',
                'currency' => 'COP',
                'description' => 'Pago de Prueba'
            )
        );
        $ds = new DataStructuresFactory();

        $testObject2 = $ds->createTransactionParams($params, '127.0.0.1', 'userAgent', 1);

        $this->assertEquals($params['transaction']['bankCode'], $testObject2['transaction']->bankCode);
        $this->assertEquals($params['transaction']['bankInterface'], $testObject2['transaction']->bankInterface);
        $this->assertEquals($params['transaction']['reference'], $testObject2['transaction']->reference);
        $this->assertEquals($params['transaction']['language'], $testObject2['transaction']->language);
        $this->assertEquals($params['transaction']['totalAmount'], $testObject2['transaction']->totalAmount);
        $this->assertEquals($params['transaction']['currency'], $testObject2['transaction']->currency);
        $this->assertEquals('127.0.0.1', $testObject2['transaction']->ipAddress);
        $this->assertEquals('userAgent', $testObject2['transaction']->userAgent);
        $this->assertEquals(url('/return-url?tranid=1'), $testObject2['transaction']->returnURL);
        $this->assertEquals($params['person']['document'], $testObject2['transaction']->payer->document);
        $this->assertEquals($params['person']['documentType'], $testObject2['transaction']->payer->documentType);
        $this->assertEquals($params['person']['firstName'], $testObject2['transaction']->payer->firstName);
        $this->assertEquals($params['person']['company'], $testObject2['transaction']->payer->company);
        $this->assertEquals($params['person']['emailAddress'], $testObject2['transaction']->payer->emailAddress);
        $this->assertEquals($params['person']['city'], $testObject2['transaction']->payer->city);
        $this->assertEquals($params['person']['province'], $testObject2['transaction']->payer->province);
        $this->assertEquals($params['person']['country'], $testObject2['transaction']->payer->country);
        $this->assertEquals($params['person']['phone'], $testObject2['transaction']->payer->phone);
        $this->assertEquals($params['person']['mobile'], $testObject2['transaction']->payer->mobile);
        $this->assertEquals($ds->auth(), $testObject2['auth']);
    }
}
