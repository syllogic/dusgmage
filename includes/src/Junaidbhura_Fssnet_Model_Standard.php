<?php
/**
 * Main payment model
 *
 * @category    Model
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_Model_Standard extends Mage_Payment_Model_Method_Abstract {
	protected $_code = 'fssnet';
	
	protected $_isInitializeNeeded      = true;
	protected $_canUseInternal          = true;
	protected $_canUseForMultishipping  = false;
	
	public function getOrderPlaceRedirectUrl() {
		return Mage::getUrl( 'fssnet/payment/redirect', array( '_secure' => true ) );
	}
}
?>