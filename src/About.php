<?php
namespace Mycools\Eps;
class About{
  private $resp = [];
  public function __construct($resp)
  {
    $this->resp = $resp;
  }
  public function getName()
  {
    return $this->resp->name;
  }
  public function getCurrency()
  {
    return $this->resp->currency;
  }
  public function isReseller()
  {
    return $this->resp->isReseller;
  }
  public function getPublicKey()
  {
    return $this->resp->settings->publicKey;
  }
  public function getLogo()
  {
    return $this->resp->logo;
  }
  public function use3ds()
  {
    return $this->resp->settings->use_3ds;
  }
  public function toArray()
  {
    return json_decode(json_encode($this->resp),true);
  }
  public function toJson()
  {
    return json_encode($this->resp);
  }
}