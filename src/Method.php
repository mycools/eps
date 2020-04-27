<?php
namespace Mycools\Eps;
use Illuminate\Support\Str;
class Method{
  private $resp = [];
  public function __construct($resp)
  {
    $this->resp = $resp;
  }
  public function __call($name, $arguments) {
    if($name=="getAll"){
      return $this->all();
    }
    foreach($this->resp->methods as $m){
      $method = 'get'.ucfirst(Str::camel($m->name));
      $methodAlias = 'get'.ucfirst(Str::camel($m->alias));
      $methodId = 'get'.Str::camel($m->id);
      if($method==$name){
        return $m->id;
      }
      if($methodAlias==$name){
        return $m;
      }
      if($methodId==$name){
        return $m;
      }
    }
  }
  
  public function all()
  {
    return json_decode(json_encode($this->resp),true);
  }
  public function toArray()
  {
    return $this->all();
  }
  public function toJson()
  {
    return json_encode($this->resp);
  }
}