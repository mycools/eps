<?php
namespace Mycools\Eps\Traits;
use Carbon\Carbon;
trait MethodPayment{
    private $invoice = [];
    public function setMethod($methodAlias)
    {
        $service = $this->method()->{'get'.ucfirst($methodAlias)}();

        if($service){
            $this->invoice['service_id'] = $service->id;
            $this->activeMethod = $service;
            return $this;
        }else{
            throw new \Exception("Invalid Method");
        }
        
    }
    public function getMinFee()
    {
        return (float) $this->activeMethod->commission->min_fee;
    }
    public function setTTL($ttl=86400)
    {
        $this->invoice['ttl'] = $ttl;
        return $this;
    }
    public function onSuccess($url)
    {
        $this->invoice['_successUrl'] = $url;
        $this->invoice['_merchantData']['_successUrl'] = $url;
        return $this;
    }
    public function onReject($url)
    {
        $this->invoice['_rejectUrl'] = $url;
        $this->invoice['_merchantData']['_rejectUrl'] = $url;
        return $this;
    }
    public function setExpire($expire)
    {
        $now = Carbon::now();
        $end = Carbon::parse($expire);
        $ttl = $end->diffInSeconds($now);
        $this->invoice['ttl'] = $ttl;
        return $this;
    }
    public function setAmount($amount)
    {
        if(!$this->activeMethod){
            throw new \Exception("setMethod first");
        }
        if((float)  $this->activeMethod->min > (float) $amount){
            throw new \Exception("limit amount between ".$this->activeMethod->min." to ".$this->activeMethod->max);
        }
        if((float)  $this->activeMethod->max < (float) $amount){
            throw new \Exception("limit amount between ".$this->activeMethod->min." to ".$this->activeMethod->max);
        }
        $this->invoice['amount'] = number_format($amount,2,'.','');
        return $this;
    }
    public function addFee($fee=false)
    {
        if(!$this->activeMethod){
            throw new \Exception("setMethod first");
        }
        $fee = (float) $fee;
        $amount = (float) $this->invoice['amount'];
        if($fee){
           
            $amount = $amount + $fee;
        }else{
            $fee = (float) $this->activeMethod->commission->min_fee;
            $amount = $amount + $fee;
        }
        $this->invoice['amount'] = number_format($amount,2,'.','');
        return $this;
    }
    public function setOrder($invoice)
    {
        $this->invoice['order'] = $invoice;
        return $this;
    }
    public function setAttr($name,$val)
    {
        $this->invoice['_merchantData'][$name] = $val;
        return $this;
    }
    public function initPayment()
    {
        $invoice = $this->invoice;
        $this->invoice=[];
        $this->activeMethod=[];
        if(isset($invoice['_merchantData'])){
            $invoice['_merchantData']= http_build_query($invoice['_merchantData']);
        }
        return $this->_call_expay('initPayment',$invoice);
    }
}