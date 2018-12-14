<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function addDataFromResponse($data)
    {
        $this->return_code = $data->returnCode;
        $this->bank_url = $data->bankURL;
        $this->trazability_code = $data->trazabilityCode;
        $this->transaction_cycle = $data->transactionCycle;
        $this->transaction_id = $data->transactionID;
        $this->session_id = $data->sessionID;
        $this->bank_currency = $data->bankCurrency;
        $this->bank_factor = $data->bankFactor;
        $this->response_code = $data->responseCode;
        $this->response_reason_code = $data->responseReasonCode;
        $this->response_reason_text = $data->responseReasonText;
        $this->state = 'Unknown';
    }
}
