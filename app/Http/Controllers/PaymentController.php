<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataStructures\DataStructuresFactory;
use SoapClient;
use SoapFault;
use StdClass;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItem;
use DateTime;
use DateInterval;
use App\Transaction;
use App\Jobs\VerifyTransactionJob;

class PaymentController extends Controller
{
    public function paymentForm(
        Request $request,
        DataStructuresFactory $ds,
        SoapClient $soapClient,
        CacheItemPool $cache
    ) {
        if (!$soapClient) {
            return 'Error';
        }


        if ($cache->hasItem('bankList')) {
            $bankList = $cache->getItem('bankList')->get();
        } else {
            $bankList = $soapClient->getBankList(array('auth' => $ds->auth()));
            $bankListCacheItem = new CacheItem('bankList', $bankList, true);
            $cacheExpireDate = new DateTime();
            $cacheExpireDate->add(new DateInterval('PT24H'));
            $bankListCacheItem->expiresAt($cacheExpireDate);
            $cache->save($bankListCacheItem);
        }
        

        return view('paymentForm', array(
            'bankList' => $bankList
        ));
    }

    public function createTransaction(Request $request, soapClient $soapClient, DataStructuresFactory $ds)
    {
        if (!$soapClient) {
            return 'Error';
        }

        $transaction = new Transaction();
        $transaction->save();

        if (!$request->input('transaction') || !$request->input('person')) {
            return redirect('/')->withErrors(['error' => '¡Datos Incorrectos!']);
        }

        try {
            $trResponse = $soapClient->createTransaction(
                $ds->createTransactionParams(
                    $request->all(),
                    $request->ip(),
                    $request->userAgent(),
                    $transaction->id
                )
            );
            $dataResponse = $trResponse->createTransactionResult;

            $transaction->addDataFromResponse($dataResponse);
            
            $transaction->save();

            if ($dataResponse->returnCode === 'SUCCESS') {
                $verifyTransactionJob = new VerifyTransactionJob($transaction->id);
                $verifyTransactionJob->delay(60*7);
                $this->dispatch($verifyTransactionJob);
                return redirect($dataResponse->bankURL);
            } else {
                return redirect('/')->withErrors(['error' => $dataResponse->responseReasonText]);
            }
        } catch (SoapFault $e) {
            return redirect('/')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function returnURL(Request $request, soapClient $soapClient, DataStructuresFactory $ds)
    {
        $transaction = Transaction::find($request->input('tranid'));
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
        
        return view('pseresponse', array(
            'tranState' => $stateText
        ));
    }

    public function transactionList()
    {
        $transactions = Transaction::all();

        return view('transactionList', array(
            'transactions' => $transactions
        ));
    }
}
