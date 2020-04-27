<?php

namespace Mycools\Eps;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use App;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
class Eps
{
    use Traits\MethodPayment;
    private $endpoint_production = "https://api.elementpay.io/merchant";
    private $endpoint_sandbox = "https://api-sbox.elementpay.io/merchant/";
    private $eps;
    private $cachettl = 120; //second
    
    private $activeMethod = [];
    public function __construct()
    {
        $this->merchant_key = config('eps.merchant_key');
        $this->secret_key = config('eps.secret_key');
        if(config('eps.environment')=="sandbox"){
            $this->eps = new Client([
                'base_uri' => $this->endpoint_sandbox,
                'timeout'  => 10.0,
            ]);
        }else if(config('eps.environment')=="production"){
            $this->eps = new Client([
                'base_uri' => $this->endpoint_sandbox,
                'timeout'  => 10.0,
            ]);
        }else if (App::environment(['local', 'staging'])) {
            $this->eps = new Client([
                'base_uri' => $this->endpoint_sandbox,
                'timeout'  => 10.0,
            ]);
        }else{
            $this->eps = new Client([
                'base_uri' => $this->endpoint_production,
                'timeout'  => 10.0,
            ]);
        }
        
    }
    
    public function getAbout()
    {
        return Cache::remember('getAbout', $this->cachettl , function () {
            return $this->_call_expay('getAbout',[]);
        });
    }
    public function about()
    {
        return new About($this->getAbout());
    }
    public function method()
    {
        return new Method($this->getMethods());
    }
    
    public function getMethods()
    {
        return Cache::remember('getMethods', $this->cachettl , function () {
            return $this->_call_expay('getMethods',[]);
        });
    }
    public function getStatus($paymentId)
    {
        //return Cache::remember('getStatus-'.$paymentId, $this->cachettl , function () use($paymentId) {
        return $this->_call_expay('getStatus',['payment_id'=>$paymentId]);
        //});
    }
    private function _call_expay($method, $init_arr)
    {
        $out = false;
        $request_arr = $this->_prepare_str($method, $init_arr);
        $out = $this->_send_to_expay($method, $request_arr);
        return $out;
    }
    private function _prepare_str($method, $init_arr)
    {
        $time = time();
        $init_arr['key'] = $this->merchant_key;
        $init_arr['timestamp'] = $time;
        $str = http_build_query($init_arr, '', '&', PHP_QUERY_RFC3986);
        $hash = hash_hmac('sha1', $method . '?' . $str, $this->secret_key);
        $init_arr['hash'] = $hash;
        return $init_arr;
    }
    private function _check_hash($resp,$str)
    {
        if(isset($resp->response) && isset($resp->hash)){
            $tmp_arr = explode('{"response":', $str);
            $tmp_arr = explode(',"hash":', $tmp_arr[1]);
            $checkHash = hash_hmac('sha1', $tmp_arr[0], $this->secret_key);
            if($resp->hash == $checkHash){
                return true;
            }else{
                
                throw new \Exception('EPS Exception. Invalid Hash Check', 401);
            }
        }else{
            if(isset($resp->error)){
                throw new \Exception("EPS Exception. ".$resp->error->message,$resp->error->code);
            }else{
                throw new \Exception('EPS Exception. No data for check HASH', 404);
            }
        }
    }
    
    private function _send_to_expay($method, $params)
    {
        try {
            
            $query = http_build_query($params);
            if($method=="initPayment"){
               // dd($params);
            }
            
            $response = $this->eps->request('POST',$method,['form_params' => $params ]);
            $body = $response->getBody()->getContents();
            $resp = json_decode($body);
            if(isset($resp->error)){
                throw new \Exception("EPS Exception. ".$resp->error->message,$resp->error->code);
            }
           
            if($this->_check_hash($resp, $body)){
                return $resp->response;
            }else{
                throw new \Exception("EPS Exception. Check hash failed.");
            }
           
        }catch (RequestException $e) {
            throw new \Exception(Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                throw new \Exception(Psr7\str($e->getResponse()));
            }
        }

    }


    
}
