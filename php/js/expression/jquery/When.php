<?php

namespace cw\php\js\expression\jquery;

class When extends \cw\php\js\expression\AbstractExpression{
  public $whenStore = [];
  public $thenStore = [];

  public function __construct($when = null){
    if($when)
      $this->when($when);
  }

  public function when(){
    foreach(func_get_args() as $when)
      $this->whenStore[] = $this->castToJsObject($when);
    return $this;
  }

  public function then($then){
    $this->thenStore[] = $this->castToJsObject($then);
    return $this;
  }

  public function toJs(){
    $when = implode(', ', $this->whenStore);
    $then = new \cw\php\js\expression\AnonymFunction(implode('; ', $this->thenStore));
    return "jQuery.when(".$when.").then(".$then.");";
  }
}
