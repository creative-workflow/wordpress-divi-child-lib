<?php

namespace cw\wp\template;

class Helper{
  public static function pageTemplate(){
    return get_query_template('page');
  }

  public static function postTemplate(){
    return get_query_template('single');
  }
}
