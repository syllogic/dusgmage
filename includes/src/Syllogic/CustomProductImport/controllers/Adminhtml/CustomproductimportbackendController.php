<?php
$base_path = Mage::getBaseDir('base').DS;
require($base_path."magmi/inc/magmi_defs.php");
require($base_path."magmi/integration/inc/magmi_datapump.php");
include($base_path."magmi/integration/samples/csvreader/FileReader.php" );
include( $base_path."magmi/integration/samples/csvreader/CSVReader.php" );
class TestLogger
{

    /**
     * logging methos
     *
     * @param string $data
     *            : log content
     * @param string $type
     *            : log type
     */
    public function log($data, $type)
    {
        //Mage::getSingleton('adminhtml/session')->addSuccess("$type:$data\n") ;
    }
}

class Syllogic_CustomProductImport_Adminhtml_CustomproductimportbackendController extends Mage_Adminhtml_Controller_Action
{
    private $required_attributes = array('sku','name','attribute_set','websites','description',
                         'short_description','status','tax_class_id','visibility','weight','qty','price',
                          'is_qty_decimal','is_in_stock');
                          
	 public function indexAction()
        {
  	$this->loadLayout();
       $this->_title($this->__("Create Simple Products "));
       $this->renderLayout();
       
       }
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        $line = 0;
        $entityType = Mage::getModel('catalog/product')->getResource()->getTypeId();
        $collection = Mage::getResourceModel('eav/entity_attribute_set_collection')->setEntityTypeFilter($entityType);
        foreach($collection as $coll){
         $allattributeSet[] = $coll->getAttributeSetName();
        }
         $allvisibility = array('Not Visible Individually','Catalog','Search','Catalog, Search');
         $allstatus = array('Enabled','Disabled');
         $collection_tax = Mage::getResourceModel('tax/class_collection')
                				->addFieldToFilter('class_type', Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT)
               				 ->load()->toOptionArray();
         //   echo "<pre>",print_r($collection_tax),"</pre>";die;    
         $_websites = Mage::app()->getWebsites();
         $alltax_class_id = array(0);
         for($i = 0;$i < count($collection_tax);$i++){
           $alltax_class_id[] = $collection_tax[$i]['value'];
         
        }
    //die;
        foreach($_websites as $all_website){
          $allwebsites[]= $all_website->getCode();
        }
      
