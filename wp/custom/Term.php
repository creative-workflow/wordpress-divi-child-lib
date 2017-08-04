<?php

namespace cw\wp\custom;

class Term{
  public $taxanomy;
  public $term;
  public $parent;
  public $name;
  public $termId;

  public function __construct($term, \cw\wp\custom\Taxanomy $taxanomy = null, $parent = null){
    $this->term     = $term;
    $this->id       = $term->term_id;
    $this->name     = $term->name;
    $this->taxanomy = $taxanomy;
    $this->parent   = $parent;
  }

  public function posts($postClass=null){
    $posts = get_posts(
      [
        'posts_per_page' => -1,
        'post_type' => $this->taxanomy->objectType,
        'tax_query' => [
          [
            'taxonomy' => $this->taxanomy->id,
            'field' => 'term_id',
            'terms' => $this->id,
          ]
        ]
      ]
    );

    if($postClass !== null){
      $posts = array_map(function ($post) use($postClass){
        return new $postClass($post);
      }, $posts);
    }

    return $posts;
  }

  public function children(){
    $children = get_categories(
      [ 'parent' => $this->id ]
    );

    $children = [];
    foreach($children as $child){
      $children[]=new Term($child, $taxanomy, $this);
    }

    return $children;
  }

  public function __toString(){
    return $this->name;
  }
}
