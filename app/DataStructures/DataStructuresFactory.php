<?php

namespace App\DataStructures;

use stdClass;
use Illuminate\Http\Request;

class DataStructuresFactory
{
    
    protected $authObject;

    public function __construct()
    {
        $seed = date('c');
        $this->authObject = new stdClass();
        $this->authObject->login = '6dd490faf9cb87a9862245da41170ff2';
        $this->authObject->seed = $seed;
        $this->authObject->tranKey = sha1($seed.'024h1IlD');
        $this->authObject->additional = array();
    }

    public function auth()
    {
        return $this->authObject;
    }

    protected function getStdObject($data = array())
    {
        if (!is_array($data)) {
            return null;
        }

        $stdObject = new stdClass();

        foreach ($data as $key => $value) {
            $stdObject->{$key} = $value;
        }

        return $stdObject;
    }

    public function createTransactionParams($requestData, $ip, $userAgent, $tranID)
    {

        $paramObject = array();
        $paramObject['transaction'] = $this->getStdObject($requestData['transaction']);
        $person = $this->getStdObject($requestData['person']);
        $paramObject['transaction']->payer = $person;
        $paramObject['transaction']->buyer = $person;
        $paramObject['transaction']->shipping = $person;
        $paramObject['transaction']->ipAddress = $ip;
        $paramObject['transaction']->userAgent = $userAgent;
        $paramObject['transaction']->returnURL = url('/return-url?tranid='.$tranID);
        $paramObject['auth'] = $this->auth();

        return $paramObject;
    }
}
