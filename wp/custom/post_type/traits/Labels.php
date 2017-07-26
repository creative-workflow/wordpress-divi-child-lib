<?php

namespace cw\wp\custom\post_type\traits;

trait Labels{
  use \cw\wp\custom\traits\Labels ;

  public function adminBarName($key){
    return $this->label('name_admin_bar', _x($key, 'add new on admin bar', $this->textDomain));
  }

  public function labelAddNew($key){
    return $this->label('add_new', _x($key, 'book', $this->textDomain));
  }

  public function labelNewItem($key){
    return $this->label('new_item', __($key, $this->textDomain));
  }

  public function labelViewItem($key){
    return $this->label('view_item', __($key, $this->textDomain));
  }

  public function labelNotFoundInTrash($key){
    return $this->label('not_found_in_trash', __($key, $this->textDomain));
  }

  public function description($description){
    $this->args['description'] = __( $description, $this->textDomain);
    return $this;
  }
}
