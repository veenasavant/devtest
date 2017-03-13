<?php

class Mofluid_Buildandroid_Block_Adminhtml_Form_Edit_Tab_Configuration extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare form in tab
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('mofluid_buildandroid');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_');
        $form->setFieldNameSuffix('mofluid_build_android_config');

        $mofluid_build_config_model = Mage::getModel('mofluid_buildandroid/buildconfig');
        $mofluid_build_config_ios = $mofluid_build_config_model->getCollection()->addFieldToFilter('mofluid_platform_id',2);
        $mofluid_build_config_data = $mofluid_build_config_ios->getData(); 
        
        $mofluid_build_config = $mofluid_build_config_data[0]; 
        $build_app_configuration_fields = $form->addFieldset('mofluid_configuration', array(
            'legend'       => $helper->__('Application Configuration'),
            'class'        => 'fieldset-wide',
            'expanded'  => false,
        ));

        $build_app_configuration_fields->addField('buildandroid_appname', 'text', array(
          'name'      => 'buildandroid_appname',
          'label'     => 'Application Name',
          'value'     => $mofluid_build_config['mofluid_app_name'],
          'class' => 'validate-alpha',
          'after_element_html' => '<br> Name of your mobile application.'
        ));
        
        $build_app_configuration_fields->addField('buildandroid_bundleid', 'text', array(
          'name'      => 'buildandroid_bundleid',
          'label'     => 'Application\'s Bundle ID',
          'value'     => $mofluid_build_config['mofluid_app_bundleid'],
          'class' => 'required-entry',
          'after_element_html' => '<br> It is basically a unique identifier for you app. It is suggested to use reverse domain name with your app like "com.mofluid.appname"'
        ));
        
        $build_app_configuration_fields->addField('buildandroid_version', 'text', array(
          'name'      => 'buildandroid_version',
          'label'     => 'Version',
          'value'     =>  $mofluid_build_config['mofluid_app_version'],
          'class' => 'required-entry',
          'after_element_html' => 'Required application version for the Mobile App.',
        ));
        
        $build_app_configuration_fields->addField('buildandroid_storeid', 'select', array(
          'name'      => 'buildandroid_storeid',
          'label'     => 'Store',
          'value'     =>  $mofluid_build_config['mofluid_default_store'],
          'values'    => $this->getAvailableStores(),
          'after_element_html' => '<br />choose your avialable magento store. Note: App will work for a single store.'
        ));
        
        $build_currency_configuration_fields = $form->addFieldset('buildandroid_currency_fields', array(
            'legend'       => $helper->__('Currency Setup'),
            'class'        => 'fieldset-wide',
            'expanded'  => false,
        ));
        $mofluidcurrency = json_decode($mofluid_build_config['mofluid_default_currency']);
        $build_currency_configuration_fields->addField('buildandroid_currency', 'select', array(
          'name'      => 'buildandroid_currency',
          'label'     => 'Default Currency',
          'value'     =>  $mofluidcurrency->code,
          'values'    => $this->getAvailableCurrency(),
          'after_element_html' => '<br />Allow Multiple Currency in System>>Configuration>>General>>Currency Setup>>Currency Options>>Allowed Currencies.',
          
        ));
        
        $build_themes_configuration_fields = $form->addFieldset('buildandroid_themes_fields', array(
            'legend'       => $helper->__('Mobile App Theme Setup'),
            'class'        => 'fieldset-wide',
            'expanded'  => false,
        ));
        $build_themes_configuration_fields->addField('buildandroid_themes', 'select', array(
          'name'      => 'buildandroid_themes',
          'label'     => 'Active Theme',
          'value'     =>  $mofluid_build_config['mofluid_default_theme'],
          'values'    => $this->getAvailableThemes(),
          'after_element_html' => '<br />Select Available Mofluid Themes, Make sure you have correctly configure the Theme under Mofluid>>ThemeConfiguration.',
          
        ));
        //echo "<pre>"; print_r($store_arr); die;
       if (Mage::registry('mofluid_buildandroid')) {
            $form->setValues(Mage::registry('mofluid_buildandroid')->getData());
        }

        $this->setForm($form);
        return parent::_prepareForm();      
    }
    public function getAvailableCurrency() {
       $currencyCodes = explode(',', Mage::getStoreConfig('currency/options/allow'));
       $currencies = array();
       foreach($currencyCodes as $key=>$value) {
           $currencies[$key] = array(
               'value' => $value, 
               'label' => Mage::app()->getLocale()->getTranslation($value, 'nametocurrency')
           );
       }
      return $currencies;
    }
    public function getAvailableStores() {
        $stores = Mage::app()->getStores();
        $store_arr = array();
        foreach ($stores as $store) {
            $store_arr[]= array(
               'value' => $store->getId(),
               'label' => $store->getName()
            );
        }
        return $store_arr; 	
    }
    public function getAvailableThemes() {
        try {
			$mofluid_theme_model = Mage::getModel('mofluid_thememofluidelegant/thememofluidelegant');
			if($mofluid_theme_model == null || $mofluid_theme_model == "") {
				$theme_arr[]= array(
				   'value' => "modern",
				   'label' => "Modern"
				);
				 return $theme_arr;
			}
			else {
				$mofluid_theme = $mofluid_theme_model->getCollection();
				$mofluid_theme_data =$mofluid_theme->getData();
				$stores = Mage::app()->getStores();
				$store_arr = array();
				foreach ($mofluid_theme_data as $key=>$theme) {
					$theme_arr[]= array(
					   'value' => $theme["mofluid_theme_code"],
					   'label' => $theme["mofluid_theme_title"]
					);
				}
				foreach ($theme_arr as $index => $data) {
                                        if ($data['value'] == 'elegant') {
                                                unset($theme_arr[$index]);
                                        }
                }
				
				return $theme_arr;
			}
        }
        catch(Exception $ex) {
            $theme_arr[]= array(
               'value' => "modern",
               'label' => "Modern"
            );
             return $theme_arr;
        }
        
        
    }


}
