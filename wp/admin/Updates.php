<?php

namespace cw\wp\admin;

class Updates{
  protected static function set($what, $enable = true){
    remove_all_filters($what);
    $enableOrDisable = $enable ? '__return_true' : '__return_false';
    add_filter($what, $enableOrDisable);
  }

  public static function disableAllAutoUpdates(){
    self::set('automatic_updater_disabled');
  }

  public static function enableAllAutoUpdates(){
    self::enablePluginAutoupdates();
    self::enableThemeAutoupdates();
    self::enableTranslationAutoupdates();
    self::enableMinorCoreAutoupdates();
    self::enableMajorCoreAutoupdates();
  }

  public static function enableMinorCoreAutoUpdates(){
    self::set('allow_minor_auto_core_updates');
  }

  public static function disableMinorCoreAutoUpdates(){
    self::set('allow_minor_auto_core_updates', false);
  }

  public static function enableMajorCoreAutoUpdates(){
    self::set('allow_major_auto_core_updates');
  }

  public static function disableMajorCoreAutoUpdates(){
    self::set('allow_major_auto_core_updates', false);
  }

  public static function enablePluginAutoUpdates(){
    self::set('auto_update_plugin');
  }

  public static function disablePluginAutoUpdates(){
    self::set('auto_update_plugin', false);
  }

  public static function enableThemeAutoUpdates(){
    self::set('auto_update_theme');
  }

  public static function disableThemeAutoUpdates(){
    self::set('auto_update_theme', false);
  }

  public static function enableTranslationAutoUpdates(){
    self::set('auto_update_translation');
  }

  public static function disableTranslationAutoUpdates(){
    self::set('auto_update_translation', false);
  }
}
