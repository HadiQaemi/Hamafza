<?php

namespace App\Exceptions;

use DB;
use Mail;
use Request;
use Exception;
use App\Mail\ErrorPagesEmail;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use URL;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            return parent::render($request, $exception);
        } else {
            //******************************************************************
            //***************** Data Needed For View And Email *****************
            //******************************************************************
            $SiteTitle = config('constants.SiteTitle');
            $SiteLogo = config('constants.SiteLogo');
            $with_arr = [
                'SiteLogo' => $SiteLogo,
                'SiteTitle' => $SiteTitle,
                'Title' => 'هم‌افزا',
                'index' => config('constants.IndexView')

            ];
            //-------------------------- Email Page Info------------------------
//            $fe = FlattenException::create($exception);
//            dd($fe->getStatusCode());
            if (method_exists($exception, 'getStatusCode')) {
                $StatusCode = $exception->getStatusCode();
                dd($StatusCode);
            } else {
                $StatusCode = 500;
            }
            $user = auth()->user();
            $jdate = new jDateTime();
            $date = explode('-', date("Y-m-d"));
            $date = $jdate->Gregorian_to_Jalali($date[0], $date[1], $date[2], '/') . ' ' . date('h:i:s');
            $logged_info = array(
                'error_code' => $StatusCode,
                'error_date' => $date,
                'error_route' => url()->current(),
                'client_ip' => Request::ip(),
                'client_browser' => $request->header('User-Agent'),
                'referrer' => URL::previous(),
                'user_id' => isset($user) ? $user->id : null
            );

            //-------------------------- Email Page Info------------------------
            //******************************************************************
            //***************** Data Needed For View And Email *****************
            //******************************************************************

            /*if ($this->isHttpException($exception))
            {*/
            $error_pages = explode(',', config('constants.APP_ERROR_PAGES_TO_EMAIL'));
            $emails = explode(',', config('constants.APP_MESSAGE_EMAIL'));

            if (config('constants.APP_USE_LOG_PLATFORM') == 'mongo') {

                $log_data = [
                    'error_code' => $StatusCode,
                    'error_date' => $date,
                    'route_url' => url()->current(),
                    'client_ip' => Request::ip(),
                    'client_browser' => $request->header('User-Agent'),
                    'referrer' => URL::previous(),
                    'user_id' => isset($user) ? $user->id : null
                ];

                if ($StatusCode == 500) {
                    $log_data['error_file'] = $exception->getFile();
                    $log_data['error_message'] = $exception->getMessage();
                }

                $add = DB::connection('mongodb')
                    ->collection('mycol')
                    ->insert($log_data);
            }

            if (in_array($StatusCode, $error_pages)) {
                //Send Email to Emails Set in ENV Constant
                foreach ($emails as $email) {
                    if ($StatusCode == 500) {
                        Mail::to($email)->queue(new ErrorPagesEmail($logged_info, $exception));
                    } else {
                        Mail::to($email)->queue(new ErrorPagesEmail($logged_info));
                    }
                }
            }
            //End Send Email

            switch ($StatusCode) {
                case '403':
                    return response()->view('layouts.errors.errors_helper.403', $with_arr);
                    break;
                case '404':
                    return response()->view('layouts.errors.errors_helper.404', $with_arr);
                    break;
                case '503':
                    $with_arr['error'] = '503';
                    return response()->view('layouts.errors.errors_helper.503', $with_arr);
                    break;
                default:
                    return response()->view('layouts.errors.errors_helper.500', $with_arr);
            }
            /*}
            return response()->view('layouts.errors.errors_helper.500');*/
//        return response()->view('errors.500', ['errors' => parent::render($request, $exception)]);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
