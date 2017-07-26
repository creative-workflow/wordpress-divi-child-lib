<?php

namespace cw\wp\custom\traits;

trait Settings{
  public function rewrite($config){
    $this->args['rewrite'] = $config;
    return $this;
  }

  public function slug($name, $withCategory = true){
    return $this->rewrite([
                            'slug' => $name,
                            'with_front' => $withCategory
                          ]);
  }

  public function isPublic($set = true){
    $this->args['public'] = $set;
    return $this;
  }

  public function isPubliclyQueryable($set = true){
    $this->args['publicly_queryable'] = $set;
    return $this;
  }

  public function showInUi($set = true){
    $this->args['show_ui'] = $set;
    return $this;
  }

  public function showInMenu($set = true){
    $this->args['show_in_menu'] = $set;
    return $this;
  }

  public function queryVar($queryVar){
    $this->args['query_var'] = $queryVar;
    return $this;
  }

  public function isHierarchical($set = true){
    $this->args['hierarchical'] = $set;
    return $this;
  }
}
