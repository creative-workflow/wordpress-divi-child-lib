<?php

namespace cw\wp\custom\post_type\traits;

trait Supports{
  public function supports($what){
    $this->args['supports'][] = $what;
    return $this;
  }

  public function supportsTitle(){
    return $this->supports('title');
  }

  public function supportsEditor(){
    return $this->supports('editor');
  }

  public function supportsAuthor(){
    return $this->supports('author');
  }

  public function supportsThumbnail(){
    return $this->supports('thumbnail');
  }

  public function supportsExcerpt(){
    return $this->supports('excerpt');
  }

  public function supportsTrackbacks(){
    return $this->supports('trackbacks');
  }

  public function supportsCustomFields(){
    return $this->supports('custom-fields');
  }

  public function supportsComments(){
    return $this->supports('comments');
  }

  public function supportsRevisions(){
    return $this->supports('revisions');
  }

  public function supportsPageAttributes(){
    return $this->supports('page-attributes');
  }

  public function supportsPostFormats(){
    return $this->supports('post-formats');
  }
}
