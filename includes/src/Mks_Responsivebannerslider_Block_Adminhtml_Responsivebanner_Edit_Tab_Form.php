<?php
class Mks_Responsivebannerslider_Block_Adminhtml_Responsivebanner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("responsivebannerslider_form", array("legend"=>Mage::helper("responsivebannerslider")->__("Item information")));

				
						$fieldset->addField("title", "text", array(
						"label" => Mage::helper("responsivebannerslider")->__("Title"),
						"name" => "title",
						));
									
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('responsivebannerslider')->__('Impage'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));
						$fieldset->addField("description", "textarea", array(
						"label" => Mage::helper("responsivebannerslider")->__("Description"),
						"name" => "description",
						));
					
						$fieldset->addField("url", "text", array(
						"label" => Mage::helper("responsivebannerslider")->__("URL"),
						"name" => "url",
						));
					
						$fieldset->addField("status", "text", array(
						"label" => Mage::helper("responsivebannerslider")->__("Status"),
						"name" => "status",
						));
						$fieldset->addField("category", "select", array(
						"label" => Mage::helper("responsivebannerslider")->__("Category"),
						"name" => "category",
         					'onclick' => "",
					        'onchange' => "",
					        'value'  => '1',
			                        'values' => array('-1'=>'Please Select..'
			                        ,'3_34_17_18' => 'Men',
			                        '4_36_20_21_70' => 'Women',
			                        '65_22_19' => 'YogaWear',
			                        '5_23_26_29' => 'Kids'),
			          		'disabled' => false,				
			         		 'readonly' => false,
						));
					

				if (Mage::getSingleton("adminhtml/session")->getResponsivebannerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getResponsivebannerData());
					Mage::getSingleton("adminhtml/session")->setResponsivebannerData(null);
				} 
				elseif(Mage::registry("responsivebanner_data")) {
				    $form->setValues(Mage::registry("responsivebanner_data")->getData());
				}
				return parent::_prepareForm();
		}
}
