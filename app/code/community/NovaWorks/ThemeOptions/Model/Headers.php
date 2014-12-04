<?php class NovaWorks_ThemeOptions_Model_Headers
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('themeoptions')->__('Default Header')),
            array('value'=>'custom-header-1', 'label'=>Mage::helper('themeoptions')->__('Custom Header 1')),
            array('value'=>'custom-header-2', 'label'=>Mage::helper('themeoptions')->__('Custom Header 2')),
            array('value'=>'custom-header-3', 'label'=>Mage::helper('themeoptions')->__('Custom Header 3'))          
        );
    }

}?>