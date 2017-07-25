<?php

namespace cw\wp;

class Options{
  public $groupName;
  public $menuName;
  public $options;

  public function __construct($groupName, $menuName, $options){
    $this->groupName = $groupName;
    $this->menuName  = $menuName;
    $this->options   = $options;
    $this->bootstrap();
  }

  protected function bootstrap(){
    add_action( 'admin_init', [$this, 'registerSettings'] );
    add_action( 'admin_menu', [$this, 'createMenu'] );
  }

  public function createMenu() {
    add_menu_page($this->menuName,
                  $this->menuName,
                  'administrator',
                  $this->groupName,
                  [$this, 'renderSettingsPage']);
  }

  public function registerSettings() {
    foreach($this->options as $optionName => $optionConfig)
      register_setting( $this->groupName, $optionName );
  }

  public function toJsObject(){
    $options = [];
    foreach($this->options as $optionName => $optionConfig)
      $options[] = "'$optionName': '".get_option($optionName)."'";

     return 'var '.$this->groupName.' = { '. implode(',', $options) .' };';
  }

  public function toJsFile($file){
    return file_put_contents($file, $this->toJsObject());
  }

  public function renderSettingsPage() {
    echo '<div class="wrap wordpress-options">';
      echo '<h1>'.$this->menuName.'</h1>';
      echo '<form method="post" action="options.php">';
        settings_fields( $this->groupName );
        do_settings_sections( $this->groupName );

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
      case 'text':
      default:
        $value = esc_attr( get_option($name, @$config['default']) );
        return '<input type="text" name="'.$name.'" value="'.$value.'"/>';
      break;
    }
  }
}
