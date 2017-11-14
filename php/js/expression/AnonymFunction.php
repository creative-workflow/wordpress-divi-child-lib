<?php

namespace cw\php\js\expression;

class AnonymFunction extends Raw{
  public function toJs(){
    return "function(){ $this->js }";
  }
}
