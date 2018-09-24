<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\Address;
use App\Models\Hamahang\Basicdata;
use App\Models\Hamahang\BasicdataValue;
use App\Models\Hamahang\DiscountCoupon;
use App\Models\Hamahang\Invoice;
use App\Models\Hamahang\InvoiceItem;
use App\Models\Hamahang\SubjectsProductInfo;
use App\User;
use Datatables;
use DB;
use Redirect;
use Request;
use Session;
use Validator;

class BazaarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    public function part2()
    {
        $tab = Request::input('tab', 1);
        $search = Request::input('search', null);
        if (1 == $tab)
        {
            if ('' == $search)
            {
                $subjects = Subject::whereHas('product_info')->paginate(config('app.bazaar_pager_items_per_page'));
            } else
            {
                $subjects = Subject::whereHas('product_info')->where('title', 'like', "%$search%")->paginate(config('app.bazaar_pager_items_per_page'));
            }
        } elseif (2 == $tab)
        {
            if ('' == $search)
            {
                $subjects = Subject::has('subject_like', '>=', '10')->paginate(config('app.bazaar_pager_items_per_page'));
            } else
            {
                $subjects = Subject::has('subject_like', '>=', '10')->where('title', 'like', "%$search%")->paginate(config('app.bazaar_pager_items_per_page'));
            }
        }

        $result = view('hamahang.Bazaar.helper.part2')->with(['subjects' => $subjects, ])->render();
        return response()->json(['success' => true, 'result' => $result]);
    }
    */

    public function bazaar()
    {
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        /*
        $subjects1 = Subject::whereHas('product_info')->paginate(config('app.bazaar_pager_items_per_page'));
        $subjects2 = Subject::has('subject_like', '>=', '1')->paginate(config('app.bazaar_pager_items_per_page'));
        $subjects2->setPageName('other_page');
        $subjects3 = Subject::whereHas('product_info')->get();
        return view('hamahang.Bazaar.bazaar')->with(['subjects1' => $subjects1, 'subjects2' => $subjects2, 'subjects3' => $subjects3]);
        */
        return view('hamahang.Bazaar.bazaar', $bazaar_requirements);
    }

    public function bazaar_update()
    {
        $rfs = Request::input('responsible_for_sales_id', []);
        Request::merge(['responsible_for_sales_id' => $rfs[0]]);
        $validator = Validator::make
        (
            Request::all(),
            [
                'id' => 'required',
                'subject_id' => 'required',
                'price' => 'required|integer|min:0',
                'discount' => 'required|integer|min:0',
                'tax' => 'required|integer|min:0|max:100',
                'responsible_for_sales_id' => 'required|integer',
                'weight' => 'required|integer|min:0',
                'size' => 'required|string',
                'shipping_cost' => 'required|integer|min:0',
                'maximum_delivery_time' => 'required|integer|min:0',
                'how_to_send' => 'required|integer',
                'count' => 'required|integer|min:0',
                'payment_methods' => 'required|array',
                //'ready_to_supply' => 'required',
                //'created_by' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $id = Request::input('id');
        $subject_id = Request::input('subject_id');
        $price = Request::input('price');
        $discount = Request::input('discount');
        $tax = Request::input('tax');
        $responsible_for_sales_id = Request::input('responsible_for_sales_id');
        $weight = Request::input('weight');
        $size = Request::input('size');
        $shipping_cost = Request::input('shipping_cost');
        $maximum_delivery_time = Request::input('maximum_delivery_time');
        $how_to_send = Request::input('how_to_send');
        $count = Request::input('count');
        $payment_methods = Request::input('payment_methods');
        $description = Request::input('description');
        $ready_to_supply = Request::input('ready_to_supply');

        $spi = SubjectsProductInfo::find($id);
        if (null == $spi)
        {
            $spi = new SubjectsProductInfo();
        }

        $spi->subject_id = $subject_id;
        $spi->price = $price;
        $spi->discount = $discount;
        $spi->tax = $tax;
        $spi->responsible_for_sales_id = $responsible_for_sales_id;
        $spi->weight = $weight;
        $spi->size = $size;
        $spi->shipping_cost = $shipping_cost;
        $spi->maximum_delivery_time = $maximum_delivery_time;
        $spi->how_to_send = $how_to_send;
        $spi->count = $count;
        $spi->payment_methods = implode(',', $payment_methods);
        $spi->description = $description;
        $spi->ready_to_supply = $ready_to_supply;
        $spi->created_by = auth()->id();
        $result = $spi->save();

        return response()->json(['success' => $result, 'result' => [$spi->id, $spi->subject_id,]]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * - - -
     *
     */
    static function bazaar_request_control($for = '')
    {
        $r = false;
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        $cart = $bazaar_requirements['cart'];
        $cart_setting = $bazaar_requirements['cart_setting'];
        $cart_coupons = $bazaar_requirements['cart_coupons'];
        switch ($for)
        {
            case 'cart':
            case 'cart_content':
                $r = true;
                break;
            case 'shipping':
            case 'shipping_content':
                $r = !empty($cart);
                break;
            case 'review':
            case 'review_content':
                $r = !(empty($cart_setting['address']) || empty($cart_setting['postmethod']));
                break;
            case 'payment':
            case 'payment_content':
                $r = !empty($cart_setting['payable_amount']);
                break;
            case 'pay':
                $r = Session::get('cart_pay');
                break;
            default:
                $r = false;
                break;
        }
        return $r;
    }

    static function bazaar_request_make($for = '')
    {
        $r = null;
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        switch ($for)
        {
            case 'cart':
                $r = null;
                break;
            case 'cart_content':
                $r = null;
                break;
            case 'shipping':
                $r = redirect::to($bazaar_requirements['url_cart']);
                break;
            case 'review':
                $r = redirect::to($bazaar_requirements['url_shipping']);
                break;
            case 'payment':
                $r = redirect::to($bazaar_requirements['url_review']);
                break;
            case 'pay':
                $r = redirect::to($bazaar_requirements['url_payment']);
                break;
            case 'shipping_content':
            case 'review_content':
            case 'payment_content':
            default:
                $r = view('hamahang.Bazaar.helper.bazaar-request', $bazaar_requirements);
                break;
        }
        return $r;
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin cart functions
     *
     */

    // load cart page directly
    public function cart($username)
    {
        $variables = variable_generator('user', 'desktop', $username);
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        return view('hamahang.Bazaar.cart', $variables, $bazaar_requirements);
    }

    // get cart content
    public function cart_content()
    {
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        $cart = Session::get('cart');
        $products = Subject::with('product_info')->whereHas('product_info', function ($q) use ($cart)
        {
            $q->whereIn('subject_id', $cart ? array_keys($cart) : []);
        })->get();
        return view('hamahang.Bazaar.helper.cart-content', $bazaar_requirements)->with(['products' => $products, 'cart' => $cart]);
    }

    // add an item to cart
    public function cart_add()
    {
        if (Request::exists('id') && Request::exists('count'))
        {
            $id = Request::input('id');
            $count = Request::input('count');
            $cart = Session::get('cart');
            $cart[$id] = $count;
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'result' => []]);
        }
    }

    // update cart
    public function cart_update()
    {
        if (Request::exists('id') && Request::exists('count'))
        {
            $id = Request::input('id');
            $count = Request::input('count');
            $cart = Session::get('cart');
            $cart[$id] = $count;
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'result' => []]);
        }
        else
        {
            if (Request::exists('command') && Request::exists('id') && Request::exists('coupon'))
            {
                $cart_coupons = Session::get('cart_coupons');
                $command = Request::input('command');
                $id = Request::input('id');
                $coupon = Request::input('coupon');

                if ('+' == $command)
                {
                    //$cart_coupons[$id] = $coupon;
                }
                else
                {
                    if ('-' == $command)
                    {
                        unset($cart_coupons[$id]);
                    }
                }
                Session::put('cart_coupons', $cart_coupons);
                return response()->json(['success' => true, 'result' => []]);
            }
        }
        return response()->json(['success' => false, 'result' => []]);
    }

    // delete an item from cart
    public function cart_delete()
    {
        if (Request::exists('id'))
        {
            $id = Request::input('id');
            $cart = Session::get('cart');
            unset($cart[$id]);
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'result' => []]);
        }
    }

    // make cart empty
    public function cart_empty()
    {
        Session::forget('cart');
        Session::forget('cart_setting');
        Session::forget('cart_coupons');
        return response()->json(['success' => true, 'result' => []]);
    }

    // get cart count
    public function cart_count()
    {
        return response()->json(['success' => true, 'result' => count(Session::get('cart'))]);
    }

    // check a discountcoupon validaty
    public function cart_discountcoupon_check()
    {
        $id = Request::input('id');
        $coupon = Request::input('coupon');
        $discount_coupon = DiscountCoupon
            ::where('coupon', $coupon)
            ->whereRaw('? between start_date AND expire_date', [date('Y-m-d')])
            ->where('used_count', 0)
            ->where('subject_id', $id)
            ->whereRaw('subject_used_count < subject_usage_quota', [])
            ->whereRaw('subject_used_count = ?', [0])
            ->where('inactive', '0')
            ->get();
        if (count($discount_coupon))
        {
            $cart_coupons = Session::get('cart_coupons');
            $id = Request::input('id');
            $coupon = Request::input('coupon');
            $cart_coupons[$id] = $coupon;
            Session::put('cart_coupons', $cart_coupons);
        }
        return response()->json(['success' => (bool)count($discount_coupon), 'result' => [$discount_coupon]]);
    }

    //check whether subject has a coupon added
    static function cart_has_coupon($id)
    {
        $cart_coupons = Session::get('cart_coupons');
        return isset($cart_coupons[$id]);
    }

    //check whether subject has a coupon added
    static function cart_calc_discount($id, $price, $discounted_price, $count)
    {
        $cart_coupons = Session::get('cart_coupons');
        if (isset($cart_coupons[$id]))
        {
            $coupon = $cart_coupons[$id];
            $discount_coupon = \App\Models\Hamahang\DiscountCoupon::where('coupon', $coupon)->get()->first()->toArray();
            $r = abs((($discounted_price * $discount_coupon['value'] / 100) * min($count, $discount_coupon['subject_usage_quota'])));
        }
        else
        {
            $r = 0;
        }
        return $r;
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin shipping functions
     *
     */

    // load shipping page directly
    public function shipping($username)
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $variables = variable_generator('user', 'desktop', $username);
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            return view('hamahang.Bazaar.shipping', $variables, $bazaar_requirements);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // get shipping content
    public function shipping_content()
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            $default_address = Address::where('user_id', auth()->id())->where('id', auth()->user()->default_address_id)->get()->toArray();
            $other_addresses = Address::where('user_id', auth()->id())->where('id', '<>', auth()->user()->default_address_id)->get()->toArray();
            $addresses = array_merge($default_address, $other_addresses);
            $postmethods = BasicdataValue::where('parent_id', '3')->where('inactive', '0')->get();
            return view('hamahang.Bazaar.helper.shipping-content', $bazaar_requirements)->with(['addresses' => $addresses, 'postmethods' => $postmethods,]);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // place shipping info into cart setting
    public function shipping_prepare()
    {
        if (Request::exists('address') && Request::exists('postmethod'))
        {
            $cart_setting = Session::get('cart_setting');
            $address = Request::input('address');
            $postmethod = Request::input('postmethod');
            $cart_setting['address'] = $address;
            $cart_setting['postmethod'] = $postmethod;
            Session::put('cart_setting', $cart_setting);
            return response()->json(['success' => true, 'result' => []]);
        }
        return response()->json(['success' => false, 'result' => []]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin review functions
     *
     */

    // load review page directly
    public function review($username)
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            $variables = variable_generator('user', 'desktop', $username);
            return view('hamahang.Bazaar.review', $variables, $bazaar_requirements);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // get shipping content
    public function review_content()
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            $cart = Session::get('cart');
            $products = Subject::with('product_info')->whereHas('product_info', function ($q) use ($cart)
            {
                $q->whereIn('subject_id', $cart ? array_keys($cart) : []);
            })->get();
            $cart_setting = Session::get('cart_setting');
            $address = Address::find($cart_setting['address']);
            $postmethod = BasicdataValue::find($cart_setting['postmethod']);
            return view('hamahang.Bazaar.helper.review-content', $bazaar_requirements)->with(['products' => $products, 'cart' => $cart, 'address' => $address, 'postmethod' => $postmethod,]);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // get shipping content
    public function review_prepare()
    {
        if (Request::exists('payable_amount'))
        {
            $cart_setting = Session::get('cart_setting');
            $cart_setting['payable_amount'] = Request::input('payable_amount');
            Session::put('cart_setting', $cart_setting);
            return response()->json(['success' => true, 'result' => []]);
        }
        else
        {
            return response()->json(['success' => false, 'result' => []]);
        }
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin payment functions
     *
     */

    // load payment page directly
    public function payment($username)
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            $variables = variable_generator('user', 'desktop', $username);
            return view('hamahang.Bazaar.payment', $variables, $bazaar_requirements);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // get payment content
    public function payment_content()
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
            return view('hamahang.Bazaar.helper.payment-content', $bazaar_requirements);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    // create and save invoice
    public function payment_invoice()
    {
        if (empty(auth()->user()->melli_code))
        {
            $validator = Validator::make
            (
                Request::all(),
                [
                    'melli_code' => 'required|melli_code',
                ],
                [
                    'melli_code.*' => 'لطفاً کد ملی را صحیح درج نمائید.',
                ]
            );
            if ($validator->fails())
            {
                return response()->json(['success' => false, 'result' => $validator->errors()]);
            }
            $melli_code = Request::input('melli_code');
            $user = User::find(auth()->id());
            $user->melli_code = $melli_code;
            $user->save();
            auth()->setUser($user);
            BazaarController::payment_invoice();
        }
        $cart = Session::get('cart');
        $cart_setting = Session::get('cart_setting');
        $cart_coupons = Session::get('cart_coupons');
        BazaarController::cart_empty();
        if ($cart && $cart_setting)
        {
            $invoice_year = HDate_GtoJ(time(), 'Y', false);
            $invoice_serial = Invoice::where('invoice_year', $invoice_year)->max('invoice_serial') + 1;
            $invoice = Invoice::create
            ([
                'user_id' => auth()->id(),
                'receiver_id' => $cart_setting['address'],
                'postmethod_id' => $cart_setting['postmethod'],
                'tracking_code' => 0, //time() . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'payable_amount' => $cart_setting['payable_amount'],
                'invoice_year' => $invoice_year,
                'invoice_serial' => $invoice_serial,
                'has_coupon' => (bool)count($cart_coupons),
            ]);
            foreach ($cart as $subject_id => $count)
            {
                $subject = Subject::find($subject_id);
                $spi = SubjectsProductInfo::where('subject_id', $subject_id)->first();
                $price = $spi->price - $spi->discount;
                $total_price = $price * $count;
                if (isset($cart_coupons[$subject_id]))
                {
                    $coupon = DiscountCoupon::where('coupon', $cart_coupons[$subject_id])->first();
                    $coupon_id = $coupon->id;
                }
                else
                {
                    $coupon_id = 0;
                }
                InvoiceItem::create
                ([
                    'invoice_id' => $invoice->id,
                    'subject_id' => $subject_id,
                    'subject_title' => $subject->title,
                    'subject_price' => $price,
                    'subject_count' => $count,
                    'total_price' => $total_price,
                    'coupon_id' => $coupon_id,
                    'final_price' => isset($cart_coupons[$subject_id]) ? $total_price - BazaarController::cart_calc_discount($subject_id, 0, $price, $count) : $total_price,
                    'responsible_for_sales_id' => $spi->responsible_for_sales_id,
                ]);
            }
            $invoice->status()->attach([config('bazaar.invoice_status_default_id') => ['user_id' => auth()->id()]]);
            if ($cart_coupons)
            {
                foreach ($cart_coupons as $cart_coupon)
                {
                    DiscountCoupon::dispose($cart_coupon);
                }
            }
            Session::put('cart_pay', $invoice->id);
            return response()->json(['success' => true, 'result' => [$invoice->id]]);
        }
        return response()->json(['success' => false, 'result' => []]);
    }


    function payment_invoice_generate_getpayids($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $date = date_create($invoice->created_at);
        $invoice_date = date_format($date, 'Y/m/d');
        $invoice_validaty_days = between(config('bazaar.invoice_validaty_days'), 1, 5);
        date_add($date, date_interval_create_from_date_string("$invoice_validaty_days day"));
        $invoice_expire_date = date_format($date, 'Y/m/d');
        $params =
            [
                'invoice_id' => $invoice->id,
                'Due' => $invoice->payable_amount, //مبلغ قابل پرداخت
                'Buyer' => auth()->user()->melli_code, //کد ملی
                'BuyerName' => trim(auth()->user()->FullName), //عادل راحلی
                'InvoiceDate' => $invoice_date,
                'InvoiceExpireDate' => $invoice_expire_date,
                'InvoiceYear' => $invoice->invoice_year, //"1396",
                'InvoiceSerial' => str_pad($invoice->invoice_serial, '5', '0', STR_PAD_LEFT), //"12345",
                'BuyerNameSecLang' => '', //Adel.Raheli
                'Comments' => '', //توضیحات
            ];
        return SoapGetPayIDs($params);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin pay functions
     *
     */
    public function pay()
    {
        if (BazaarController::bazaar_request_control(__FUNCTION__))
        {
            $invoice_id = Session::pull('cart_pay');
            $invoice = Invoice::find($invoice_id);
            $trace_no = $invoice->pay_request_trace_no;
            $pay_id = $invoice->pay_due_pay_id;
            if ($trace_no && $pay_id)
            {
                $url = GenerateURL($trace_no, $pay_id);
            }
            else
            {
                $url = BazaarController::payment_invoice_generate_getpayids($invoice_id);
            }
            if (false === $url)
            {
                session()->flash('payment_error', trans('bazaar.pay.payment_error'));
                return redirect::to(route('ugc.desktop.hamahang.bazaar.invoices.index', ['Uname' => auth()->user()->Uname]));
            }
            return redirect::to($url);
        }
        else
        {
            return BazaarController::bazaar_request_make(__FUNCTION__);
        }
    }

    function pay_prepare()
    {
        $invoice_id = Request::input('invoice_id', 0);
        Session::put('cart_pay', $invoice_id);
        return response()->json(['success' => true, 'result' => [$invoice_id]]);
    }

    // check a discountcoupon validaty
    public function payment_discountcoupon_check()
    {
        $coupon = Request::input('coupon');
        $discount_coupon = DiscountCoupon
            ::where('coupon', $coupon)
            ->whereRaw('? between start_date AND expire_date', [date('Y-m-d')])
            ->whereRaw('subject_used_count < subject_usage_quota', [])
            ->where('inactive', '0')
            ->get();
        return response()->json(['success' => (bool)count($discount_coupon), 'result' => [$discount_coupon]]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin discount coupons functions
     *
     */
    // make a list of discount coupons using Datatable and Eloquent
    public function discountcoupon_get_datatable()
    {
        $coupons = DiscountCoupon::query();
        return Datatables::eloquent($coupons)->make(true);
    }

    public function discountcoupon($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        return view('hamahang.Bazaar.discountcoupon', $arr);
    }

    public function discountcoupon_delete($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        return view('hamahang.Bazaar.discountcoupon', $arr);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin discount coupons functions
     *
     */
    // make a list of invoices using Datatable and Eloquent
    public function invoice_get_datatable()
    {
        $invoices = Invoice
            ::with('user')->with('items')
            ->withCount
            ([
                'items',
                'items as subjects' => function ($query)
                {
                    $query->select(DB::raw('SUM(subject_count) AS subjects'));
                }
            ]);

        $r = Datatables::eloquent($invoices)
            ->addColumn('invoice_no', function ($data)
            {
                return $data->invoice_no;
            })
            ->addColumn('products_count', function ($data)
            {
                return $data->items_count . ' ' . trans('bazaar.invoice.subject_count_product') . ' (' . $data->subjects_count . ' ' . trans('bazaar.invoice.subject_count_number') . ')';
            })
            ->addColumn('date', function ($data)
            {
                return $data->CreatedAtJalali;
            })
            ->addColumn('amount', function ($data)
            {
                return number_format($data->payable_amount);
            })
            ->addColumn('state', function ($data)
            {
                return $data->last_status;
            })

            ->addColumn('has_coupon_label', function ($data)
            {
                return trans('bazaar.invoice.has_coupon_' . ($data->has_coupon ? 'yes' : 'no'));
            })
            ->rawColumns(['has_coupon_label'])
            ->make(true);

        return $r;
    }

    // make a list of invoices using Datatable and Eloquent
    public function invoice_mysales_get_datatable()
    {
        $invoices = Invoice::whereHas('items', function ($query)
        {
            $query->where('responsible_for_sales_id', auth()->id());
        })
        ->orderBy('id', 'DESC');
        return Datatables::eloquent($invoices)
            ->addColumn('customer_name', function ($data)
            {
                return $data->user->Name;
            })
            ->addColumn('customer_family', function ($data)
            {
                return $data->user->Family;
            })
            ->addColumn('customer_mellicode', function ($data)
            {
                return $data->user->melli_code;
            })
            ->addColumn('invoice_no', function ($data)
            {
                return $data->invoice_no;
            })
            ->addColumn('subject_count', function ($data)
            {
                return $data->subject_count;
            })
            ->addColumn('date', function ($data)
            {
                return $data->CreatedAtJalali;
            })
            ->addColumn('amount', function ($data)
            {
                return number_format($data->payable_amount);
            })
            ->addColumn('state', function ($data)
            {
                return $data->last_status;
            })
            ->addColumn('has_coupon', function ($data)
            {
                return trans('bazaar.invoice.has_coupon_' . ($data->has_coupon ? 'yes' : 'no'));
            })
            ->make(true);
    }

    // make a list of invoices using Datatable and Eloquent
    public function invoice_my_get_datatable()
    {
        $invoices = Invoice::where('user_id', auth()->id())->orderBy('id', 'DESC');
        return Datatables::eloquent($invoices)
            ->addColumn('customer_name', function ($data)
            {
                return $data->user->Name;
            })
            ->addColumn('customer_family', function ($data)
            {
                return $data->user->Family;
            })
            ->addColumn('customer_mellicode', function ($data)
            {
                return $data->user->melli_code;
            })
            ->addColumn('invoice_no', function ($data)
            {
                return $data->invoice_no;
            })
            ->addColumn('subject_count', function ($data)
            {
                return $data->subject_count;
            })
            ->addColumn('date', function ($data)
            {
                return $data->CreatedAtJalali;
            })
            ->addColumn('amount', function ($data)
            {
                return number_format($data->payable_amount);
            })
            ->addColumn('state', function ($data)
            {
                return $data->last_status;
            })
            ->addColumn('has_coupon', function ($data)
            {
                return trans('bazaar.invoice.has_coupon_' . ($data->has_coupon ? 'yes' : 'no'));
            })
            ->make(true);
    }

    public function invoice_status_submit()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'id' => 'required|integer|min:1',
                'status' => 'required|integer|min:1',
                'tracking_code' => 'required_if:status,' . config('bazaar.invoice_status_sent'),
            ],
            [
                'status.*' => trans('bazaar.invoice.status.status_error'),
                'tracking_code.*' => trans('bazaar.invoice.status.tracking_code_error'),
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $id = Request::input('id');
        $status = Request::input('status');
        $invoice = Invoice::find($id);
        if (config('bazaar.invoice_status_sent') == $status)
        {
            $invoice->tracking_code = Request::input('tracking_code');
            $invoice->save();
        }
        $invoice->status()->attach([$status => ['user_id' => auth()->id()]]);

        return response()->json(['success' => true, 'result' => []]);
    }

    public function invoices($username)
    {
        $variables = variable_generator('user', 'desktop', $username);
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        return view('hamahang.Bazaar.invoice', $variables, $bazaar_requirements);
    }

    public function invoices_mysales($username)
    {
        $variables = variable_generator('user', 'desktop', $username);
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        return view('hamahang.Bazaar.invoice', $variables, $bazaar_requirements)->with(['mysales' => true]);
    }

    public function invoices_my($username)
    {
        $variables = variable_generator('user', 'desktop', $username);
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        return view('hamahang.Bazaar.invoice', $variables, $bazaar_requirements)->with(['my' => true]);
    }

    public function callback()
    {
        $res = SoapGetCheckResult(\Request::Input('msg'));
        if (isset($res->getCheckMsgResult))
        {
            $MsgResult = json_decode($res->getCheckMsgResult);
        }
        if (isset($MsgResult->state))
        {
            if ($MsgResult->state == 0)
            {
                session()->flash('message', $MsgResult->lblSucceed);
                session()->flash('mestype', 'error');
            }
            elseif ($MsgResult->state = 1)
            {
                if (isset($MsgResult->lblOrderID) && isset($MsgResult->lblRefrenceN))
                {
                    $invoice_no = substr($MsgResult->lblOrderID, '-7');
                    $invoice_year = substr($invoice_no, 0, 2);
                    $invoice_serial = substr($invoice_no, 2);
                    $invoice = Invoice::where('invoice_year', "13$invoice_year")->where('invoice_serial', $invoice_serial)->first();
                    if ($invoice)
                    {
                        // fake
                        $payment_confirmed = true;
                        // fake;
                        if ($payment_confirmed)
                        {
                            $invoice->paid = true;
                            $invoice->paid_order_id = $MsgResult->lblOrderID;
                            $invoice->paid_refrence_no = $MsgResult->lblRefrenceN;
                            $invoice->save();
                            $invoice->status()->attach([config('bazaar.invoice_status_paid') => ['user_id' => auth()->id()]]);
                            session()->flash('message', $MsgResult->lblSucceed);
                            session()->flash('mestype', 'success');
                        }
                        else
                        {
                            session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
                            session()->flash('mestype', 'error');
                        }
                    }
                    else
                    {
                        session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
                        session()->flash('mestype', 'error');
                    }
                }
                else
                {
                    session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
                    session()->flash('mestype', 'error');
                }
            }
        }
        else
        {
            session()->flash('message', 'خطا: در دریافت اطلاعات از دروازه پرداخت خطایی روی داده است.');
            session()->flash('mestype', 'error');
        }
        return redirect()->route('ugc.desktop.hamahang.bazaar.invoices.invoices_my',['username'=>auth()->user()->Uname]);
    }
}

