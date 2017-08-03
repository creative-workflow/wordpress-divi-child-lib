<?php

namespace cw\wp\custom;

class MetaBox{
  public $id;
  public $title;
  public $screen       = null;
  public $context      = 'advanced';
  public $priority     = 'default';
  public $callback;
  public $callbackArgs = null;
  public $type         = 'html';
  public $default      = '';

  public function __construct($id){
    $this->id = $id;
    add_action('add_meta_boxes', [$this, 'publish'] );
    add_action('save_post', [$this, 'save'], 10, 2 );
  }

  public function title($name){
    $this->title = $name;
    return $this;
  }

  public function setDefault($value){
    $this->default = $value;
    return $this;
  }

  public function screen($which){
    $this->screen = $which;
    return $this;
  }

  public function context($which){
    $this->context = $which;
    return $this;
  }

  public function contextNormal(){
    return $this->context('normal');
  }

  public function contextSide(){
    return $this->context('side');
  }

  public function contextAdvanced(){
    return $this->context('advanced');
  }

  public function priority($value='default'){
    $this->priority = $value;
    return $this;
  }

  public function priorityHigh(){
    return $this->priority('high');
  }

  public function priorityLow(){
    return $this->priority('low');
  }

  public function priorityCore(){
    return $this->priority('core');
  }

  public function typeHtml(){
    $this->type = 'html';
    return $this;
  }

  public function typeText(){
    $this->type = 'text';
    return $this;
  }

  public function metaId(){
    return 'meta_' . $this->id . '_content';
  }

  public function content($post){
    $content = get_post_meta($post->ID, $this->metaId(), true);

    if($content !== '')
      return $content;

    return $this->default;
  }

  public function show($post, $metabox){
    $content = $this->content($post);
    switch($this->type){
      case 'html':
        wp_editor($content, $this->metaId(), array(
          'wpautop'       => true,
          'media_buttons' => false,
          'textarea_name' => $this->metaId(),
          'textarea_rows' => 10,
          'teeny'         => true
        ) );
      break;
      case 'text':
        echo '<input type="text" name="'.$this->metaId().'" value="'.$content.'">';
      break;
    }
  }

  public function save($post_id, $post){
    if(isset($_POST[$this->metaId()])
    && $_POST[$this->metaId()] != '')
      update_post_meta($post_id, $this->metaId(), $_POST[$this->metaId()]);

    else
      delete_post_meta($post_id, $this->metaId());
  }

  public function publish(){
    add_meta_box(
              $this->id,
              $this->title,
              [$this, 'show'],
              $this->screen,
              $this->context,
              $this->priority,
              $callbackArgs);

    return $this;
  }
}
