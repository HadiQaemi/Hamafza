<?php

return [
    'WebServiceURL' => env('BAZAAR_WebServiceURL', "http://pimacssrv.pmo.ir/Services/PIMACS.svc?wsdl"),
    'BasePaymentURL' => env('BAZAAR_BasePaymentURL', "https://pimacs.pmo.ir/WebSite"),
    'PartPaymentURL' => env('BAZAAR_PartPaymentURL', "/BMIPayment.aspx?TraceNo="),
    "UserIn"=> env('BAZAAR_UserIn', "mrc"),
    "PassIn"=> env('BAZAAR_PassIn', "D@ne\$h@fza"),
    "Seller"=> env('BAZAAR_Seller', "14000180614"),//"4591180948",
    "InvoiceType" => env('BAZAAR_InvoiceType', "07"),
    "IncomeCenter" => env('BAZAAR_IncomeCenter', "02"),
    "MainIncomeCenter" => env('BAZAAR_MainIncomeCenter', "02"),
    "IncomeSystem" => env('BAZAAR_IncomeSystem', "09"),
    "BuyerType" => env('BAZAAR_BuyerType', "PRS"),
    "Currency" => env('BAZAAR_Currency', "IRR"),
    "PaymentCurrency" => env('BAZAAR_PaymentCurrency', "IRR"),
    "PayIDCode" => env('BAZAAR_PayIDCode', "CBIPID2"),
    "PayDueSerial" => env('BAZAAR_PayDueSerial', "1"),
    "IncomeCode" => env('BAZAAR_IncomeCode', "07"),
    "AuxiliaryCode" => env('BAZAAR_AuxiliaryCode', "99"),
    "Account" => env('BAZAAR_Account', "2176459001009"),
    "IRAccount" => env('BAZAAR_IRAccount', "IR120170000002176459001009"),
    "ReturnUrl" => env('BAZAAR_ReturnUrl', "http://imrh.ir/bazaar/Payment/gateway/pimacs/callback"),
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



    'invoice_validaty_days'                 => env('BAZAAR_invoice_validaty_days', '5'),
    'invoice_basicdata_id_postmethod'       => env('BAZAAR_invoice_basicdata_id_postmethod', '3'),
    'invoice_basicdata_id_status'           => env('BAZAAR_invoice_basicdata_id_status', '9'),
    'invoice_status_default_id'             => env('BAZAAR_invoice_status_default_id', '100'), // = invoice_status_not_paid
    'invoice_status_not_paid'               => env('BAZAAR_invoice_status_not_paid', '100'), //     پرداخت نشده//
    'invoice_status_paid'                   => env('BAZAAR_invoice_status_paid', '101'), //      پرداخت شده//
    'invoice_status_canceled'               => env('BAZAAR_invoice_status_canceled', '102'), //         لغو شده//
    'invoice_status_expired'                => env('BAZAAR_invoice_status_expired', '103'), //           منقضی//
    'invoice_status_pending'                => env('BAZAAR_invoice_status_pending', '104'), //   بررسی کارشناس//
    'invoice_status_sent'                   => env('BAZAAR_invoice_status_sent', '105'), //       ارسال شده//
    'invoice_status_suspended'              => env('BAZAAR_invoice_status_suspended', '106'), //            معلق//

];
