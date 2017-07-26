<?php

namespace cw\wp\custom\taxanomy\traits;

trait Labels{
  use \cw\wp\custom\traits\Labels;

  public function labelPopularItems($key){
    return $this->label('popular_items', __($key, $this->textDomain));
  }

  public function labelParentItem($key){
    return $this->label('parent_item', __($key, $this->textDomain));
  }

  public function labelUpdateItem($key){
    return $this->label('update_item', __($key, $this->textDomain));
  }

  public function labelNewItemName($key){
    return $this->label('new_item_name', __($key, $this->textDomain));
  }

  public function labelSeperateItemsWithCommas($key){
    return $this->label('separate_items_with_commas', __($key, $this->textDomain));
  }

  public function labelAddOrRemoveItems($key){
    return $this->label('add_or_remove_items', __($key, $this->textDomain));
  }

  public function labelChooseFromMostUsed($key){
    return $this->label('choose_from_most_used', __($key, $this->textDomain));
  }
}
