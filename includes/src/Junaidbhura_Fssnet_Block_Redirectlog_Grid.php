<?php
/**
 * Fssnet Redirect Log Grid Block
 *
 * @category    Block
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_Block_Redirectlog_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	/**
	* Constructor
	*/
	public function __construct() {
		parent::__construct();
		$this->setId("fssnetredirectGrid");
		$this->setDefaultSort("fssnet_redirect_id");
		$this->setDefaultDir("DESC");
		$this->setSaveParametersInSession(true);
	}
	
	/**
	* Prepare collection
	*/
	protected function _prepareCollection() {
		$collection = Mage::getModel("fssnet/fssnetredirect")->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	/**
	* Prepare columns
	*/
	protected function _prepareColumns() {
		// Add columns to grid
		$this->addColumn( 'fssnet_redirect_id', array(
			'header' => Mage::helper( 'fssnet' )->__( 'ID' ),
			'align' => 'right',
			'width' => '50px',
			'type' => 'number',
			'index' => 'fssnet_redirect_id',
		));
		$this->addColumn( 'userid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Tranportal ID' ),
			'type' => 'text',
			'index' => 'userid',
		));
		$this->addColumn( 'password', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Password' ),
			'type' => 'text',
			'index' => 'password',
		));
		$this->addColumn( 'action', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Action' ),
			'type' => 'text',
			'index' => 'action',
		));
		$this->addColumn( 'langid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Lang ID' ),
			'type' => 'text',
			'index' => 'langid',
		));
		$this->addColumn( 'currencycode', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Currency Code' ),
			'type' => 'text',
			'index' => 'currencycode',
		));
		$this->addColumn( 'amt', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Amount' ),
			'type' => 'text',
			'index' => 'amt',
		));
		$this->addColumn( 'response_url', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Response URL' ),
			'type' => 'text',
			'index' => 'response_url',
		));
		$this->addColumn( 'error_url', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Error URL' ),
			'type' => 'text',
			'index' => 'error_url',
		));
		$this->addColumn( 'trackid', array(
			'header' => Mage::helper( 'fssnet' )->__( 'Track ID' ),
			'type' => 'text',
			'index' => 'trackid',
		));
		$this->addColumn( 'udf1', array(
			'header' => Mage::helper( 'fssnet' )->__( 'UDF 1' ),
			'type' => 'text',
			'index' => 'udf1',
		));
		$this->addColumn( 'udf2', array(
			'header' => Mage::helper( 'fssnet' )->__( 'UDF 2' ),
			'type' => 'text',
			'index' => 'udf2',
		));
		$this->addColumn( 'udf3', array(
			'header' => Mage::helper( 'fssnet' )->__( 'UDF 3' ),
			'type' => 'text',
			'index' => 'udf3',
		));
		$this->addColumn( 'udf4', array(
			'header' => Mage::helper( 'fssnet' )->__( 'UDF 4' ),
			'type' => 'text',
			'index' => 'udf4',
		));
		$this->addColumn( 'udf5', array(
			'header' => Mage::helper( 'fssnet' )->__( 'UDF 5' ),
			'type' => 'text',
			'index' => 'udf5',
		));
		$this->addColumn( 'url', array(
			'header' => Mage::helper( 'fssnet' )->__( 'URL' ),
			'type' => 'text',
			'index' => 'url',
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