<?php

namespace cw\wp\custom\post_type\traits;

trait MenuPosition{
  public function menuPosition($where){
    $this->args['menu_position'] = $where;
    return $this;
  }

  public function menuPositionBelowPosts(){
    return $this->menuPosition(5);
  }

  public function menuPositionBelowMedia(){
    return $this->menuPosition(10);
  }

  public function menuPositionBelowLinks(){
    return $this->menuPosition(15);
  }

  public function menuPositionBelowPages(){
    return $this->menuPosition(20);
  }

  public function menuPositionBelowComments(){
    return $this->menuPosition(25);
  }

  public function menuPositionBelowFirstSeparator(){
    return $this->menuPosition(60);
  }

  public function menuPositionBelowPlugins(){
    return $this->menuPosition(65);
  }

  public function menuPositionBelowUsers(){
    return $this->menuPosition(70);
  }

  public function menuPositionBelowTools(){
    return $this->menuPosition(75);
  }

  public function menuPositionBelowSettings(){
    return $this->menuPosition(80);
  }

  public function menuPositionBelowSecondSeparator(){
    return $this->menuPosition(100);
  }
}
