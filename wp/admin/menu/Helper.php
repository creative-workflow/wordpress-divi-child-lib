<?php

namespace cw\wp\admin\menu;

class Helper{
  public static function renameItem($oldName, $newName) {
    add_action('admin_menu', function() use($oldName, $newName){
      global $menu;
      foreach($menu as &$menuItem){
        if($menuItem[0] === $oldName){
          $menuItem[0] = $newName;
          break;
        }
      }
    });
  }

  public static function removeItem($name){
    add_action( 'admin_menu', function() use($name){
      global $menu;
      $menu = array_filter($menu, function($e) use($name){
        return $e[0] != $name;
      });
    });
  }
}
