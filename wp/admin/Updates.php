<?php

namespace cw\wp\admin;

class Updates{
  public static function disableAllAutoUpdates(){
    add_filter('automatic_updater_disabled', '__return_true');
  }

  public static function enableAllAutoUpdates(){
    self::enablePluginAutoupdates();
    self::enableThemeAutoupdates();
    self::enableTranslationAutoupdates();
    self::enableMinorCoreAutoupdates();
    self::enableMajorCoreAutoupdates();
  }

  public static function enableMinorCoreAutoupdates(){
    add_filter( 'allow_minor_auto_core_updates', '__return_true' );
  }

  public static function enableMajorCoreAutoupdates(){
    add_filter( 'allow_major_auto_core_updates', '__return_true' );
  }

  public static function enablePluginAutoupdates(){
    add_filter('auto_update_plugin', '__return_true');
  }

  public static function enableThemeAutoupdates(){
    add_filter('auto_update_theme', '__return_true');
  }

  public static function enableTranslationAutoupdates(){
    add_filter('auto_update_translation', '__return_true');
  }
}
