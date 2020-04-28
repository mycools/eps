<?php

namespace Mycools\Eps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
class EpsController extends Controller
{
    public function postEndpoint(Request $request)
    {
        $pid = $request->id;
        $order = $request->order;
        $method = $request->method;
        $this->{"Eps".ucfirst(Str::camel($method))}($request);
    }
    private function EpsCheck(Request $request)
    {
        $pid = $request->id;
        $order = $request->order;
        $hash = $request->hash;
        $serviceId = $request->service_id;
    }
    public function getSuccess(Request $request)
    {
        
    }
    public function getReject(Request $request)
    {
        
    }
    public function getWaiting(Request $request)
    {
        
    }
}
