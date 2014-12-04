<?php
/**
 * Fssnet Logs controller
 *
 * @category    Controller
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_ResponselogController extends Mage_Adminhtml_Controller_Action {
	/**
	* Load grid page
	*/
	public function indexAction() {
		$this->_title( $this->__( 'FSS Net Logs' ) );
		$this->_title( $this->__( 'FSS Net Response Log' ) );
		
		$this->_initAction();
		
		$this->loadLayout();
		$block = Mage::app()->getLayout()->createBlock( 'fssnet/responselog' );
		$this->getLayout()->getBlock( 'content' )->append( $block );
		$this->renderLayout();
	}
	
	/**
	* Init action
	*/
	protected function _initAction() {
		$this->loadLayout()->_setActiveMenu( 'fssnet/fssnetresponse' )->_addBreadcrumb( Mage::helper('adminhtml' )->__( 'FSS Net Response Log' ),Mage::helper( 'adminhtml' )->__( 'FSS Net Response Log' ) );
		return $this;
	}
	
	/**
	* Export order grid to CSV format
	*/
	public function exportCsvAction() {
		$file_name  = 'fssnet_response_log.csv';
		$grid       = $this->getLayout()->createBlock( 'fssnet/responselog_grid' );
		$this->_prepareDownloadResponse( $file_name, $grid->getCsvFile() );
	} 
	
	/**
	*  Export order grid to Excel XML format
	*/
	public function exportExcelAction() {
		$file_name  = 'fssnet_response_log.xml';
		$grid       = $this->getLayout()->createBlock( 'fssnet/responselog_grid' );
		$this->_prepareDownloadResponse( $file_name, $grid->getExcelFile( $file_name ) );
	}
}