<?php
/**
 * Fssnet Logs controller
 *
 * @category    Controller
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_RedirectlogController extends Mage_Adminhtml_Controller_Action {
	/**
	* Load grid page
	*/
	public function indexAction() {
		$this->_title( $this->__( 'FSS Net Logs' ) );
		$this->_title( $this->__( 'FSS Net Redirect Log' ) );
		
		$this->_initAction();
		
		$this->loadLayout();
		$block = Mage::app()->getLayout()->createBlock( 'fssnet/redirectlog' );
		$this->getLayout()->getBlock( 'content' )->append( $block );
		$this->renderLayout();
	}
	
	/**
	* Init action
	*/
	protected function _initAction() {
		$this->loadLayout()->_setActiveMenu( 'fssnet/fssnetredirect' )->_addBreadcrumb( Mage::helper('adminhtml' )->__( 'FSS Net Redirect Log' ),Mage::helper( 'adminhtml' )->__( 'FSS Net Redirect Log' ) );
		return $this;
	}
	
	/**
	* Export order grid to CSV format
	*/
	public function exportCsvAction() {
		$file_name  = 'fssnet_redirect_log.csv';
		$grid       = $this->getLayout()->createBlock( 'fssnet/redirectlog_grid' );
		$this->_prepareDownloadResponse( $file_name, $grid->getCsvFile() );
	} 
	
	/**
	*  Export order grid to Excel XML format
	*/
	public function exportExcelAction() {
		$file_name  = 'fssnet_redirect_log.xml';
		$grid       = $this->getLayout()->createBlock( 'fssnet/redirectlog_grid' );
		$this->_prepareDownloadResponse( $file_name, $grid->getExcelFile( $file_name ) );
	}
}