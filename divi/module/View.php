<?php

namespace cw\divi\module;

class View{
  protected $variables = [];
  protected $parent;
  use \cw\view\helpers\traits\Html;

  public function __construct(\cw\divi\module\Extension $parent){
    $this->parent = $parent;
  }

  public function renderModule($view, $variables=[]){
    $this->variables = $variables;

    return $this->_render(
      CW_DIVI_MODULES_FOLDER . '/views/module-wrapper.php',[
        'module_view_file' => $view,
        'view_attributes'  => $variables,
        'data'             => $this->renderData(),
        'module_id'        => $this->getModuleIdWithAttributeIfPresent(),
        'main_css_class'   => $this->parent->main_css_class
    ]);
  }

  public function render($view, $variables=[]){
    return $this->_render($this->parent->path . '/' . $view, $variables);
  }

  public function _render($view, $variables=[]){
    ob_start();

      extract($variables);
      include $view;

    return ob_get_clean();
  }

  public function renderData(){
    if(!isset($this->variables['data']) || !is_array($data) || empty($data))
      return '';

    $tmp = array_map(function($key, $value){
      return 'data-'.$key.'="'.$value.'"';
    }, array_keys($data),$data);

    return implode(' ', $tmp);
  }

  public function getModuleClassIfPresent(){
    if(!isset($this->variables['module_class']))
      return '';

    $module_class = $this->variables['module_class'];
    $module_class = \ET_Builder_Element::add_module_order_class( $module_class, $function_name );
    $module_class = $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '';
    return $module_class;
  }

  public function getModuleIdWithAttributeIfPresent(){
    if(!isset($this->variables['module_id']))
      return '';

    $module_id = $this->variables['module_id'];
    $module_id = $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '';
    return $module_id;
  }

  public function __call($method, $args) {
    return call_user_func_array($this->parent, $args);
  }


}
