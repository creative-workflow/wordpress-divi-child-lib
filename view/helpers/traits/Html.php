<?php

namespace cw\view\helpers\traits;

trait Html{
  public static $voidElements = [
        'area' => 1,
        'base' => 1,
        'br' => 1,
        'col' => 1,
        'command' => 1,
        'embed' => 1,
        'hr' => 1,
        'img' => 1,
        'input' => 1,
        'keygen' => 1,
        'link' => 1,
        'meta' => 1,
        'param' => 1,
        'source' => 1,
        'track' => 1,
        'wbr' => 1,
    ];
    /**
     * @var array the preferred order of attributes in a tag. This mainly affects the order of the attributes
     * that are rendered by [[renderTagAttributes()]].
     */
    public static $attributeOrder = [
        'type',
        'id',
        'class',
        'name',
        'value',

        'href',
        'src',
        'srcset',
        'form',
        'action',
        'method',

        'selected',
        'checked',
        'readonly',
        'disabled',
        'multiple',

        'size',
        'maxlength',
        'width',
        'height',
        'rows',
        'cols',

        'alt',
        'title',
        'rel',
        'media',
    ];

  public static $dataAttributes = ['data', 'data-ng', 'ng'];

  public function tel($text, $number = null, $options = []){
    $tel =  ($number === null ? $text : $number);
    $options['href'] = 'tel:' . $this->format_tel($number);
    return $this->tag('a', $text, $options);
  }

  public function format_tel($number){
    return str_replace([' ', '/','-'], '', $number);
  }

  public function a($text, $url = null, $options = []){
    $url = ($url === null ? $text : $url);

    $options['href'] = $url;

    return $this->tag('a', $text, $options);
  }

  public function mailto($text, $email = null, $options = []){
    $options['href'] = 'mailto:' . ($email === null ? $text : $email);
    return $this->tag('a', $text, $options);
  }

  public function image($src, $options = []){
    $options['src'] = $src;

    if (isset($options['srcset']) && is_array($options['srcset'])) {
      $srcset = [];
      foreach ($options['srcset'] as $descriptor => $url) {
        $srcset[] = $url . ' ' . $descriptor;
      }
      $options['srcset'] = implode(',', $srcset);
    }

    if (!isset($options['alt']))
      $options['alt'] = '';

    return $this->tag('img', '', $options);
  }

  public function label($content, $for = null, $options = []){
    $options['for'] = $for;
    return $this->tag('label', $content, $options);
  }

  public function button($content = 'Button', $options = []){
    if (!isset($options['type']))
      $options['type'] = 'button';

    return $this->tag('button', $content, $options);
  }

  public  function submitButton($content = 'Submit', $options = []){
    $options['type'] = 'submit';
    return $this->button($content, $options);
  }

  public function resetButton($content = 'Reset', $options = []){
    $options['type'] = 'reset';
    return $this->button($content, $options);
  }

  public function input($type, $name = null, $value = null, $options = []){
    if (!isset($options['type']))
      $options['type'] = $type;

    $options['name'] = $name;
    $options['value'] = $value === null ? null : (string) $value;
    return $this->tag('input', '', $options);
  }

  public function buttonInput($label = 'Button', $options = []){
    $options['type'] = 'button';
    $options['value'] = $label;
    return $this->tag('input', '', $options);
  }

  public function submitInput($label = 'Submit', $options = []){
    $options['type'] = 'submit';
    $options['value'] = $label;
    return $this->tag('input', '', $options);
  }

  public function resetInput($label = 'Reset', $options = []){
    $options['type'] = 'reset';
    $options['value'] = $label;
    return $this->tag('input', '', $options);
  }

  public function textInput($name, $value = null, $options = []){
    return $this->input('text', $name, $value, $options);
  }

  public function hiddenInput($name, $value = null, $options = []){
    return $this->input('hidden', $name, $value, $options);
  }

  public function passwordInput($name, $value = null, $options = []){
    return $this->input('password', $name, $value, $options);
  }

