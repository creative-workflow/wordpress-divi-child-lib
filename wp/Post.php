<?php

namespace cw\wp;

class Post{
  public $post;

  public function __construct(\WP_Post $post){
    $this->post = $post;
  }

  public function title(){
    return $this->post->post_title;
  }

  public function permalink(){
    return get_permalink($this->post);
  }

  public function terms($termId){
    if(is_a($termId, '\cw\wp\custom\Taxanomy'))
      $termId = $termId->id;

    $terms = wp_get_post_terms($this->post->ID, $termId, [
      'orderby'  => 'name',
      'order'    => 'ASC'
    ]);

    return array_map(function($term){
      return new \cw\wp\custom\Term($term);
    }, $terms);
  }
}