         try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            if(isset($_FILES['csv_import']['name']) && $_FILES['csv_import']['name'] != '')
				{
    				try
    				{       
        				$path = Mage::getBaseDir().DS.'magmi/integration/samples/uploads/simple'.DS;  //desitnation directory     
        				$fname = "simple.csv"; //file name                        
        				$uploader = new Varien_File_Uploader('csv_import'); //load class
        				$uploader->setAllowedExtensions(array('csv')); //Allowed extension for file
        				$uploader->setAllowCreateFolders(true); //for creating the directory if not exists
        				$uploader->setAllowRenameFiles(false); //if true, uploaded file's name will be changed, if file with the same name already exists directory.
        				$uploader->setFilesDispersion(false);
        				$uploader->save($path,$fname); //save the file on the specified path
        				$filename = Mage::getBaseDir().DS.'magmi/integration/samples/uploads/simple'.DS."simple.csv";
						$reader = new CSVReader( new FileReader( $filename) );
						$reader1 = new CSVReader( new FileReader( $filename) );
             		$error_message =array();		
             		$error_message1 ='';		
             		$header_error_message='';	
             		$is_image_fields_occurs ='no';
             			
/* ************************check the headers fields having required attributes starts ******************** */

                  $header_fields = $reader1->next();
                  $product_attr_col_flip = array_flip($header_fields);
						foreach($this->required_attributes as $attr){
							if(!in_array($attr,$header_fields)):
   							if($header_error_message=="") {
      							$header_error_message ="<h2>Following Header Fields are Missing. 
      													Please add the Header Fields and continue to import data</h2><ul>";
      						}	
       						$header_error_message.="<li><span style='color:red'>".$attr." is missing in the csv file</span</li>\n";
   					   endif;
   					   
						}
					  if( in_array("image",$header_fields)  || in_array("small_image",$header_fields) 
					         || in_array("thumbnail",$header_fields) || in_array("media_gallery",$header_fields) ){
					   
					      $is_image_fields_occurs ='yes';
					      
      			      if(!in_array("image",$header_fields)):
      			     		 if($header_error_message=="") :
      									$header_error_message ="<h2>Following Header Fields are Missing. 
      													Please add the Header Fields and continue to import data</h2><ul>";
      				  		endif;
      			        $header_error_message.="<li><span style='color:red'> image missing in the csv file</span</li>\n";
      			      endif;
      			      if( !in_array("small_image",$header_fields)):
      			     		 if($header_error_message=="") :
      									$header_error_message ="<h2>Following Header Fields are Missing. 
      													Please add the Header Fields and continue to import data</h2><ul>";
      				  		 endif;
      			        $header_error_message.="<li><span style='color:red'> small_image missing in the csv file</span</li>\n";
      			      endif;
      			      if( !in_array("thumbnail",$header_fields)):
      			         if($header_error_message=="") :
      									$header_error_message ="<h2>Following Header Fields are Missing. 
      													Please add the Header Fields and continue to import data</h2><ul>";
      				  		 endif;
      			        $header_error_message.="<li><span style='color:red'> thumbnail missing in the csv file</span</li>\n";
      			      endif;
      			      if( !in_array("media_gallery",$header_fields)):
      			        if($header_error_message=="") :
      									$header_error_message ="<h2>Following Header Fields are Missing. 
      													Please add the Header Fields and continue to import data</h2><ul>";
      				  		 endif;
      			        $header_error_message.="<li><span style='color:red'> media_gallery missing in the csv file</span</li>\n";
      			      endif;
      				} 
						if($header_error_message!=""){
							$header_error_message.="</ul>";
 							  Mage::getSingleton('adminhtml/session')->addError($header_error_message);
  							// echo "<a href='$self'>Back to import csv file</a>";
  						    //exit();
						}

/* ****************************check the headers fields having required attributes ends ************************** */		
						
            		$self = $self =$this->getUrl('*/*/view');
            		$string_csv= "<form action ='$self' method='post' >";
            		$string_csv.='<table cellpadding=2 cellspacing=1 bgcolor="#fff" border=1 
            		               style="border-color:#cdcdcd;display:none">';
						$string_csv.="<tr>\n";
	   				$string_csv.="<td>CSV File header value</td>\n";
	   				$string_csv.="<td> Editable header value</td>\n";
						$string_csv.="</tr>\n";
						
						while( false != ( $cell = $reader->next() ) )
            		{
            		   if($line == 0) {
            		   	
            		   	 for ( $k = 0; $k < count( $cell ); $k++ )
			     			    {  
									$string_csv.="<tr class='headings'>\n";
	   							$string_csv.="<td> $cell[$k] </td>\n";
	   							$string_csv.="<td> <input type='text' value='$cell[$k]' name='product_attr_col[]'
	   					                              id='product_attr_col[]' /></td>\n";
									$string_csv.="</tr>\n";
						      }
						      $string_csv.="</table>\n";
						      $string_csv.='<div class="wrapper"><div class="grid">
<div class="hor-scroll"><table id="cmsBlockGrid_table" class="data" cellpadding=0 cellspacing=0 
           		                 bgcolor="#cdcdcd" border=0 width="90%">';
						   }   
            		/* validation checking for the attributes starts */	
            		
            		  if( $header_error_message == "" && $line!=0 ):	
            		   	$sku = $cell[$product_attr_col_flip['sku']];
            		   	$product = Mage::getModel('catalog/product');
            				$productId = $product->getIdBySku($sku);
  								if ($productId) {
      							$error_message['sku'][] =$sku; 
      							$bgcolor ="red";
 							 	} 
 							 	else {
 							 	 	$bgcolor = ( ( $line % 2 ) == 0 ? '#efefef' : '#ffffff'  );
 							 	 	$short_description = $cell[$product_attr_col_flip['short_description']];
 							 	 	$description = $cell[$product_attr_col_flip['description']];
 							 	 	$attribute_set = $cell[$product_attr_col_flip['attribute_set']];
 							 	 	$attribute_set = $cell[$product_attr_col_flip['attribute_set']];
 							 	 	$websites = $cell[$product_attr_col_flip['websites']];
 							 	 	$visibility = $cell[$product_attr_col_flip['visibility']];
 							 	 	$status = $cell[$product_attr_col_flip['status']];
 							 	 	$price = $cell[$product_attr_col_flip['price']];
 							 	 	$qty = $cell[$product_attr_col_flip['qty']];
 							 	 	$tax_class_id = $cell[$product_attr_col_flip['tax_class_id']];
 							 	 	$is_in_stock = $cell[$product_attr_col_flip['is_in_stock']];
 							 	 	if($is_image_fields_occurs == 'yes'):
			  				      
			  				      	$image = $cell[$product_attr_col_flip['image']];
			  				    		$small_image = $cell[$product_attr_col_flip['small_image']];
                              $thumbnail = $cell[$product_attr_col_flip['thumbnail']];
                              $media_gallery = $cell[$product_attr_col_flip['media_gallery']]; 
                              
                           endif;
 							 	 	
 							 		 //$sku = $cell[$product_attr_col_flip['sku']];
									 if($short_description == ""):
								 			$error_message['short_description'][] =$sku; 
									endif;
								 	if($description == ""):
								 		$error_message['description'][] = $sku; 
								   endif;
									if(!in_array($attribute_set,$allattributeSet)):
								 		$error_message['attribute_set'][] = $sku;
								   endif;
								   if(!in_array($websites,$allwebsites)):
								 		$error_message['websites'][] = $sku; 
								 	endif;
								   if(!in_array($visibility,$allvisibility)):
								 		$error_message['visibility'][] = $sku; 
								 	endif;
								 	if(!in_array($status,$allstatus)):
								 		$error_message['status'][] = $sku; 
								 	endif;
								 	if(!is_numeric($price)):
								 		$error_message['price'][] = $sku; 
								 	endif;
								 	if(!is_numeric($qty)):
								 		$error_message['qty'][] = $sku; 
								 	endif;
								 	if(!in_array($tax_class_id,$alltax_class_id)):
								 		$error_message['tax_class_id'][] = $sku; 
								 	endif;
								 	if(!in_array($is_in_stock,array('In Stock','Out of Stock'))):
								 		$error_message['is_in_stock'][] = $sku; 
								 	endif;
								 	if($is_image_fields_occurs == 'yes'):
			  				         //$errormessage_image_fields = array();
			  				         $errormessage_image_fields1 ='';
			  				         $errormessage_mediagallery_fields ='';
			  				         if($media_gallery != ""):
								 			 $explode_media_gallery = explode(";",$media_gallery);
								 				 if(!in_array($image,$explode_media_gallery)):
								 						$errormessage_image_fields1.= "image data not exists in media_gallery "; 
								 	 			 endif;
									  			 if(!in_array($small_image,$explode_media_gallery)):
								 						$errormessage_image_fields1.= "small_image data not exists in media_gallery ";  
									 			 endif;
												 if(!in_array($thumbnail,$explode_media_gallery)):
								 						$errormessage_image_fields1.= "thumbnail data not exists in media_gallery ";  
									  			 endif;
									  			 
									  			
									  			// echo"<pre>",print_r( $explode_media_gallery),"</pre>";
									  			 foreach($explode_media_gallery as $imagepath){
									  			 
									  			 echo $filename = "http://syllogic.one/magento_test/media/import/".$imagepath;
													if(!file_exists($filename)) {
													
													  $errormessage_mediagallery_fields.=$filename." cannot be found in images path,";
													}								  			 
									  			 }
									  	     
									  		    $error_message['image_fields'][] = "<h4>".$sku." having following errors</h4> ".
									  		                                 $errormessage_image_fields1."<br>".
									  		                                 $errormessage_mediagallery_fields;
									  		    //	echo"<pre>",print_r( $error_message['image_fields']),"</pre>";
									  		   // die;                             
									  			 
			  				  		    endif;
			  				  	endif;
 							  }
 						  endif;
 						  
 						  	/* validation checking for the attributes ends */	
 						  	 if($line == 0) :
 						   	 $string_csv.="<tr class='headings'>\n";
 						    else:
 						      $string_csv.="<tr>\n";
            			 endif;
	           			// $string_csv.="<td bgcolor='".$bgcolor."' >{$line}</td>\n";
				  			 for ( $i = 0; $i < count( $cell ); $i++ )
			     			 {
								$string_csv.="<td bgcolor='".$bgcolor."'>{$cell[$i]}</td>\n";
				  			 }
				   			$string_csv.="</tr>\n";
								$line++;
								$count = count( $cell );
			  			}
			  		// print_r($error_message['attribute_set']); die;
			  		 if(is_array($error_message) && count($error_message) > 0 ):
			  				 $error_message1="<ul><li><h2>Following errors occurs,
			  				 					 Please check the data. Cannot Import!!!</h2></li>";
			  				  if( count( $error_message['sku'] ) > 0 && is_array( $error_message['sku'] ) ) :
									$error_message1.="<li><h3>The following SKUs are already exists in the system</h3>".
														implode(",",$error_message['sku']) ."</li>";					  				  
			  				  endif;
			  				   if( count( $error_message['short_description'] ) > 0 && is_array( $error_message['short_description'] ) ) :
									$error_message1.="<li><h3>The following SKUs short description cannot be empty</h3>".
														implode(", ",$error_message['short_description']) ."</li>";					  				  
			  				  endif;
			  				   if( count( $error_message['description'] ) > 0 && is_array( $error_message['description'] ) ) :
									$error_message1.="<li><h3>The following SKUs description cannot be empty</h3>".
														implode(", ",$error_message['description']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['attribute_set'] ) > 0 && is_array( $error_message['attribute_set'] ) ) :
									$error_message1.="<li><h3>The following SKUs attribute set is not valid</h3>".
														implode(", ",$error_message['attribute_set']) ."</li>";					  				  
			  				  endif;
			  				   if( count( $error_message['websites'] ) > 0 && is_array( $error_message['websites'] ) ) :
									$error_message1.="<li><h3>The following SKUs websites is not valid</h3>".
														implode(", ",$error_message['websites']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['visibility'] ) > 0 && is_array( $error_message['visibility'] ) ) :
									$error_message1.="<li><h3>The following SKUs visibility is not valid</h3>".
														implode(", ",$error_message['visibility']) ."</li>";					  				  
			  				  endif;
			  				   if( count( $error_message['status'] ) > 0 && is_array( $error_message['status'] ) ) :
									$error_message1.="<li><h3>The following SKUs status is not valid</h3>".
														implode(", ",$error_message['status']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['price'] ) > 0 && is_array( $error_message['price'] ) ) :
									$error_message1.="<li><h3>The following SKUs price should be decimal or interger.</h3>".
														implode(", ",$error_message['price']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['qty'] ) > 0 && is_array( $error_message['qty'] ) ) :
									$error_message1.="<li><h3>The following SKUs quantity should be integer.</h3>".
														implode(", ",$error_message['qty']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['tax_class_id'] ) > 0 && is_array( $error_message['tax_class_id'] ) ) :
									$error_message1.="<li><h3>The following SKUs tax_class_id is not valid</h3>".
														implode(", ",$error_message['tax_class_id']) ."</li>";					  				  
			  				  endif;
			  				  if( count( $error_message['is_in_stock'] ) > 0 && is_array( $error_message['is_in_stock'] ) ) :
									$error_message1.="<li><h3>The following SKUs is in stock is not valid</h3>".
														implode(", ",$error_message['is_in_stock']) ."</li>";					  				  
			  				  endif;
			  				   if( count( $error_message['image_fields'] ) > 0 && is_array( $error_message['image_fields'] ) ) :
									$error_message1.="<li><h3>The following SKUs Image Attributes is not valid</h3>".
														implode(", ",$error_message['image_fields']) ."</li>";					  				  
			  				 endif;
			  				  
			  				  Mage::getSingleton('adminhtml/session')->addError($error_message1);
			  		 endif;
			  		if($error_message1 == "" && $header_error_message == ""){
			  			$imageURL =Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).
			  			           "adminhtml/default/default/images/btn_bg.gif";
		   			$string_csv.= "<tr>\n";
	   				$string_csv.="<td colspan='$count' align='center'>
	         			<input type='submit' style='background:url(".$imageURL.");background-repeat:repeat-x;color:#fff;
	         			border-color: #ED6502 #A04300 #A04300 #ED6502;border-style: solid;border-width: 1px;'
	         			 name='importdata' id='importdata' value='Import Data'/>
	   					</td>\n";
						$string_csv.="</tr>\n";
					}	else {
						$self =$this->getUrl('*/*/index');
						$string_csv.= "<tr>\n";
	   				$string_csv.="<td colspan='$count' align='center'>
	         			<a href='$self'>Back to import</a>
	   					</td>\n";
						$string_csv.="</tr>\n";
						
					}
						$string_csv.='</table></div></div></div><input type="hidden" name="form_key" value="'. Mage::getSingleton('core/session')->getFormKey().'" /></form>';
            		//$message = $this->__('Your form has been submitted successfully.');
            		//Mage::getSingleton('adminhtml/session')->addSuccess($message);
            		Mage::getSingleton('core/session')->setCSVValue($string_csv); 
              }
              
    			  catch (Exception $e)
    			 {
    			 	  Mage::getSingleton('adminhtml/session')->addError($e->getMessage());  
    			 		        				
             }
           } else {
           	
           	   Mage::getSingleton('adminhtml/session')->addError("Invalid file");  
    			 		
           }
         	
            
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }
     public function viewAction(){
/* ****************************check the headers fields having required attributes ends ************************** */
	    $dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport");
		 $dp->beginImportSession("wears", "create", new TestLogger());
		 $filename =Mage::getBaseDir().DS.'magmi/integration/samples/uploads/simple'.DS."simple.csv";
		 $reader1 = new CSVReader( new FileReader( $filename ) );
		 $reader1->setSeparator( ',' );
		 $product_attr_col_flip = array_flip($_REQUEST['product_attr_col']);
		 // echo "<pre>",print_r($product_attr_col_flip),"</pre>";die;  
		 $csv_product_attr_col = array();
		 $csv_product_attr_headercol = $_REQUEST['product_attr_col'];
		 $sku_cell_no =  $product_attr_col_flip['sku'];
		 $attribute_set_cell_no =  $product_attr_col_flip['attribute_set'];
		 $websites_cell_no =  $product_attr_col_flip['websites'];
		 $description_cell_no =  $product_attr_col_flip['description'];
		 $name_cell_no =  $product_attr_col_flip['name'];
		 $price_cell_no =  $product_attr_col_flip['price'];
		 $short_description_cell_no =  $product_attr_col_flip['short_description'];
		 $status_cell_no =  $product_attr_col_flip['status'];
		 $tax_class_id_cell_no =  $product_attr_col_flip['tax_class_id'];
		 $qty_cell_no =  $product_attr_col_flip['qty'];
		 $is_qty_decimal_cell_no =  $product_attr_col_flip['is_qty_decimal'];
		 $is_in_stock_cell_no =  $product_attr_col_flip['is_in_stock'];
		 $visibility_cell_no =  $product_attr_col_flip['visibility'];
		 $rows =1 ;
	    $messae ="<div id='messages'><ul class='messages'><li class='success-msg'><ul>";
		 $skipped ="no";
		 $get_all_simples_skus = array();
		 $get_all_simples_attributes_values = array();
		 
			$allvisibility = array('Not Visible Individually'=>1,'Catalog'=>2,'Search'=>3,'Catalog, Search'=>4);
         $allstatus = array('Enabled'=>1,'Disabled'=>2);
         $allis_in_stock = array('In Stock'=>1,'Out of Stock'=>0);
        while( false != ( $cell = $reader1->next() ) )
		  {
		 		 if($rows != 1) // Skipping the headers row
		 		 {
 					/* =========================Create simple products ============================*/
                     $get_visibility = $cell[$visibility_cell_no];			
                     $replace_visibility = $allvisibility[$get_visibility];			
 					      $get_status = $cell[$status_cell_no];			
                     $replace_status = $allstatus[$get_status];	
                     $get_is_in_stock = $cell[$is_in_stock_cell_no];			
                     $replace_is_in_stock = $allis_in_stock[$get_is_in_stock];	
    				 		 $item = array("store"=>"admin","type"=>"simple","sku"=>$cell[$sku_cell_no],
   	                   "description"=> $cell[$description_cell_no],"short_description"=> $cell[$short_description_cell_no],
   	                   "attribute_set"=>$cell[$attribute_set_cell_no],
   	                   "price"=>$cell[$price_cell_no],"qty"=>$cell[$qty_cell_no],"visibility"=>$replace_visibility,
   	                   "status"=>$replace_status,"tax_class_id"=>$cell[$tax_class_id_cell_no],
   	                   'is_qty_decimal'=>$cell[$is_qty_decimal_cell_no],'is_in_stock'=>$replace_is_in_stock,
   	                   "name"=>$cell[$name_cell_no]);
   	           for($header =0;$header < count($csv_product_attr_headercol);$header++){
                 switch($header) {
                 	   	case $sku_cell_no;
                 	       case $attribute_set_cell_no;
                 	       case $websites_cell_no;
                 	       case $description_cell_no;
                 	       case $name_cell_no;
                 	       case $price_cell_no;
                 	       case $short_description_cell_no;
                 	       case $status_cell_no;
                 	       case $tax_class_id_cell_no;
                 	       case $qty_cell_no;
                 	       case $is_qty_decimal_cell_no;
                 	       case $is_in_stock_cell_no;	
                 	       // do nothing
                 	       break;
                 	       default:
                 	       // added additional attributes
                 	       $tmp = $csv_product_attr_headercol[$header];
                 	       $item[$tmp] = $cell[$header];
                 	       break;
                 	    	}
                  }
                $dp->ingest($item);
                $message.="<li>".$cell[$sku_cell_no] ."is successfully imported</li>";
       
/* =========================Create simple products ============================*/
		  }
 		 		 $rows++;
		 }
		 $message.="</ul></li></ul></div>";
		 $dp->endImportSession();
		 Mage::getSingleton('core/session')->setimport("");
/* ================================Initially form to upload csv file ============================*/
 	    $this->loadLayout();
       $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText($message);
       $this->_addContent($block);
	     $this->renderLayout();
	}
}