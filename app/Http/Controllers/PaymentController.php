<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataStructures\DataStructuresFactory;
use SoapClient;
use StdClass;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItem;
use DateTime;
use DateInterval;

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

        $pseTR = $soapClient->createTransaction($ds->createTransactionParams($request));
        return view('pseresponde', array(
            'pseTR' => $pseTR
        ));
    }
}
