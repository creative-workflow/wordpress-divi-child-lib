<?php

namespace cw\wp\custom\post_type\traits;

trait Type{
  public function type($which){
     $this->args['capability_type'] = $which;
     return $this;
  }

  public function typePost(){
     return $this->type('post');
  }

  public function typePage(){
     return $this->type('page');
  }

  public function typeAttachment(){
     return $this->type('attachment');
  }

  public function typeRevision(){
     return $this->type('revision');
  }

  public function typeNavMenuItem(){
     return $this->type('nav_menu_item');
  }

  public function typeCustomCss(){
     return $this->type('custom_css');
  }

  public function typeCustomizeChangeset(){
     return $this->type('customize_changeset');
  }
}
