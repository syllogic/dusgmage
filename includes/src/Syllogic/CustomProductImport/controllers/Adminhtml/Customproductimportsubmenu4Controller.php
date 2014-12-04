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
class Syllogic_CustomProductImport_Adminhtml_Customproductimportsubmenu4Controller extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
  
       $this->loadLayout();
       $this->_title($this->__("Create Configurable Products with existing Simple Products"));
        
	    $this->renderLayout();
	   
    }
        
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            if(isset($_FILES['csv_import']['name']) && $_FILES['csv_import']['name'] != '')
				{
    				try
    				{       
        				$path = Mage::getBaseDir().DS.'magmi/integration/samples/uploads/configurable'.DS;  //desitnation directory     
        				$fname = "configurable.csv"; //file name                        
        				$uploader = new Varien_File_Uploader('csv_import'); //load class
        				$uploader->setAllowedExtensions(array('csv')); //Allowed extension for file
        				$uploader->setAllowCreateFolders(true); //for creating the directory if not exists
        				$uploader->setAllowRenameFiles(false); //if true, uploaded file's name will be changed, if file with the same name already exists directory.
        				$uploader->setFilesDispersion(false);
        				$uploader->save($path,$fname); //save the file on the specified path
        				$filename = Mage::getBaseDir().DS.'magmi/integration/samples/uploads/configurable'.DS."configurable.csv";
						$reader = new CSVReader( new FileReader( $filename) );
						$reader1 = new CSVReader( new FileReader( $filename) );
            		$self = $self =$this->getUrl('*/*/view');
            		$string_csv= "<form action ='$self' method='post' >";
            		$string_csv.='<table cellpadding=2 cellspacing=1 bgcolor="#fff" border=1 style="border-color:#cdcdcd;display:none">';
						$string_csv.="<tr>\n";
	   				$string_csv.="<td>CSV File header value</td>\n";
	   				$string_csv.="<td> Editable header value</td>\n";
						$string_csv.="</tr>\n";
						foreach($reader1->next() as $value){
							$string_csv.="<tr>\n";
	   					$string_csv.="<td> $value </td>\n";
	   					$string_csv.="<td> <input type='text' value='$value' name='product_attr_col[]' id='product_attr_col[]' /></td>\n";
							$string_csv.="</tr>\n";
						}		
					  $string_csv.="<tr>\n";
	   			  $string_csv.="<td colspan='2' align='center'>
	   									<input type='submit' name='importdata' id='importdata' value='Import Data'/>
	   								</td>\n";
					  $string_csv.="</tr>\n";
					  $string_csv.='</table>'; 
           		  $string_csv.='<div class="wrapper"><table cellpadding=2 cellspacing=1 bgcolor="#cdcdcd" border=0 width="90%">';
						while( false != ( $cell = $reader->next() ) )
            		{
	          			 $string_csv.="<tr>\n";
	           			 $string_csv.="<td bgcolor='".( ( $line % 2 ) == 0 ? '#efefef' : '#ffffff'  )."' >{$line}</td>\n";
				  			 for ( $i = 0; $i < count( $cell ); $i++ )
			     			 {
								$string_csv.="<td bgcolor='".( ( $line % 2 ) ==0 ? '#efefef' : '#ffffff'  )."'>{$cell[$i]}</td>\n";
				  			 }
				   			$string_csv.="</tr>\n";
								$line++;
								$count = count( $cell );
			  			}
		   			$string_csv.= "<tr>\n";
	   				$string_csv.="<td colspan='$count' align='center'>
	         			<input type='submit' name='importdata' id='importdata' value='Import Data'/>
	   					</td>\n";
						$string_csv.="</tr>\n";
						$string_csv.='</table></div><input type="hidden" name="form_key" value="'. Mage::getSingleton('core/session')->getFormKey().'" /></form>';
            		$message = $this->__('Your form has been submitted successfully.');
            		Mage::getSingleton('adminhtml/session')->addSuccess($message);
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
$filename =Mage::getBaseDir().DS.'magmi/integration/samples/uploads/configurable'.DS."configurable.csv";
$reader1 = new CSVReader( new FileReader( $filename ) );
$reader1->setSeparator( ',' );
$product_attr_col_flip = array_flip($_REQUEST['product_attr_col']);
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
$configurable_attributes_cell_no =  $product_attr_col_flip['configurable_attributes'];
$simples_skus_cell_no =  $product_attr_col_flip['simples_skus'];
$simples_attributes_values_cell_no =  $product_attr_col_flip['simples_attributes_values'];
$simples_attributes_labels_cell_no =  $product_attr_col_flip['simples_attributes_labels'];
$rows =1 ;
$message ="<div id='messages'><ul class='messages'><li class='success-msg'><ul>";
$skipped ="no";
$get_all_simples_skus = array();
$get_all_simples_attributes_values = array();
while( false != ( $cell = $reader1->next() ) )
{
if($rows != 1) // Skipping the headers row
{
   
   /* =========================Create Configurable products with required attributes ============================*/
      
             $configurable = $cell[$configurable_attributes_cell_no];
             $item = array("store"=>"admin","type"=>"configurable","sku"=>$cell[$sku_cell_no],
   	                   "description"=> $cell[$description_cell_no],"short_description"=> $cell[$short_description_cell_no],
   	                   "attribute_set"=>$cell[$attribute_set_cell_no],
   	                   "price"=>$cell[$price_cell_no],"qty"=>$cell[$qty_cell_no],"visibility"=>4,
   	                   "status"=>$cell[$status_cell_no],"tax_class_id"=>$cell[$tax_class_id_cell_no],
   	                   'is_qty_decimal'=>$cell[$is_qty_decimal_cell_no],'is_in_stock'=>$cell[$is_in_stock_cell_no],
   	                   "name"=>$cell[$name_cell_no],"configurable_attributes"=>$configurable,
   	                   "simples_skus"=>$cell[$simples_skus_cell_no ]);
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
       
/* =========================Create configurable products with required attributes ============================*/
}
 $rows++;
}
$message.="</ul></li></ul></div>";
/* end import session, will run post import plugins */
$dp->endImportSession();
Mage::getSingleton('core/session')->setimport("");
/* ================================Initially form to upload csv file ============================*/
// Mage::getSingleton('adminhtml/session')->addSuccess($message);
    	//$this->_redirect('*/*');
    	$this->loadLayout();
      $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText($message);

        $this->_addContent($block);
	    $this->renderLayout();
    }
}	