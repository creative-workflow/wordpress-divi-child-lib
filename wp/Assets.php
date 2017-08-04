<?php

namespace cw\wp;

class Assets{
  public function conditional($callable){
    add_action('wp_enqueue_scripts', function() use($callable){
      call_user_func($callable, $this);
    });

    return $this;
  }

  public function addStylesheet($handle, $uri, $dependencies = [], $version = 1){
    $uri = $this->expandPath($uri);

    add_action('wp_enqueue_scripts', function() use($handle, $uri, $dependencies, $version){
      wp_enqueue_style($handle, $uri, $dependencies, $version);
    });

    return $this;
  }

  public function addAdminStylesheet($handle, $uri, $dependencies = [], $version = 1){
    $uri = $this->expandPath($uri);

    add_action('admin_enqueue_scripts', function() use($handle, $uri, $dependencies, $version){
      wp_enqueue_style($handle, $uri, $dependencies, $version);
    });

    return $this;
  }

  public function addParentStylesheet($uri, $dependencies = [], $version = 1){
    $uri = get_template_directory_uri() . '/' . $uri;

    add_action('wp_enqueue_scripts', function() use($handle, $uri, $dependencies, $version){
      wp_enqueue_style('parent-style', $uri, $dependencies, $version);
    });

    return $this;
  }

  public function addScript($handle, $uri, $dependencies = [], $version = 1, $inFooter = true){
    $uri = $this->expandPath($uri);

    add_action('wp_enqueue_scripts', function() use($handle, $uri, $dependencies, $version, $inFooter){
      wp_enqueue_script($handle, $uri, $dependencies, $version, $inFooter);
    });

    return $this;
  }

  public function addInlineScript($handle, $content, $position = 'after'){
    add_action('wp_enqueue_scripts', function() use($handle, $content, $position){
      wp_add_inline_script($handle, $content, $position);
    });

    return $this;
  }

  public function expandPath($uri){
    if(strpos($uri, '://') !== false
    || strpos($uri, '//')  === 0)
      return $uri;

    return get_stylesheet_directory_uri() . '/' . $uri;
  }

  public function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
  }

  public function replaceJquery($with){
    if(is_admin() || $this->is_login_page())
      return $this;

    add_action('init', function() use($with){
      wp_deregister_script('jquery');
      wp_register_script('jquery', $with, false, false, true);
      wp_enqueue_script('jquery');
    });

    return $this;
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
