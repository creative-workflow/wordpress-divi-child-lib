<?php

namespace cw\wp\custom\traits;

trait Labels{
  public $textDomain;

  public function textDomain($name){
    $this->textDomain = $name;
    return $this;
  }

  public function label($which, $what){
    $this->labels[$which] = $what;
    return $this;
  }

  public function name($key){
    return $this->label('name', _x($key, 'post type general name', $this->textDomain));
  }

  public function menuName($key){
    return $this->label('menu_name', _x($key, 'admin menu', $this->textDomain));
  }

  public function singularName($key){
    return $this->label('singular_name', _x($key, 'post type singular name', $this->textDomain));
  }

  public function labelAddNewItem($key){
    return $this->label('add_new_item', __($key, $this->textDomain));
  }

  public function labelEditItem($key){
    return $this->label('edit_item', __($key, $this->textDomain));
  }

  public function labelAllItems($key){
    return $this->label('all_items', __($key, $this->textDomain));
  }

  public function labelSearchItems($key){
    return $this->label('search_items', __($key, $this->textDomain));
  }

  public function labelParentItemColon($key){
    return $this->label('parent_item_colon', __($key, $this->textDomain));
  }

  public function labelNotFound($key){
    return $this->label('not_found', __($key, $this->textDomain));
  }
}
