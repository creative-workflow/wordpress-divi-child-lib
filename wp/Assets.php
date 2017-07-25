<?php

namespace cw\wp;

class Assets{
  protected $scripts = [];
  protected $inlineScripts = [];
  protected $styles = [];

  protected $adminScripts = [];
  protected $adminStyles = [];

  protected $conditionals = [];

  public function __construct(){
    $this->bootstrap();
  }

  public function conditional($callable){
    $this->conditionals[] = $callable;
    return $this;
  }

  protected function bootstrap(){
    add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
  }

  public function addStylesheet($handle, $uri, $dependencies = [], $version = 1){
    $this->styles[] = [
      'handle'       => $handle,
      'uri'          => $uri,
      'dependencies' => $dependencies,
      'version'      => $version
    ];
    return $this;
  }

  public function addAdminStylesheet($handle, $uri, $dependencies = [], $version = 1){
    $this->adminStyles[] = [
      'handle'       => $handle,
      'uri'          => $uri,
      'dependencies' => $dependencies,
      'version'      => $version
    ];
    return $this;
  }

  public function addParentStylesheet($uri, $dependencies = [], $version = 1){
    $this->addStylesheet(
                      'parent-style',
                      get_template_directory_uri() . '/' . $uri,
                      $dependencies,
                      $version
                    );
    return $this;
  }

  public function addScript($handle, $uri, $dependencies = [], $version = 1, $inFooter = true){
    $this->scripts[] = [
      'handle'       => $handle,
      'uri'          => $uri,
      'dependencies' => $dependencies,
      'version'      => $version,
      'in_footer'    => $inFooter
    ];
    return $this;
  }

  public function addInlineScript($handle, $content, $position = 'after'){
    $this->inlineScripts[] = [
      'handle'   => $handle,
      'content'  => $content,
      'position' => $position
    ];
    return $this;
  }

  public function expandPath($uri){
    if(strpos($uri, '://') !== false
    || strpos($uri, '//')  === 0)
      return $uri;

    return get_stylesheet_directory_uri() . '/' . $uri;
  }

  public function enqueueAssets(){
    foreach($this->conditionals as $conditional)
      call_user_func($conditional, $this);

    foreach($this->styles as $style){
      $uri = $this->expandPath($style['uri']);
      wp_enqueue_style($style['handle'], $uri, $style['dependencies'], $style['version']);
    }

    foreach($this->scripts as $script){
      $uri = $this->expandPath($script['uri']);
      wp_enqueue_script($script['handle'], $uri, $script['dependencies'], $script['version'], $script['in_footer']);
    }

    foreach($this->inlineScripts as $script){
      wp_add_inline_script($script['handle'], $script['content'], $script['position']);
    }
  }

  public function enqueueAdminAssets(){
    foreach($this->adminStyles as $style){
      $uri = $this->expandPath($style['uri']);

      wp_enqueue_style($style['handle'], $uri, $style['dependencies'], $style['version']);
    }

    foreach($this->adminScripts as $script){
      $uri = $this->expandPath($script['uri']);

      wp_enqueue_script($script['handle'], $uri, $script['dependencies'], $script['version'], $script['in_footer']);
    }
  }

  public function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
  }

  protected $replaceJquery;
  public function replaceJquery($with = null){
    if(is_admin() || $this->is_login_page())
      return $this;

    if($with){
      $this->replaceJquery = $with;
      add_action('init', [$this, 'replaceJquery']);
      return $this;
    }

    if(!$this->replaceJquery || is_admin())
      return ;

    wp_deregister_script('jquery');
    wp_register_script('jquery', $this->replaceJquery, false, false, true);
    wp_enqueue_script('jquery');
  }

  public function removeEmojiScript(){
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    return $this;
  }

  public function touchAfterPostUpdated($file = null){
    if($file === null)
      $file = get_stylesheet_directory().'/functions.php';

    add_action( 'post_updated', function() use($file){
      touch($file);
    }, 10, 3 );
    return $this;
  }

  public function deregisterScripts($scripts = []){
    if(!is_array($scripts)) $scripts = [$scripts];

    add_action( 'wp_print_scripts', function() use($scripts){
      foreach($scripts as $script)
        wp_dequeue_script($script);
    }, 100 );
    return $this;
  }

  public function deregisterStyles($styles = []){
    if(!is_array($styles)) $styles = [$styles];

    add_action( 'wp_print_styles', function() use($styles){
      foreach($styles as $style)
        wp_dequeue_style($style);
    }, 100 );
    return $this;
  }

  public function addBodyClass($class){
    add_filter( 'body_class', function($classes) use($class){
      $classes[] = $class;
      return $classes;
    } );
    return $this;
  }

}
