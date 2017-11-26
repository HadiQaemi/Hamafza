<?php

return [
    'Pubvar' => env('CONSTANTS_Pubvar', '100'),
    'APP_REGISTERED_ROLE_ID' => env('CONSTANTS_APP_REGISTERED_ROLE_ID', '2'),
    'AllowPreCode' => env('CONSTANTS_AllowPreCode', false),
    'PreCode' => env('CONSTANTS_PreCode', '120'),
    'styleDel' => env('CONSTANTS_styleDel', '1'),
    //'SiteFullTitle' => 'هم افزا',
    'SiteFullTitle' => env('CONSTANTS_SiteFullTitle', 'بانک اطلاعات دریایی ایران'),
    'SiteLogo' => env('CONSTANTS_SiteLogo', 'img/logo1.png'),
    //'SiteTitle' => 'هم افزا',
    'SiteTitle' => env('CONSTANTS_SiteTitle', 'بانک اطلاعات دریایی ایران'),
    'ChangeTable' => env('CONSTANTS_ChangeTable', 1),
    'APP_MESSAGE_EMAIL' => env('CONSTANTS_APP_MESSAGE_EMAIL', 'info@hamafza.ir'),
    'APP_ERROR_PAGES_TO_EMAIL' => env('CONSTANTS_APP_ERROR_PAGES_TO_EMAIL', '403,404,500,503'),
    'NUMBER_OF_QUEUE_ROWS_TO_RUN' => env('CONSTANTS_NUMBER_OF_QUEUE_ROWS_TO_RUN', 60),
    'APP_PUBLIC_ROLE' => env('CONSTANTS_APP_PUBLIC_ROLE', 'public'),
    'APP_DEFAULT_NEWS_ID' => env('CONSTANTS_APP_DEFAULT_NEWS_ID', 90),
    'HOMEPAGE_SECOND_SLIDER_TYPE' => env('CONSTANTS_HOMEPAGE_SECOND_SLIDER_TYPE', 65), //env('APP_DEFAULT_NEWS_ID', 90),
    'defthesarus' => env('CONSTANTS_defthesarus', 44126),
    'APP_STATIC_TOP_MENU' => env('CONSTANTS_APP_STATIC_TOP_MENU', 'شبکه اجتماعی-/4, دانشنامه دریایی-https://hamrahanpishraft.ir/360310'),
    'APP_RESET_PASSWORD_DUE_TIME' => env('CONSTANTS_APP_RESET_PASSWORD_DUE_TIME', '86400'),

    'enquiry_sidebar_paginate' => env('CONSTANTS_enquiry_sidebar_paginate', 10),

    'news_default_portal_id' => env('CONSTANTS_news_default_portal_id', 1),
    'news_sidebar_paginate' => env('CONSTANTS_news_sidebar_paginate', 10),
    'basicdata_groups_id' =>
        [
            'medals' => 2,
        ],

    /*
    |--------------------------------------------------------------------------
    | Default Index View
    |--------------------------------------------------------------------------
    | Supported: "hamafza", "banader", "itrac", "shazand"
    |*/
    'IndexView' => env('CONSTANTS_IndexView', 'hamafza'),

    /*
    |--------------------------------------------------------------------------
    | Definite Default Index View
    |--------------------------------------------------------------------------
    | Supported: "hamafza_1", "hamafza_2"
    */
    'DefIndexView' => env('CONSTANTS_DefIndexView', 'hamafza_1'),

    /*
    |--------------------------------------------------------------------------
    | Default Log System Platform
    |--------------------------------------------------------------------------
    | Supported: "laravel", "mongo"
    |*/
    'APP_USE_LOG_PLATFORM' => env('CONSTANTS_APP_USE_LOG_PLATFORM', 'laravel'),
];
