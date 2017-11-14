<?php

namespace cw\php\js\expression;

class Raw extends AbstractExpression{
  public $js;
  public function __construct($js){
    $this->js = $js;
  }

  public function toJs(){
    return $this->js;
  }
}
