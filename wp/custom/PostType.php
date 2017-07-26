<?php

namespace cw\wp\custom;

class PostType{
  use traits\Settings;
  use post_type\traits\Labels;
  use post_type\traits\MenuPosition;
  use post_type\traits\Supports;
  use post_type\traits\Type;

  public $id;

  public $labels = [];

  public $args   = [
    'labels'             => [],
    'description'        => 'Description.',
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => ['slug' => 'todo' ],
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => []
  ];

  public function __construct($id){
    $this->id = $id;
  }

  public function hasArchive($set = true){
    $this->args['has_archive'] = $set;
    return $this;
  }

  public function publish(){
    $args           = $this->args;
    $args['labels'] = $this->labels;

    register_post_type($this->id, $args);
  }
}
