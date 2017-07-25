<?php

namespace cw\wp;

class Menu{
  public $menus = [];

  public function __construct(){
    $this->bootstrap();
  }

  protected function bootstrap(){
    add_action( 'init', [$this, 'registerMenus'] );
  }

  public function registerMenus(){
    register_nav_menus(
      $this->menus
    );
  }

  public function addMenu($name, $translationKey = null){
    if($translationKey == null)
      $translationKey = $name;
      
    $this->menus[$name] = __($translationKey);

    return $this;
  }
}
