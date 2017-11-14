<?php

namespace cw\php\js\expression\jquery;

class GetScript extends \cw\php\js\expression\AbstractExpression{
  public function __construct($url, $callback = null){
    $this->url = $url;
    if($callback)
      $this->callback = $this->castToJsObject($callback);
  }

  public function toJs(){
    $callback = $callback ? " , $this->callback" : '';
    return "jQuery.getScript('".$this->url."'$callback)";
  }
}
