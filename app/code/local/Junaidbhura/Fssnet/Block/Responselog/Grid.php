<?php
/**
 * Fssnet Response Log Grid Block
 *
 * @category    Block
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_Block_Responselog_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	/**
	* Constructor
	*/
	public function __construct() {
		parent::__construct();
		$this->setId("fssnetresponseGrid");
		$this->setDefaultSort("fssnet_response_id");
		$this->setDefaultDir("DESC");
		$this->setSaveParametersInSession(true);
	}
	
	/**
	* Prepare collection
	*/
	protected function _prepareCollection() {
		$collection = Mage::getModel("fssnet/fssnetresponse")->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	/**
	* Prepare columns
	*/
	protected function _prepareColumns() {
		// Add columns to grid
		$this->addColumn( 'fssnet_response_id', array(
			'header' => Mage::helper( 'fssnet' )->__( 'ID' ),
			'align' => 'right',
			'width' => '50px',
			'type' => 'number',
			'index' => 'fssnet_response_id',
		));
		$this->addColumn( 'response_ip', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Response IP' ),
			'type' => 'text',
			'index' => 'response_ip',
		));
		$this->addColumn( 'error', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Error' ),
			'type' => 'text',
			'index' => 'error',
		));
		$this->addColumn( 'error_text', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Error Text' ),
			'type' => 'text',
			'index' => 'error_text',
		));
		$this->addColumn( 'paymentid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Payment ID' ),
			'type' => 'text',
			'index' => 'paymentid',
		));
		$this->addColumn( 'trackid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Track ID' ),
			'type' => 'text',
			'index' => 'trackid',
		));
		$this->addColumn( 'result', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Result' ),
			'type' => 'text',
			'index' => 'result',
		));
		$this->addColumn( 'tranid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Tran ID' ),
			'type' => 'text',
			'index' => 'tranid',
		));
		$this->addColumn( 'amt', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Amount' ),
			'type' => 'text',
			'index' => 'amt',
		));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
		$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));
		
		// Return columns
		return parent::_prepareColumns();
	}
	
	/**
	* Row URL link
	*/
	public function getRowUrl($row) {
		return '#';
	}
}