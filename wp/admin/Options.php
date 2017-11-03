<?php

namespace cw\wp\admin;

class Options{
  public $id;
  public $menuName;
  public $options = [];

  public function __construct($id, $menuName = '', $options = []){
    $this->id = $id;
    $this->menuName  = $menuName;
    $this->options   = $options;
    $this->bootstrap();
  }

  protected function bootstrap(){
    add_action( 'admin_init', [$this, 'registerSettings'] );
    add_action( 'admin_menu', [$this, 'createMenu'] );
  }

  public function adminBarName($name){
    $this->menuName = $name;
    return $this;
  }

  public function typeText($id, $displayName, $default = null, $jsExport=true){
    $this->options[$id]= [
      'display_name' => $displayName,
      'type'         => 'text',
      'default'      => $default,
      'js_export'    => $jsExport
    ];

    return $this;
  }

  public function typeTextArea($id, $displayName, $default = null, $jsExport=true){
    $this->options[$id]= [
      'display_name' => $displayName,
      'type'         => 'textarea',
      'default'      => $default,
      'js_export'    => $jsExport
    ];

    return $this;
  }

  public function typePlain($id, $displayName, $default = null, $jsExport=true){
    $this->options[$id]= [
      'display_name' => $displayName,
      'type'         => 'plain',
      'default'      => $default,
      'js_export'    => $jsExport
    ];

    return $this;
  }

  public function typeHidden($id, $displayName, $default = null, $jsExport=true){
    $this->options[$id]= [
      'display_name' => $displayName,
      'type'         => 'hidden',
      'default'      => $default,
      'js_export'    => $jsExport
    ];

    return $this;
  }

  public function createMenu() {
    add_menu_page($this->menuName,
                  $this->menuName,
                  'administrator',
                  $this->id,
                  [$this, 'renderSettingsPage']);
  }

  public function registerSettings() {
    foreach($this->options as $optionName => $optionConfig)
      register_setting( $this->id, $optionName );
  }

  public function toJsObject(){
    $options = [];
    foreach($this->options as $optionName => $optionConfig){
      if($optionConfig['js_export'])
        $options[] = "'$optionName': '".$this->{$optionName}."'";
    }

    return 'var '.$this->id.' = { '. implode(',', $options) .' };';
  }

  public function toJsFile($file){
    return file_put_contents($file, $this->toJsObject());
  }

  public function renderSettingsPage() {
    echo '<div class="wrap wordpress-options">';
      echo '<h1>'.$this->menuName.'</h1>';
      echo '<form method="post" action="options.php">';
        settings_fields( $this->id );
        do_settings_sections( $this->id );

        echo '<table class="form-table" style="width: 100%">';
        foreach($this->options as $optionName => $optionConfig){
          echo '<tr valign="top">';
            echo '<th scope="row" class="label">'.$optionConfig['display_name'].'</th>';
            echo '<td class="value">';
              echo $this->renderSetting($optionName, $optionConfig);
            echo '</td>';
          echo '</tr>';
        }
        echo '</table>';

        submit_button();
      echo '</form>';
    echo '</div>';
  }

  public function renderSetting($name, $config){
    switch($config['type']){
      case 'plain':
        return @$config['default'];
      case 'textarea':
        $value = esc_attr( get_option($name, @$config['default']) );
        return '<textarea name="'.$name.'">'.$value.'</textarea>';
      break;
      case 'text':
      default:
        $value = esc_attr( get_option($name, @$config['default']) );
        return '<input type="text" name="'.$name.'" value="'.$value.'"/>';
      break;
      case 'hidden': break;
    }
  }

  public function __get($id){
    $default = null;
    if(isset($this->options[$id]))
      $default = $this->options[$id]['default'];

    return get_option($id, $default);
  }
}
