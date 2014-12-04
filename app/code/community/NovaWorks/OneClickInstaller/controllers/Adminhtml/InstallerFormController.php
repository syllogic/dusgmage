<?php

class NovaWorks_OneClickInstaller_Adminhtml_InstallerFormController extends Mage_Adminhtml_Controller_Action
{
    protected $_storeId = null;

    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }
    
		protected function deleteBlock($id){
	        $block = Mage::getModel('cms/block')
	                ->setStoreId($this->_storeId)
	                ->load($id);
	
			$block->delete();
		}
    
    public function uninstallAction()
    {
		$post = $this->getRequest()->getPost();
		$message = "";
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
			$storeId = $post['design']['store_id'];		
			$this->_storeId = $storeId;	
			
			$this->deleteBlock('home_3_banner');
			$this->deleteBlock('detail_product_right');
			$this->deleteBlock('block-top-left');
			$this->deleteBlock('block_custom_menu');
			$this->deleteBlock('block_custom_slidebar_2');
			$this->deleteBlock('block_custom_slidebar_3');
			$this->deleteBlock('block_detail_product_page_1');
			$this->deleteBlock('block_detail_product_page_2');
			$this->deleteBlock('aditional_footer_right');
			$this->deleteBlock('aditional_footer_left');
			$this->deleteBlock('block_top_cart');
			$this->deleteBlock('block_contact_top');
			$this->deleteBlock('block_contact_bottom');
			$this->deleteBlock('block_header_right');
			$this->deleteBlock('block_bottom_info');
			$this->deleteBlock('block_bottom_right');
			$this->deleteBlock('block_about_box');
			$this->deleteBlock('block_home_who');
			$this->deleteBlock('block_contact_box');
			$this->deleteBlock('block-easy-slider-1');
			$this->deleteBlock('block-easy-slider-2');
			$this->deleteBlock('block_brand_list');
			if($storeId == 0) {
				$scope = 'default';
			}else{
				$scope = 'stores';
			}
			Mage::getConfig()->saveConfig('design/package/name','default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/template', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/skin', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/layout', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/default', 'default', $scope, $storeId);
			
			$message = $this->__('highlander theme was uninstalled successfully. ');
			Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
		$this->_redirect('*/*');		
    }
    public function installAction()
    {
      $post = $this->getRequest()->getPost();
      $message = "";
      try {
      	if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
        }
				$storeId 			= $post['design']['store_id'];
				$InstallBlock 	= $post['design']['install_block'];
				$InstallSlideshow 	= $post['design']['install_slideshow'];
				$stores = array($storeId); 	//Used at all blocks
				$RootCategoryId = Mage::app()->getStore($storeId)->getRootCategoryId();			
				$novaworks_uploaded = false;
				$design = Mage::getModel('core/design_package')->getPackageList();
				foreach ($design as $package){
					if($package == "novaworks") {
						$novaworks_uploaded = true;
						break;
					}
				}
				if (!$novaworks_uploaded){
					Mage::throwException($this->__('highlander Theme was not found. Please upload the theme first.'));				
				}					
				if($storeId == 0) {
					$scope = 'default';
				}else{
					$scope = 'stores';
				}
				//Configuration 
				//Design
				Mage::getConfig()->saveConfig('design/package/name', "novaworks", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/template', "highlander", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/skin', "highlander", $scope, $storeId);		
				Mage::getConfig()->saveConfig('design/theme/layout', "highlander", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/default', "highlander", $scope, $storeId);
				//Coppyright
				Mage::getConfig()->saveConfig('design/footer/copyright', "&copy; 2013 highlander Theme. All Rights Reserved. Designed by <a href=\"http://novaworks.net/\" title=\"Novaworks\">Novaworks</a>",$scope, $storeId);
				//Header
				Mage::getConfig()->saveConfig('design/header/logo_src', "images/logo.png", $scope, $storeId);
				//Setup Static Block							
				
				$model = Mage::getModel('core/store');
				$storeName = Mage::getModel('core/store')->load($storeId)->getName();
				$storeCode = Mage::getModel('core/store')->load($storeId)->getCode();
				$store = Mage::app()->getStore($storeId);
			
				$message = $this->__('highlander Theme was successfully installed on <i>'.$storeName.'</i>!');
        Mage::getSingleton('adminhtml/session')->addSuccess($message);
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
      }
      $this->_redirect('*/*');
		}    
}