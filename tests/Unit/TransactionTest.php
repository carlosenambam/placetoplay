<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Transaction;
use stdClass;

class TransactionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddDataFromResponse()
    {
        $transaction = new Transaction();

        $testObject = new stdClass();
        $testObject->returnCode = 'test1';
        $testObject->bankURL = 'test2';
        $testObject->trazabilityCode = 'test3';
        $testObject->transactionCycle = 'test4';
        $testObject->transactionID = 'test5';
        $testObject->sessionID = 'test6';
        $testObject->bankCurrency = 'test7';
        $testObject->bankFactor = 'test8';
        $testObject->responseCode = 'test9';
        $testObject->responseReasonCode = 'test10';
        $testObject->responseReasonText = 'test11';

        $transaction->addDataFromResponse($testObject);

        $this->assertEquals('test1', $transaction->return_code);
        $this->assertEquals('test2', $transaction->bank_url);
        $this->assertEquals('test3', $transaction->trazability_code);
        $this->assertEquals('test4', $transaction->transaction_cycle);
        $this->assertEquals('test5', $transaction->transaction_id);
        $this->assertEquals('test6', $transaction->session_id);
        $this->assertEquals('test7', $transaction->bank_currency);
        $this->assertEquals('test8', $transaction->bank_factor);
        $this->assertEquals('test9', $transaction->response_code);
        $this->assertEquals('test10', $transaction->response_reason_code);
        $this->assertEquals('test11', $transaction->response_reason_text);
    }
}
