<?php

namespace cw\wp\action;

class Helper{
  public static function addToHead($content, $priority = 0){
    self::add('wp_head', $content, $priority);
  }

  public static function add($action, $content, $priority = 0){
    add_action($action, function () use($content){
      if(is_string($content))
        echo $content;

      else if(is_callable($content))
        $content();

    }, $priority);
  }
}
