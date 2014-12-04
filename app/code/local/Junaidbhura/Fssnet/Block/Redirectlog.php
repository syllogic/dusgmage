<?php
/**
 * Fssnet Redirect Log Block
 *
 * @category    Block
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_Block_Redirectlog extends Mage_Adminhtml_Block_Widget_Grid_Container {
	/**
	* Constructor
	*/
	public function __construct() {
		$this->_controller = 'redirectlog';
		$this->_blockGroup = 'fssnet';
		$this->_headerText = Mage::helper( 'fssnet' )->__( 'FSS Net Redirect Log' );
		$this->_addButtonLabel = '';
		parent::__construct();
		$this->_removeButton( 'add' );
	}
}