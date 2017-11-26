<?php
use App\Models\Hamahang\GetPayIDsResult;
use App\Models\Hamahang\Invoice;
use App\Models\Hamahang\PaymentGatewayRawLogs;
use App\Models\Hamahang\GetPayIDsResultPayDueIDs;

if (!function_exists('SoapGetCheckResult'))
{
    function SoapGetCheckResult($clearText, $url = 'http://94.130.3.14/WsSecurity.asmx?wsdl', $params = [])
    {
        $url = 'http://192.168.1.100:8080/WsSecurity.asmx?wsdl';
        $date = date('Ymd');
        $jdate = HJDate('Ymd', false);
        //$pass = $jdate + $date;
        $pass = 'e40f01afbb1b9ae3dd6747ced5bca532';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1, 'cache_wsdl' => WSDL_CACHE_NONE));
        $service_param = [
            [
                'pass' => "$pass",//"34131238",//13960508+20170730=34131238
                'msg' => "$clearText"
            ]
        ];
        //$service_param = array_merge($service_param, $params);
        $res = $client->__soapCall("getCheckMsg", $service_param);
        //dd($res);
        return $res;
    }
}
if (!function_exists('SoapenGetEncrypt'))
{
    function SoapenGetEncrypt($clearText, $url = 'http://94.130.3.14/WsSecurity.asmx?wsdl', $params = [])
    {
        $url = 'http://192.168.1.100:8080/WsSecurity.asmx?wsdl';
        $date = date('Ymd');
        $jdate = HJDate('Ymd', false);
        //$pass = $jdate + $date;
        $pass = 'e40f01afbb1b9ae3dd6747ced5bca532';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1, 'cache_wsdl' => WSDL_CACHE_NONE));
        $service_param = [
            [
                'pass' => "$pass",//"34131238",//13960508+20170730=34131238
                'clearText' => "$clearText"
            ]
        ];
        $service_param = array_merge($service_param, $params);
        $res = $client->__soapCall("getEncrypt", $service_param);
        //dd($service_param);
        return $res->getEncryptResult;
    }
}
if (!function_exists('SoapenGetDecrypt'))
{
    function SoapenGetDecrypt($clearText, $url = 'http://94.130.3.14/WsSecurity.asmx?wsdl', $params = [])
    {
        $url = 'http://192.168.1.100:8080/WsSecurity.asmx?wsdl';
        $date = date('Ymd');
        $jdate = HJDate('Ymd', false);
        //$pass = $jdate + $date;
        $pass = 'e40f01afbb1b9ae3dd6747ced5bca532';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1, 'cache_wsdl' => WSDL_CACHE_NONE));
        $service_param = [
            [
                'pass' => "$pass",//"34131238",//13960508+20170730=34131238
                'clearText' => "$clearText"
            ]
        ];
        $service_param = array_merge($service_param, $params);
        $res = $client->__soapCall("getDecrypt", $service_param);
        //dd($res);
        return $res->getDecryptResult;
    }

}
if (!function_exists('SoapGetPayIDs'))
{
    function SoapGetPayIDs($params = [])
    {
        $params = array_map(function ($input)
        {
            return (string)$input;
        }, $params);
        $payment_gateway_rawLogs = PaymentGatewayRawLogs::create(['invoice_id' => $params['invoice_id']]);

        //$payment_gateway_rawLogs->update(['params' => json_encode($params)]);

        if (count($params) == 0)
        {
            $params = [
                'Due' => "2000",//مبلغ قابل پرداخت
                'Buyer' => "1064017096",//1064017096
                'BuyerName' => "عادل راحلی",//عادل راحلی
                'BuyerNameSecLang' => "Adel.Raheli",//Adel.Raheli
                'Comments' => "برای تست درگاه",//توضیحات
                'InvoiceDate' => "2017-05-31",//"2017-05-31",
                'InvoiceExpireDate' => "2017-07-31",//"2017-07-31"
                'InvoiceSerial' => "12345",//"12345",
                'InvoiceYear' => "1396",//"1396",
            ];
        }
        /*$PayDueDetail =
            [
                "DueDetail" => "",
                "FineDetail" => "",
                "IncomeCode" => "07",
                "PayDueSerial" => "",
                "TaxDetail" => "",
            ];

        $PayDueDetails =
            [
                "PayDueDetail" => $PayDueDetail,
            ];*/

        /* $PayDueTaxFine =
             [
                 "Tax" => "24",
                 "Fine" => "12",
                 "Account" => "2176459001009",
                 "IncomeCode" => "07",
                 "PayDueSerial" => "1",
                 "PayIDCode" => "BMIPID2",
                 "Currency" => "IRR",
                 "PaymentCurrency" => "IRR",
             ];
         //DueTaxFine1.PayDueSerial = "1";
         //DueTaxFine1.Tax = "24";
         //DueTaxFine1.Fine = "12";
         //DueTaxFine1.PayIDCode = "BMIPID2"; //BMIPID2 PayID172 شناسه واریز 17 کاراکتری بانک ملی شناسه، شماره حساب و مبلغ
         //DueTaxFine1.IncomeCode = "07";
         //DueTaxFine1.Currency = "IRR";
         //DueTaxFine1.PaymentCurrency = "IRR";
         //DueTaxFine1.Account = "102784595008"; //102784595008 IR810170000000102784595008


         $PayDueTaxFines =
             [
                 "PayDueTaxFine" => $PayDueTaxFine
             ];*/

        $PayDue =
            [
                "Due" => $params['Due'],
                "Account" => config('bazaar.Account'),
                "AuxiliaryCode" => config('bazaar.AuxiliaryCode'),
                "IncomeCode" => config('bazaar.IncomeCode'),
                "PayDueDetails" => [],
                "PayDueSerial" => config('bazaar.PayDueSerial'),
                "PayDueTaxFines" => [],//$PayDueTaxFines,
                "PayIDCode" => config('bazaar.PayIDCode'),
                "Currency" => config('bazaar.Currency'),
                "PaymentCurrency" => config('bazaar.PaymentCurrency'),
                "Seller" => config('bazaar.Seller'),
            ];
        //PIMACSWCFClient.PayDue Due1 = new PIMACSWCFClient.PayDue();
        //Due1.PayDueSerial = "1";//سریال مبلغ واریزی سهم سازمان
        //Due1.PayIDCode = "CBIPID2";//کد شناسه واریز PayID302 CBIPID2
        //Due1.IncomeCode = "07";//حقوق و عوارض کالای متفرقه
        //Due1.AuxiliaryCode = "99";//کد معین درآمدی
        //Due1.Due = "400";//مبلغ واریزی
        //Due1.Currency = "IRR";//نوع ارز
        //Due1.PaymentCurrency = "IRR";//نوع ارز پرداختی
        //Due1.Seller = "14000180614";//شناسه یا کد ملی فروشنده
        //Due1.Account = "2176459001009";//2176459001009 IR120170000002176459001009 //4001064504008225 IR240100004001064504008225 تمركز وجوه تمامی درآمدهای ریالی سازمان بنادر و دريانوردی

        $PayDues =
            [
                "PayDue" => $PayDue,
            ];
        $PayRequestIn =
            [
                "Buyer" => $params['Buyer'],
                "BuyerName" => $params['BuyerName'],
                "BuyerNameSecLang" => $params['BuyerNameSecLang'],
                "BuyerType" => config('bazaar.BuyerType'),
                "Comments" => $params['Comments'],
                "DepositSerial" => "",
                "Errors" => "",
                "IncomeCenter" => config('bazaar.IncomeCenter'),
                "IncomeSystem" => config('bazaar.IncomeSystem'),
                "InvoiceDate" => $params['InvoiceDate'],//"2017-05-31",
                "InvoiceExpireDate" => $params['InvoiceExpireDate'],//"2017-07-31",
                "InvoiceSerial" => $params['InvoiceSerial'],//"12345",
                "InvoiceType" => config('bazaar.InvoiceType'),
                "InvoiceYear" => $params['InvoiceYear'],//"1396",
                "MainIncomeCenter" => config('bazaar.MainIncomeCenter'),
                "PayDues" => $PayDues,
            ];
        //PIMACSWCFClient.PayRequest Request1 = new PIMACSWCFClient.PayRequest();
        //Request1.MainIncomeCenter = "15";//
        //Request1.IncomeCenter = "15";//
        //Request1.IncomeSystem = "07";//
        //Request1.InvoiceSerial = "12345";//پنج رقمی
        //Request1.InvoiceYear = "1396";//چهار رقمی
        //Request1.InvoiceDate = "2017-05-31";
        //Request1.InvoiceExpireDate = "2017/05/31";
        //Request1.InvoiceType = "07";//صورتحساب مجوز فعالیت
        //Request1.Buyer = "0082263361";//کد ملی یا شناسه ملی
        //Request1.BuyerType = "PRS";//نوع هویت خریدار
        //Request1.BuyerName = "امیر حسین خواجگان";//نام
        //Request1.BuyerNameSecLang = "Amir H. Khajegan";//نام انگلیسی
        //Request1.Comments = "صورتحساب هزینه های بندری";//توضیحات
        $UserIn = config('bazaar.UserIn');
        $PassIn = config('bazaar.PassIn');
        $service_param =
            [
                "PayRequestIn" => $PayRequestIn,
                "UserIn" => "$UserIn",
                "PassIn" => "$PassIn",
            ];
        //$service_param = array_merge($service_param, $params);
        $payment_gateway_rawLogs->update(['params' => json_encode($service_param)]);
        $client = new SoapClient(config('bazaar.WebServiceURL'), array("soap_version" => SOAP_1_1, "trace" => 1));
        $res = $client->__soapCall("GetPayIDs", [$service_param]);
        $payment_gateway_rawLogs->update(['get_pay_ids_response' => json_encode($res)]);
        if (!is_object($res))
        {
            session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
            session()->flash('mestype', 'error');
            return false;
        }
        elseif (!is_object($res->GetPayIDsResult))
        {
            session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
            session()->flash('mestype', 'error');
            return false;
        }
        elseif (!isset($res->GetPayIDsResult->Succeed))
        {
            session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
            session()->flash('mestype', 'error');
            return false;
        }
        elseif (true !== $res->GetPayIDsResult->Succeed)
        {
            if (strpos($res->GetPayIDsResult->Errors, 'InvoiceSerial or DepositSerial is exist'))
            {
                $str = str_replace('Error in: InvoiceSerial or DepositSerial is exist: ', '', $res->GetPayIDsResult->Errors);
                $TraceNo = str_replace(',','',$str);
                $PayID = '';
                $invoice = Invoice::find($params['invoice_id']);
                $invoice->pay_request_trace_no = $TraceNo;
                $invoice->pay_due_pay_id = $PayID;
                $invoice->save();
                return GenerateURL($TraceNo, $PayID);
            }
            session()->flash('message', json_encode($res));
            session()->flash('mestype', 'error');
            return false;
        }

        $res_get_pay_ids_result = $res->GetPayIDsResult;
        $created_by = auth()->id();
        $get_pay_ids_result = GetPayIDsResult::create
        ([
            'invoice_id' => $params['invoice_id'],
            'errors' => json_encode($res_get_pay_ids_result->Errors),
            'invoice_serial' => $res_get_pay_ids_result->InvoiceSerial,
            'pay_due_ids_tax_fine' => $res_get_pay_ids_result->PayDueIDsTaxFine,
            'pay_request_date' => date('Y-m-d H:i:s', strtotime($res_get_pay_ids_result->PayRequestDate)),
            'pay_request_trace_no' => $res_get_pay_ids_result->PayRequestTraceNo,
            'status' => $res_get_pay_ids_result->Status,
            'succeed' => $res_get_pay_ids_result->Succeed,
            'full_data' => json_encode($res),
            'created_by' => $created_by,
        ]);
        foreach ($res_get_pay_ids_result->PayDueIDs as $v)
        {
            GetPayIDsResultPayDueIDs::create
            ([
                'getpayids_result_id' => $get_pay_ids_result->id,
                'errors' => json_encode($v->Errors),
                '_id' => $v->ID,
                'issue_date' => date('Y-m-d H:i:s', strtotime($v->IssueDate)),
                'pay_due_serial' => $v->PayDueSerial,
                'status' => $v->Status,
                'trace_no' => $v->TraceNo,
                'created_by' => $created_by,
            ]);
        }
        $TraceNo = $res->GetPayIDsResult->PayRequestTraceNo;
        $PayID = $res->GetPayIDsResult->PayDueIDs->PayID->ID;
        $invoice = Invoice::find($params['invoice_id']);
        $invoice->pay_request_trace_no = $TraceNo;
        $invoice->pay_due_pay_id = $PayID;
        $invoice->save();
        return GenerateURL($TraceNo, $PayID);
    }
}
if (!function_exists('GenerateURL'))
{
    function GenerateURL($TraceNo, $PayID, $ReturnUrl = false)
    {
        $ReturnUrl = $ReturnUrl ? $ReturnUrl : config('bazaar.ReturnUrl');
        $PayID = SoapenGetEncrypt($PayID);
        $TraceNo = SoapenGetEncrypt($TraceNo);
        $ReturnUrl = SoapenGetEncrypt($ReturnUrl);
        $URL = config('bazaar.BasePaymentURL') . config('bazaar.PartPaymentURL') . $TraceNo . "&PayID=" . $PayID . "&ReturnUrl=" . $ReturnUrl;
        return $URL;
    }

}