<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Models\Service;
use Str;

class PaypalController extends Controller
{
    private $_api_context;
    
    public function __construct()
    {
            
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function index()
    {
        $this->middleware(['auth','is_admin']);
        return view('service');
    }

    public function generate_link(Request $request)
    {
        $input = $request->all();
          
        $token =  Str::random(32);
        Service::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'amount' => $request->amount,
            'service' => json_encode($request->service),
            'token' => $token,
            'status' => 'Pending',
        ]);
        \Session::put('token', $token);
        $url =  url('/paywithpaypal/'.$token);
        return response()->json(['success'=> 'Successfully','link'=>$url]);
    }
    
    public function payWithPaypal($code)
    {
        $data['service'] = Service::firstWhere('token' ,$code);
        return view('paywithpaypal',$data);
    }

    

    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
        ->setCurrency('USD')
        ->setQuantity(1)
        ->setPrice($request->get('amount')); /** unit price **/
        
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        
        $amount = new Amount();
        $amount->setCurrency('USD')
        ->setTotal($request->get('amount'));
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Your transaction description');
        
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
        ->setCancelUrl(URL::route('status'));
        
        $payment = new Payment();
        $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));
        // dd($payment);
        // dd($payment->create($this->_api_context));
            try {
            $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
            \Session::put('error', 'Connection timeout');
                            return Redirect::route('paywithpaypal');
            } else {
            \Session::put('error', 'Some error occur, sorry for inconvenient');
                            return Redirect::route('paywithpaypal');
            }
            }
            foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
                            break;
            }
            }
            /** add payment ID to session **/
                    Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
            /** redirect to paypal **/
                        return Redirect::away($redirect_url);
            }
        \Session::put('error', 'Unknown error occurred');
                return Redirect::route('home');
        
    }

    public function getPaymentStatus(Request $request)
    {        
        $payment_id = Session::get('paypal_payment_id');
        
        Session::forget('paypal_payment_id');
        if (empty(request()->get('PayerID')) || empty(request()->get('token'))) {
            \Session::put('error', 'Payment failed');
                return redirect()->back();
        }
        
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(request()->get('PayerID'));
        
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $token = Session::get('token');
            $service = Service::firstWhere('token',$token);
            $service->status = 'Paid';
            $service->save();
            Session::forget('token');
            \Session::put('success', 'Payment success');
            return Redirect::route('success');
        }
        
        \Session::put('error', 'Payment failed');
        return redirect()->back();
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
