<?php

namespace cw\wp\polylang;

class Helper{
  public static function currentLanguage(){
    return substr(pll_current_language('locale'), 0, 2);
  }

  public static function isLanguage($input){
    return static::currentLanguage() === $input;
  }
}
