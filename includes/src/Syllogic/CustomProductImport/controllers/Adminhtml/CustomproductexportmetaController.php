<?php

class Syllogic_CustomProductImport_Adminhtml_CustomproductexportmetaController extends Mage_Adminhtml_Controller_Action
{

	public function indexAction()
    {
  
       $this->loadLayout();
       $this->_title($this->__("Bulk Update of Stock "));
        
	    $this->renderLayout();
	   
    }
        
    public function postAction()
    {
    	 $post = $this->getRequest()->getPost();
    	// echo "<pre>",print_r($post),"</pre>";
    	 $product_type=$post['type'];
       $this->loadLayout();
       $products = Mage::getModel("catalog/product")->getCollection()
       ->setStoreId($storeId)
       ->addStoreFilter($store_id)
       ->addAttributeToSelect('*');
       if(in_array($product_type,array('simple','configurable'))){
			 $products->addAttributeToFilter('type_id', array('eq' => $product_type));
		 }
	
	   $string='';
    	$heading = '"sku","name","meta_title","meta_keyword","meta_description",';
		// $products->addAttributeToFilter('status', 1);//optional for only enabled products
		// $products->addAttributeToFilter('visibility', 4);//optional for products only visible in catalog and search
		//print_r($products);
		 //$message="<table border=1><tr><td>Sku</td><td>Name</td><td>Meta Title</td><td>Meta Keyword</td><td>Meta Description</td></tr>";
		 foreach ($products as $product) {
  			  $name = $product->getName(); //get name
  			  $sku  = $product->getSku();
  			  $meta_title  = $product->getMetaTitle();
  			  $meta_keyword  = $product->getMetaKeyword();
  			  $meta_description  = $product->getMetaDescription();
  			  $string .='"'.$sku.'","'.$name.'","'.$meta_title;
  			  $string .='","'.$meta_keyword.'","'.$meta_description.'"';
  			  $string.="\n";
  			  $message.="<tr><td>".$sku."</td>";
  			  $message.="<td>".$name."</td>";
  			  $message.="<td>". (!isset($meta_title)?"&nbsp;":$meta_title)."</td>";
  			  $message.="<td>". (!isset($meta_keyword)?"&nbsp;":$meta_keyword)."</td>";
  			  $message.="<td>". (!isset($meta_description)?"&nbsp;":$meta_description)."</td></tr>";
  		}	  
  		//$message.="</table>";
  		 $csv_output = $heading ."\n".$string;
    $filename = "product_meta";
    header("Content-type: application/vnd.ms-excel");
    header("Content-disposition: csv" . date("Y-m-d") . ".csv");
    header( "Content-disposition: filename=".$filename.".csv");
    print $csv_output;	
     $this->_prepareDownloadResponse($filename.".csv");		  
		/*  $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText($message);

        $this->_addContent($block);
       $this->renderLayout();
    */
    }
    
}
