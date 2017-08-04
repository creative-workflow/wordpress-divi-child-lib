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

  public function terms($id){
    if(is_object($id)
    && is_a($id, '\cw\wp\custom\Taxanomy'))
      $id = $id->id;

    $terms = [];
    foreach(wp_get_post_terms($this->post->ID, $id, [
      'orderby'  => 'name',
      'order'    => 'ASC'
    ]) as $term)
      $terms[] = new \cw\wp\custom\Term($term);

    return $terms;
  }
}
