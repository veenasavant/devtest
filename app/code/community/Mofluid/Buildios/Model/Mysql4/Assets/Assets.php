<?php
class Mofluid_Buildios_Model_Mysql4_Assets extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('mofluid_buildios/assets', 'mofluid_assets_id'); 
    }
}
