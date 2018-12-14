<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentControllerTest extends TestCase
{
    
    public function testIfCreateTransactionRedirectsWell()
    {
        $params = array(
            '_token' => csrf_token(),
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

        $response = $this->post('/create-transaction', $params);

        $this->assertRegExp(
            '/https\:\/\/registro\.desarrollo\.pse\.com\.co\/PSEUserRegister\/StartTransaction\.htm\?enc\=.+/',
            app('url')->to($response->headers->get('Location'))
        );

        $params['transaction']['bankCode'] = '0';

        $response2 = $this->post('/create-transaction', $params);

        $response2->assertRedirect('/');
    }

    public function testPaymentFormLoadView()
    {
        $response = $this->get('/');

        $response->assertViewIs('paymentForm');
    }
}
