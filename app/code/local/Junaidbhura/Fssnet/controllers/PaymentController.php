<?php
/**
 * Main payment controller
 *
 * @category    Controller
 * @package     Junaidbhura_Fssnet
 * @author      Junaid Bhura <info@junaidbhura.com>
 */

class Junaidbhura_Fssnet_PaymentController extends Mage_Core_Controller_Front_Action {
	// The redirect action is triggered when someone places an order
	public function redirectAction() {
		// Retrieve order
		$order = new Mage_Sales_Model_Order();
		$fssnet['order_id'] = Mage::getSingleton( 'checkout/session' )->getLastRealOrderId();
		$order->loadByIncrementId( $fssnet['order_id'] );
		
		// Retrieve order details
		$billing_address = $order->getBillingAddress();
		
		// Get FSS Net Config
		$login_credentials = $this->get_user_id_and_password( $billing_address->country_id );
		$fssnet['user_id'] = $login_credentials['user_id'];
		$fssnet['password'] = $login_credentials['password'];

		// Set up FSS Curl variables
		$id = 'id=' . $fssnet['user_id'];
		$password = 'password=' . $fssnet['password'];
		$action = 'action=1';
		$langid = 'langid=USA'; // Never change
		$currencycode = 'currencycode=356'; // INR
		$amount = round( $order->base_grand_total, 2 );
		$amt = 'amt=' . $amount;
		$response_url = "responseURL=" . Mage::getUrl( 'fssnet/payment/response' );
		$error_url = "errorURL=" . Mage::getUrl( 'checkout/onepage/failure' );
		$trackid = 'trackid=' . $order->getId();


/*==============================HASHING LOGIC CODE START==============================================*/
	/*Below are the fields/prametres which will use for hashing using (GetSHA256) hashing 
	Algorithm,and need to pass same hashed valued in UDF5 filed only*/
	
	$strhashTID=trim($fssnet['user_id']); 			 //USE Tranportal ID FIELD Value FOR HASHING 
	$strhashtrackid=trim($order->getId());	 //USE Trackid FIELD Value FOR HASHING 
	$strhashamt=trim($amount);  		 //USE Amount FIELD Value FOR HASHING 
	$strhashcurrency=trim("356");			 //USE Currencycode FIELD Value FOR HASHING 
	$strhashaction=trim("1");				 //USE Action code FIELD Value FOR HASHING 
	
	//Create a Hashing String to Hash
	$str = trim($strhashTID.$strhashtrackid.$strhashamt.$strhashcurrency.$strhashaction);
	
	//Use hash method which is defined below for Hashing ,It will return Hashed valued of above string
	$hashstring= hash('sha256', $str); 

	$ReqUdf5="udf5=".$hashstring;      // Passed Calculated Hashed Value in UDF5 Field 
	
/*==============================HASHING LOGIC CODE END==============================================*/	
		$udf1 = 'udf1=new_order';
		$udf2 = 'udf2=' . $this->clean_me( $order->customer_email );
		$udf3 = 'udf3=' . $this->clean_me( $billing_address->telephone );
		$udf4 = 'udf4=' . $this->clean_me( $billing_address->street );
		$udf5 = 'udf5='.$hashstring;
		
		// Build params for URL	
		$param = $id . '&' . $password . '&' . $action . '&' . $langid . '&' . $currencycode . '&' . $amt . '&' . $response_url . '&' . $error_url . '&' . $trackid . '&' . $udf1 . '&' . $udf2 . '&' . $udf3 . '&' . $udf4 . '&' .$udf5;
		
		$url = $this->get_payment_gateway_url(  );
		//echo $param;
		// Insert into FSS Net Redirect Log Table
		$now = Mage::getModel( 'core/date' )->timestamp( time() );
		Mage::getModel( 'fssnet/fssnetredirect' )
			->setUserid( $id )
			->setPassword( $password )
			->setAction( $action )
			->setLangid( $langid )
			->setCurrencycode( $currencycode )
			->setAmt( $amount )
			->setResponseUrl( $response_url )
			->setErrorUrl( $error_url )
			->setTrackid( $trackid )
			->setUdf1( $udf1 )
			->setUdf2( $udf2 )
			->setUdf3( $udf3 )
			->setUdf4( $udf4 )
			->setUdf5( $udf5 )
			->setUrl( $url )
			->setFssnetRedirectIp( $this->get_uer_ip() )
			->setFssnetRedirectDtime( date( 'Y-m-d H:i:s', $now ) )
			->save();
		
		// Send CURL request
		$ch = curl_init() or die( curl_error() );
		curl_setopt( $ch, CURLOPT_POST, 1 ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $param ); 
		curl_setopt( $ch, CURLOPT_PORT, 443 );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); 
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 ); 
		$my_response = curl_exec( $ch ) or die( curl_error() );
		curl_close( $ch );
		
		// Check the response out
            
		$response = $my_response;
                //die($response);
		try {
			// Look for errors
			$index = strpos( $response, "!-" );
			$error_check = substr( $response, 1, $index - 1 );
			
			// Error found
			if ( $error_check == 'ERROR' ) {
				// Redirect to payment failure page
				$this->cancel_order( $order->getIncrementId() );
				Mage_Core_Controller_Varien_Action::_redirect( 'checkout/onepage/failure', array( '_secure' => true) );
			}
			
			// Error not found
			else {
				// Get Payment ID and page
				$i = strpos( $response, ":" );		
				$payment_id = substr( $response, 0, $i );
				$paymentPage = substr( $response, $i + 1 );
				
				// Redirect to payment page
				Mage_Core_Controller_Varien_Action::_redirectUrl( $paymentPage . '?PaymentID=' . $payment_id );
			}			
		}
		
		// An exception was found
		catch( Exception $e ) {
			// Redirect to payment failure page
			$this->cancel_order( $order->getIncrementId() );
			Mage_Core_Controller_Varien_Action::_redirect( 'checkout/onepage/failure', array( '_secure' => true) );
			//var_dump( $e->getMessage() );
		}
	}
	
	// The response action is triggered when FSS Net sends a response
	public function responseAction() {
		// Get the POST variables
               
		$error = isset( $_POST['Error'] ) ? $_POST['Error'] : '';
		$error_result = isset( $_POST['ErrorText'] ) ? $_POST['ErrorText'] : '';
		$payment_id = isset( $_POST['paymentid'] ) ? $_POST['paymentid'] : '';
		$trackid = isset( $_POST['trackid'] )? $_POST['trackid']: '';
		$result = isset( $_POST['result'] ) ? $_POST['result'] : '';
		$tranid = isset( $_POST['tranid'] ) ? $_POST['tranid'] : '';
		$txmeid = isset( $_POST['trackid'] ) ? $_POST['trackid'] : '';
		$txamount = isset( $_POST['amt'] )? $_POST['amt']: '';
		
		// Get order
		$order_id = intval( ''.$trackid );
		$order = Mage::getModel( 'sales/order' );
		$order->load( $order_id ); 
			
		// Get the IP address of the sender's page and make sure its from the Payment Gateway
		if ( $this->is_from_valid_ip() ) {
			// The IP address is acceptable  
			// Insert into FSS Net Response Log Table
			$now = Mage::getModel( 'core/date' )->timestamp( time() );
			Mage::getModel( 'fssnet/fssnetresponse' )
				->setResponseIp( getenv( 'REMOTE_ADDR' ) )
				->setError( $error )
				->setErrorText( $error_result )
				->setPaymentid( $payment_id )
				->setTrackid( $trackid )
				->setResult( $result )
				->setTranid( $tranid )
				->setAmt( $txamount )
				->save();
			
			// Check for errors
			if ( $error == '' ) {
				// No errors found, create a dual verification request to double-check if everything is fine
				// If the result is 'CAPTURED' or 'APPROVED', then payment is successful
				if ($result == 'CAPTURED' || $result == 'APPROVED') {
					// Retrieve order details
					$billing_address = $order->getBillingAddress();
					
					// Get FSS Net Config
					$login_credentials = $this->get_user_id_and_password( $billing_address->country_id );
					$fssnet['user_id'] = $login_credentials['user_id'];
					$fssnet['password'] = $login_credentials['password'];
					
					// Get FSS Net Config
					$fssnet['user_id'] = Mage::getStoreConfig( 'payment/fssnet/user_id' );
					$fssnet['password'] = Mage::getStoreConfig( 'payment/fssnet/password' );
					
					// Payment is successful, send the dual verification request
					$tranportal_id = "<id>" . $fssnet['user_id'] . "</id>";
					$tranportal_pwd = "<password>" . $fssnet['password'] . "</password>";
					$action = "<action>8</action>"; // Dual verification action code
					$transid = "<transid>" . $tranid . "</transid>";
					$req_string = $tranportal_id . $tranportal_pwd  .$action . $transid;
					$dual_verification_url = $this->get_dual_verification_url();
					
					 // Send a CURL request
					$dvreq = curl_init() or die( curl_error() ); 
					curl_setopt( $dvreq, CURLOPT_POST, 1 ); 
 					curl_setopt( $dvreq, CURLOPT_POSTFIELDS, $req_string ); 
					curl_setopt( $dvreq, CURLOPT_URL, $dual_verification_url ); 
 					curl_setopt( $dvreq, CURLOPT_PORT, 443 );
					curl_setopt( $dvreq, CURLOPT_RETURNTRANSFER, 1 ); 
 					curl_setopt( $dvreq, CURLOPT_SSL_VERIFYHOST, 0 ); 
					curl_setopt( $dvreq, CURLOPT_SSL_VERIFYPEER, 0 ); 
 					$dataret = curl_exec( $dvreq ) or die( curl_error() );
 					curl_close( $dvreq );
					
					// Get the XML response
 					$dv_response = $dataret;
                                      
					 $GEnXMLForm = "<xmltg>" . $dv_response . "</xmltg>";
					$xmlSTR = simplexml_load_string( $GEnXMLForm, null, true );
					$getTxnResult = $xmlSTR->result;
					
					// If the result is 'CAPTURED' or 'APPROVED', then payment is successful
					if ( $getTxnResult == 'CAPTURED' || $getTxnResult == 'APPROVED' ) {
						// Payment is DOUBLE VERIFIED and successful for sure :)
						 // Get the payment's details
						$getTxnResult = $xmlSTR->result;
 						$getTxnAvr = $xmlSTR->avr;
						$getTxnPostDate = $xmlSTR->postdate;
 						$getTxnAuthCode = $xmlSTR->auth;
 						$getTxnTrackID = $xmlSTR->trackid;
 						$getTxnTranid = $xmlSTR->tranid;
						$getTxnAmt = $xmlSTR->amt;
  						$getTxnPaymentId = $xmlSTR->paymentid;
						$getTxnRefID = $xmlSTR->ref;
						$getUDF1 = $xmlSTR->udf1;
						$getUDF2 = $xmlSTR->udf2;
 						$getUDF3 = $xmlSTR->udf3;
						$getUDF4 = $xmlSTR->udf4;
 						$getUDF5 = $xmlSTR->udf5;
						
						// Payment was successful, update the order
						$order->setState( Mage_Sales_Model_Order::STATE_PROCESSING, true, 'FSS Net has authorized the payment.' );
						
						$order->sendNewOrderEmail();
						$order->setEmailSent( true );
						
						$order->save();
						
						// All well, redirect to success page
						echo 'REDIRECT=' . Mage::getUrl( 'checkout/onepage/success' );
					}
					
					// Payment is not double verified :(
					else {
						$this->cancel_order( $order->getIncrementId() );
						echo 'REDIRECT=' . Mage::getUrl( 'checkout/onepage/failure' );
					}
				}
				
				// Payment is not successful
				else {
					$this->cancel_order( $order->getIncrementId() );
					echo 'REDIRECT=' . Mage::getUrl( 'checkout/onepage/failure' );
				}
			}
			
			// There were errors found
			else {
				$this->cancel_order( $order->getIncrementId() );
				echo 'REDIRECT=' . Mage::getUrl( 'checkout/onepage/failure' );
			}
		}
		
		// IP address of sender is not acceptable
		else {
			$this->cancel_order( $order->getIncrementId() );
			echo 'REDIRECT=' . Mage::getUrl( 'checkout/onepage/failure' );
		}
	}
	
	// This function is triggered when we cancel an order
	public function cancel_order( $order_id ) {
        $order = Mage::getModel( 'sales/order' )->loadByIncrementId( $order_id );
		if ( $order->getId() ) {
			// Flag the order as 'cancelled' and save it
			$order->cancel()->setState( Mage_Sales_Model_Order::STATE_CANCELED, true, 'FSS Net has declined the payment.' )->save();
		}
	}
	
	// Function to get user's IP
	private function get_uer_ip() {
		if ( isset( $_SERVER ) ) {
			if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) )
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
			
			if ( isset( $_SERVER["HTTP_CLIENT_IP"] ) )
				return $_SERVER["HTTP_CLIENT_IP"];
			
			return $_SERVER["REMOTE_ADDR"];
		}
		
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
			return getenv( 'HTTP_X_FORWARDED_FOR' );
		
		if ( getenv( 'HTTP_CLIENT_IP') )
			return getenv( 'HTTP_CLIENT_IP' );
		
		return getenv( 'REMOTE_ADDR' );
	}
	
	// Function to clean inputs so that its acceptable to FSS Net
	private function clean_me( $input ) {
		$unacceptable_chars = array(">>", "<<", "<", ">", "(", ")", "{", "}", "[", "]", "?", "&", "*", "~", "`", "!", "#", "$", "%", "^", "=", "+", "|", '\\', "/", ":", "'", '"', ",", ";");
		return str_replace( $unacceptable_chars, '', $input );
	}
	
	// Function to get user ID and password based on billing country
	private function get_user_id_and_password( $country ) {
		// Check country
		if ( $country == 'IN' )
			return array(
				'user_id' => Mage::getStoreConfig( 'payment/fssnet/user_id' ),
				'password' => Mage::getStoreConfig( 'payment/fssnet/password' )
			);
		else {
			if ( Mage::getStoreConfig( 'payment/fssnet/user_id_intl' ) != '' && Mage::getStoreConfig( 'payment/fssnet/user_id_intl' ) != '' )
				return array(
					'user_id' => Mage::getStoreConfig( 'payment/fssnet/user_id_intl' ),
					'password' => Mage::getStoreConfig( 'payment/fssnet/password_intl' )
				);
			else
				return array(
					'user_id' => Mage::getStoreConfig( 'payment/fssnet/user_id' ),
					'password' => Mage::getStoreConfig( 'payment/fssnet/password' )
				);
		}
	}
	
	// Get payment gateway URL
	private function get_payment_gateway_url() {
		// Check if we are in testing mode
		if ( Mage::getStoreConfig( 'payment/fssnet/is_testing' ) )
			return 'https://securepgtest.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet';
		else
			return 'https://securepg.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet';
	}
	
	// Get dual verification URL
	private function get_dual_verification_url() {
		// Check if we are in testing mode
		if ( Mage::getStoreConfig( 'payment/fssnet/is_testing' ) )
			return 'https://securepgtest.fssnet.co.in/pgway/servlet/TranPortalXMLServlet';
		else
			return 'https://securepg.fssnet.co.in/pgway/servlet/TranPortalXMLServlet';
	}
	
	// Function to check whether a response has come from a valid IP
	private function is_from_valid_ip() {
		$my_ip = getenv( 'REMOTE_ADDR' );
		
		// Check if we are in testing mode, and get list of valid IPs
		if ( Mage::getStoreConfig( 'payment/fssnet/is_testing' ) )
			$valid_ips = array( '221.134.101.174', '221.134.101.169' );
		else
			$valid_ips = array( '221.134.101.187', '221.134.101.175', '221.134.101.166' );
		
		// Check if our IP is valid
		if ( in_array( $my_ip, $valid_ips ) )
			return true;
		else
			return false;
	}
}