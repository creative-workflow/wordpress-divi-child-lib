# wordpress-divi-child-lib
More information will follow some day ;P

### setup
```
git submodule add https://github.com/creative-workflow/wordpress-divi-child-lib.git ./wordpress/wp-content/themes/child/lib/cw
```

### functions.php
```php
<?php

define('CW_LIB_FOLDER',           __DIR__ . '/lib');
define('CW_DIVI_MODULES_FOLDER',  __DIR__ . '/modules');
define('CW_WP_SHORTCODES_FOLDER', __DIR__ . '/shortcodes');

foreach(glob(__DIR__ . '/initializers/*.php') as $file)
  require $file;

```

### initializers/
##### 01_autoload.php
```php
<?php

spl_autoload_register(function ($class_name) {
  $file_name = str_replace(['\\', '_'], '/', $class_name).'.php';

  $file_path = CW_LIB_FOLDER . '/' . $file_name;
  if(file_exists($file_path))
    include $file_path;

  $file_path = CW_DIVI_MODULES_FOLDER . '/' . $file_name;
  if(file_exists($file_path))
    include $file_path;
});

```


##### 02_wordpress.php
```php
<?php

// fix exception with generic server names
// see: https://wordpress.org/support/topic/wp-46-issues/
add_filter( 'wp_mail_from', function() {
  return 'info@'.$_SERVER['HTTP_HOST'];
} );

```

##### 03_options.php
```php
<?php

global $childOptions;

$childOptions = new \cw\wp\Options(
  'child_options',
  'Page-Options',
  [
    'global_footer_post_id' => [
      'display_name' => 'ID des Footer-Posts (Divi-Bibliothek)',
      'type'         => 'text',
      'default'      => ''
    ],
    'color_info' => [
      'display_name' => 'Farbinfo',
      'type'         => 'plain',
      'default'      => '
        <div class="theme-color green">
          <div class="color-monitor" style="background-color: #72ac4d"></div>
          <b>hex:</b> #72ac4d <br>
          <b>rgb:</b> rgba(114, 172, 77, 1)
        </div>
      '
    ]
  ]
);

```

##### 04_assets.php
```php
<?php

global $childOptions;

$childAssets = new \cw\wp\Assets('child');

$childAssets->addParentStylesheet('style.css')

  ->addScript('js-url',          'js/lib/js-url/url.min.js', ['jquery'])
  ->addScript('js-cookie',       'js/lib/js-cookie/src/js.cookie.js')
  ->addScript('jquery-debug',    'js/lib/jquery.debug/dist/jquery.debug.min.js', ['js-cookie', 'js-url', 'jquery'])
  ->addScript('jquery-tracking', 'js/lib/jquery.tracking/dist/jquery.tracking.min.js', ['js-cookie', 'js-url', 'jquery', 'jquery-debug'])

  ->addScript('js-cookie-consent',  '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js')

  ->addScript('child-main', 'js/main.js', ['jquery'])
  // not needed at the moment
  // ->addInlineScript('child-main', $childOptions->toJsObject(), 'before')

  ->addAdminStylesheet('child-admin-css', 'admin.css')

  ->replaceJquery('//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')
  ->removeEmojiScript()
  ->touchAfterPostUpdated();

```

##### 05_divi.php
```php
<?php

cw\divi\module\Helper::register(
  glob(CW_DIVI_MODULES_FOLDER . '/**/*Module*.php')
);

cw\divi\module\Helper::register(
  glob(CW_DIVI_MODULES_FOLDER . '/*Module*.php')
);
```

##### 06_menu.php
```
<?php
$childMenu = new \cw\wp\Menu();

$childMenu->addMenu('footer-1-menu')
          ->addMenu('footer-2-menu')
          ->addMenu('footer-3-menu');
```

### modules/
##### hallo-world/Module.php
```php
<?php

class ModuleHalloWorld extends cw\divi\module\Extension {
  public function init() {
    parent::init('cw-module-hallo-world', 'custom_hallo_world');

    $this->addDefaultFields();

    $group = $this->addGroup('main_module', 'Main')
                  ->tabGeneral();

    $group->addField('headline')
          ->label('Überschrift')
          ->typeText('Überschrift')
          ->addFontSettings('.module-headline');

    $group->addField('headline_tag')
          ->label('Überschrift-Tag')
          ->typeSelect([
            'h1' => 'h1',
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'h5' => 'h5',
            'h6' => 'h6',
            'strong' => 'strong',
            'b' => 'b',
            'div' => 'div'
          ]);

    $group->addField('text')
          ->label('Text')
          ->typeHtml()
          ->addFontSettings('.text');

    $group->addField('image')
          ->label('Bild')
          ->typeUpload()
          ->description('Geben Sie ein Bild an!')
          ->basicOption();

      return $this;
  }

  public function shortcode_callback( $atts, $content = null, $function_name ) {
    $variables = $this->shortcode_atts;
    $variables['text'] = $this->shortcode_content;

    return $this->render(
      'views/module.php',
      $variables
    );
  }
}
new ModuleTherapyMethod(__DIR__);
```

##### hallo-world/views/module.php
```php
<div class="content-wrapper">
  <div class="headline-wrapper">
    <?= $this->tag($headline_tag, $headline, ['class' => 'module-headline']) ?>
  </div>

  <div class="text">
    <?= $text ?>
  </div>
</div>

<?

  if($image)
    echo $this->image($image, ['class' => 'image']);

?>
```

##### hallo-world/css/module.sass
```sass
@import "variables"

@import "mixins/css/css3"
@import "mixins/css/positioning"
@import "mixins/helper/helper"

@import "mixins/grid/mediaqueries"
@import "mixins/grid/grid"

@import "mixins/divi"
@import "mixins/wordpress/post"


+custom-divi-module('cw-module-hallo-world')
  .image
    display: none
    +min-width-sm
      +block
      +absolute
      right: -40px
      bottom: 0

  .content-wrapper
    [...]
```
