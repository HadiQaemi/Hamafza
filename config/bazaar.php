<?php

return [
    //'WebServiceURL' => "http://pimacssrv.pmo.ir/Services/PIMACS.svc?wsdl",
    'WebServiceURL' => "http://pimacssrv.pmo.ir/PIMACS.svc?wsdl",
    'BasePaymentURL' => "https://pimacs.pmo.ir/WebSite",
    'PartPaymentURL' => "/BMIPayment.aspx?TraceNo=",
    //"UserIn"=>"mrc",
	//"PassIn"=>"D@ne\$h@fza",
    "UserIn"=>"mrc",
    "PassIn"=>'D@ne$h@fza1111',
    "Seller"=>"14000180614",//"4591180948",
    "InvoiceType" => "07",
    "IncomeCenter" => "02",
    "MainIncomeCenter" => "02",
    "IncomeSystem" => "09",
    "BuyerType" => "PRS",
    "Currency" => "IRR",
    "PaymentCurrency" => "IRR",
    "PayIDCode" => "CBIPID2",
    "PayDueSerial" => "1",
    "IncomeCode" => "07",
    "AuxiliaryCode" => "99",
    "Account" => "2176459001009",
    "IRAccount" => "IR120170000002176459001009",
    "ReturnUrl" => "http://imrh.ir/bazaar/Payment/gateway/pimacs/callback",
    /*"params"=>[
        'Due'=>"2000",//مبلغ قابل پرداخت
        'Buyer'=>"1064017096",//1064017096
        'BuyerName'=>"عادل راحلی",//عادل راحلی
        'BuyerNameSecLang'=>"Adel.Raheli",//Adel.Raheli
        'Comments'=>"برای تست درگاه",//توضیحات
        'InvoiceDate'=>"2017-05-31",//"2017-05-31",
        'InvoiceExpireDate'=>"2017-07-31",//"2017-07-31"
        'InvoiceSerial'=>"12345",//"12345",
        'InvoiceYear'=>"1396",//"1396",
    ]*/



    'invoice_validaty_days'                 => '5',

    'invoice_basicdata_id_postmethod'       => '3',
    'invoice_basicdata_id_status'           => '9',

    'invoice_status_default_id'             => '61', // = invoice_status_not_paid

    'invoice_status_not_paid'               => '61', //     پرداخت نشده//
    'invoice_status_paid'                   => '62', //      پرداخت شده//
    'invoice_status_canceled'               => '63', //         لغو شده//
    'invoice_status_expired'                => '64', //           منقضی//
    'invoice_status_pending'                => '65', //   بررسی کارشناس//
    'invoice_status_sent'                   => '66', //       ارسال شده//
    'invoice_status_suspended'              => '67', //            معلق//

];
