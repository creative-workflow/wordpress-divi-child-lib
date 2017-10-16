<?php

namespace cw\wp\session;

// call this in your initializers: cw\wp\session\Helper::bootstrap();

class Helper{
  public static function bootstrap(){
    add_action('init', function(){
      if(!session_id())
          session_start();

    }, 1);
    add_action('wp_logout', 'session_destroy');
    add_action('wp_login', 'session_destroy');
  }
}