  public function fileInput($name, $value = null, $options = []){
    return $this->input('file', $name, $value, $options);
  }

  public function textarea($name, $value = '', $options = []){
    $options['name'] = $name;
    return $this->tag('textarea', $this->encode($value, $doubleEncode), $options);
  }

  public function radio($name, $checked = false, $options = []){
    return $this->booleanInput('radio', $name, $checked, $options);
  }

  public function checkbox($name, $checked = false, $options = []){
    return $this->booleanInput('checkbox', $name, $checked, $options);
  }

  protected function booleanInput($type, $name, $checked = false, $options = []){
    $options['checked'] = (bool) $checked;
    $value = array_key_exists('value', $options) ? $options['value'] : '1';
    if (isset($options['uncheck'])) {
      // add a hidden field so that if the checkbox is not selected, it still submits a value
      $hiddenOptions = [];
      if (isset($options['form']))
        $hiddenOptions['form'] = $options['form'];

      $hidden = $this->hiddenInput($name, $options['uncheck'], $hiddenOptions);
      unset($options['uncheck']);
    } else {
      $hidden = '';
    }
    if (isset($options['label'])) {
      $label = $options['label'];
      $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : [];
      unset($options['label'], $options['labelOptions']);
      $content = $this->label($this->input($type, $name, $value, $options) . ' ' . $label, null, $labelOptions);
      return $hidden . $content;
    } else {
      return $hidden . $this->input($type, $name, $value, $options);
    }
  }

  public function tag($name, $content = '', $options = []){
    if ($name === null || $name === false)
        return $content;

    $html = "<$name" . static::renderTagAttributes($options) . '>';
    return isset(static::$voidElements[strtolower($name)]) ? $html : "$html$content</$name>";
  }

  public function beginTag($name, $options = []){
    if ($name === null || $name === false) {
        return '';
    }
    return "<$name" . $this->renderTagAttributes($options) . '>';
  }

  public function endTag($name){
    if ($name === null || $name === false) {
        return '';
    }
    return "</$name>";
  }

  public function style($content, $options = []){
    return $this->tag('style', $content, $options);
  }

  public function script($content, $options = []){
    return $this->tag('script', $content, $options);
  }

  public function renderTagAttributes($attributes){
      if (count($attributes) > 1) {
        $sorted = [];
        foreach (static::$attributeOrder as $name) {
          if (isset($attributes[$name])) {
            $sorted[$name] = $attributes[$name];
          }
        }
        $attributes = array_merge($sorted, $attributes);
      }

      $html = '';
      foreach ($attributes as $name => $value) {
        if (is_bool($value)) {
          if ($value){
            $html .= " $name";
          }
        } elseif (is_array($value)) {
          if (in_array($name, static::$dataAttributes)) {
            foreach ($value as $n => $v) {
              if (is_array($v)) {
                $html .= " $name-$n='" . Json::htmlEncode($v) . "'";
              } else {
                $html .= " $name-$n=\"" . static::encode($v) . '"';
              }
            }
          } elseif ($name === 'class') {
            if (empty($value)) {
              continue;
            }
            $html .= " $name=\"" . static::encode(implode(' ', $value)) . '"';
          } elseif ($name === 'style') {
            if (empty($value)) {
              continue;
            }
            $html .= " $name=\"" . static::encode(static::cssStyleFromArray($value)) . '"';
          } else {
            $html .= " $name='" . Json::htmlEncode($value) . "'";
          }
      } elseif ($value !== null) {
        $html .= " $name=\"" . static::encode($value) . '"';
      }
    }

    return $html;
  }

  public static function encode($content, $doubleEncode = true){
    return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
  }

  public static function decode($content){
    return htmlspecialchars_decode($content, ENT_QUOTES);
  }

  public static function cssStyleFromArray(array $style){
    $result = '';
    foreach ($style as $name => $value)
      $result .= "$name: $value; ";

    // return null if empty to avoid rendering the "style" attribute
    return $result === '' ? null : rtrim($result);
  }
}
