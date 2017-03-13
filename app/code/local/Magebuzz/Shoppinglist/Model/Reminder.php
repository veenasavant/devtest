<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Shoppinglist_Model_Reminder extends Mage_Core_Model_Abstract {
  public function _construct() {
    parent::_construct();
    $this->_init('shoppinglist/reminder');
  }	

  public function loadByCustomerId() {
    return $this->_getResource()->loadByCustomerId($this);
  }
}