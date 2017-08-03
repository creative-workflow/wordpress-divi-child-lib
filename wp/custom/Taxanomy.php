<?php

namespace cw\wp\custom;

class Taxanomy{
  use traits\Settings;
  use taxanomy\traits\Labels;

  public $id;
  public $objectType;

  public $labels = [];

  public $args   = [
    'labels'             => [],
    'hierarchical'          => false,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'writer' ),
  ];

  public function __construct($id){
    $this->id = $id;
  }

  public function setObjectType($objectType){
    if(is_object($objectType)
    && is_a($objectType, '\cw\wp\custom\PostType'))
      $objectType = $objectType->id;

    $this->objectType = $objectType;
    return $this;
  }

  public function showAdminColumn($set = true){
    $this->args['show_admin_column'] = $set;
    return $this;
  }

  public function updateCountCallback($set = '_update_post_term_count'){
    $this->args['update_count_callback'] = $set;
    return $this;
  }

  public function terms(){
    $terms = [];
    foreach(get_categories([
      'taxonomy' => $this->id,
      'orderby'  => 'name',
      'order'    => 'ASC'
    ]) as $term)
      $terms[] = new \cw\wp\custom\Term($term, $this);

    return $terms;
  }

  public function publish(){
    $args           = $this->args;
    $args['labels'] = $this->labels;

    register_taxonomy($this->id, $this->objectType, $args);
  }
}
