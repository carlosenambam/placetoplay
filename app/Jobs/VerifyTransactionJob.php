<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Transaction;
use SoapClient;
use App\DataStructures\DataStructuresFactory;

class VerifyTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction_id;

    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function handle(SoapClient $soapClient, DataStructuresFactory $ds)
    {
        $transaction = Transaction::find($this->transaction_id);
        $transactionInfo = $soapClient->getTransactionInformation(
            array(
                'auth' => $ds->auth(),
                'transactionID' => $transaction->transaction_id
            )
        );
        $infoResults = $transactionInfo->getTransactionInformationResult;
        $stateText = $infoResults->responseReasonText;
        $transaction->state = $infoResults->transactionState;
        $transaction->response_reason_text = $stateText;
        $transaction->save();
    }
}
