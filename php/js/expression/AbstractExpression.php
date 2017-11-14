<?php

namespace cw\php\js\expression;

abstract class AbstractExpression{
  public abstract function toJs();

  public function __toString(){
    return $this->toJs();
  }

  public function toJsWithWrapper($i='', $o=''){
    return "(function($o) { ".$this->toJs()." })($i);";
  }

  public function toJsWithJqueryWrapper($i='jQuery', $o='$'){
    return $this->toJsWithWrapper('jQuery', '$');
  }

  protected function castToJsObject($input){
    if(is_subclass_of($input, '\cw\php\js\expression\AbstractExpression'))
      return $input;

    // cast to string
    return new Raw(''.$input);
  }
}
