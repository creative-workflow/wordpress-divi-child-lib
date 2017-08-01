<?php

namespace cw\wp\woocommerce;

class Helper{
  public static function setHomeBreadcrumb($name, $url){
    add_filter( 'woocommerce_breadcrumb_defaults',  function($defaults) use($name){
      $defaults['home'] = $name;
      return $defaults;
    });

    add_filter( 'woocommerce_breadcrumb_home_url',  function() use($url){
      return $url;
    }, 11, 1);
  }

}
