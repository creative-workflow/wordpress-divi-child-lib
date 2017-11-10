<?php

namespace cw\html\data;

class Helper{
  public static function arrayToAttributes($data, $seperator=' '){
    $tmp = [];
    foreach($data as $key => $value){
      $tmp[]="$key=\"$value\"";
    }

    return implode($seperator, $tmp);
  }
}
