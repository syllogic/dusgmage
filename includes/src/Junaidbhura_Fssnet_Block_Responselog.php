<?php
/**
 * Fssnet Response Log Block
 *
 * @category    Block
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_Block_Responselog extends Mage_Adminhtml_Block_Widget_Grid_Container {
	/**
	* Constructor
	*/
	public function __construct() {
		$this->_controller = 'responselog';
		$this->_blockGroup = 'fssnet';
		$this->_headerText = Mage::helper( 'fssnet' )->__( 'FSS Net Response Log' );
		$this->_addButtonLabel = '';
		parent::__construct();
		$this->_removeButton( 'add' );
	}
}