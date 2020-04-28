<?php

namespace Mycools\Eps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mycools\Eps\Eps as EPS;
class EpsDemoController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }
    public function getAbout(Request $request,EPS $eps)
    {
        $methods = $eps->getAbout();
        return response()->json($methods);
    }
    public function getMethods(Request $request,EPS $eps)
    {
        $methods = $eps->getMethods();
        return response()->json($methods);
    }
    public function onreject(Request $request,$orderId='')
    {
        return redirect()->route('eps.demo.initPayment',['orderId' => $request->pid]);
    }
    public function initCardPayment(Request $request,EPS $eps,$orderId='')
    {
        if($orderId){
            $payment = $eps->getStatus($orderId);
           
            return redirect()->route('eps.demo.initPayment',['orderId' => $payment->id]);
        }else{
            $orderNo = 'INV999'.time();
            $customerId = 'CUS'.time();
            $payment = $eps->setMethod('kbankCards')
                            ->setOrder($orderNo)
                            ->setExpire("5 minutes")
                            ->setAmount(200)
                            ->addFee()
                            ->onSuccess(route('eps.demo.onSuccess',['orderNo' => $orderNo]))
                            ->onReject(route('eps.demo.onReject',['orderNo' => $orderNo]))
                            ->setAttr('customer_id',$customerId)
                            ->setAttr('card_id',17)
                            ->setAttr('customer_id',$customerId)
                            ->initPayment();
            return redirect()->route('eps.demo.initPayment',['orderId' => $payment->id]);
        }
        
        
    }
    public function initPayment(Request $request,EPS $eps,$orderId='')
    {
        if($orderId){
            $payment = $eps->getStatus($orderId);
            // dd($payment);
            $methods = $eps->setMethod($payment->service->id);
            $fee = $methods->getMinFee();
            return view('eps::initpayment',compact('payment','fee'));
        }else{
            $payment = $eps->setMethod('interbank')->setOrder('INV999'.time())->setExpire("5 minutes")->setAmount(19)->addFee()->initPayment();
            return redirect()->route('eps.demo.initPayment',['orderId' => $payment->id]);
        }
        
        
    }
}
