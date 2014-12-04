
<?php
require_once ("../../inc/magmi_defs.php");
require_once ("../inc/magmi_datapump.php");
include( 'csvreader/FileReader.php' );
include( 'csvreader/CSVReader.php' );
$required_attributes = array('sku','name','attribute_set','websites','description',
                         'short_description','status','tax_class_id','visibility','weight','qty',
                          'is_qty_decimal','is_in_stock','configurable_attributes','simples_skus','simples_attributes_values',
                           'simples_attributes_labels');
 $error_message ='';
 ?>
 <html>
 <head>
<style type="text/css">
 .wrapper{
 width: 1200px;
 height: auto;
 overflow: auto;
 
 }
.wrapper table{
 
 font: 12px Arial;white-space:pre-wrap;width:20%;
 
 }
 .wrapper table tr,.wrapper table td{
 
 font: 12px Arial;white-space:pre-wrap;width:20%;vertical-align: text-top;
 
 }
 
</style>
</head>
<body>
<?php
/**
 * Define a logger class that will receive all magmi logs *
 */
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
        echo "$type:$data\n";
    }
}
/**
 * create a Product import Datapump using Magmi_DatapumpFactory
 */
 
 /* ================================Upload csv file in to the temporary foplder ============================================*/
 
if(isset($_REQUEST['importcsv'])) :
$self = $_SERVER['PHP_SELF'];
/**
 * Start import session
 * with :
 * - profile : test_ptj
 * - mode : create
 * - logger : an instance of the class defined above
 */
 
/* ********************************csv file ulload in the temporary folder starts ******************** */


 if((!empty($_FILES["csv_import"])) && ($_FILES['csv_import']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  //$filename = basename($_FILES['csv_import']['name']);
  $filename = basename($_FILES['csv_import']['name']);
  $newfilename = 'configurable.csv';
  $ext = substr($filename, strrpos($filename, '.') + 1);
  if (($ext == "csv") && ($_FILES["csv_import"]["size"] < 350000))  {
    //Determine the path to which we want to save this file
    
    $newname = str_replace('\\', '/', dirname(__FILE__)).'/uploads/configurable/'.$newfilename;
      //Check if the file with the same name is already exists on the server
      
        if ((move_uploaded_file($_FILES['csv_import']['tmp_name'],$newname))) {
           echo "It's done! The file has been saved as: ".$newname;
        } else {
           echo "Error: A problem occurred during file upload!";
           echo "<a href='$self'>Back to import csv file</a>";           
           exit();
        }
     
  } else {
     echo "Error: Only .csv files under 350Kb are accepted for upload";
     echo "<a href='$self'>Back to import csv file</a>";           
           exit();
     
  }
} else {
 echo "Error: No file uploaded";
  echo "<a href='$self'>Back to import csv file</a>";           
  exit();
}

/* ********************************csv file ulload in the temporary folder ends ******************** */

//$filename = $_FILES['csv_import']['tmp_name'];
$filename =  str_replace('\\', '/', dirname(__FILE__)).'/uploads/configurable/configurable.csv';
$reader = new CSVReader( new FileReader( $filename ) );
$reader1 = new CSVReader( new FileReader( $filename ) );
// set the separator as comma
$reader->setSeparator( ',' );
$reader1->setSeparator( ',' );
$line = 0;

/* =================storing headers value in hidden fields to check the header correctly place before import================*/



$self = $_SERVER['PHP_SELF'];
echo "<form action ='$self' method='post' >";
echo '<table cellpadding=2 cellspacing=1 bgcolor="#fff" border=1 style="border-color:#cdcdcd;display:none">';
echo "<tr>\n";
	   echo	"<td>CSV File header value</td>\n";
	   echo	"<td> Editable header value</td>\n";
echo "</tr>\n";
foreach($reader1->next() as $value){
	echo "<tr>\n";
	   echo	"<td> $value </td>\n";
	   echo	"<td> <input type='text' value='$value' name='product_attr_col[]' id='product_attr_col[]' /></td>\n";
	echo "</tr>\n";
}
echo "<tr>\n";
	   echo	"<td colspan='2' align='center'>
	   		<input type='submit' name='importdata' id='importdata' value='Import Data'/>
	   </td>\n";
echo "</tr>\n";
echo '</table>'; 

/* ===============view the csv file content in the table format to chech the data are correctly placed import==============*/

echo '<div class="wrapper"><table cellpadding=2 cellspacing=1 bgcolor="#cdcdcd" border=0 width="90%">';
while( false != ( $cell = $reader->next() ) )
{
	echo "<tr>\n";
	echo	"<td bgcolor='".( ( $line % 2 ) == 0 ? '#efefef' : '#ffffff'  )."' >{$line}</td>\n";
	for ( $i = 0; $i < count( $cell ); $i++ )
	{
		echo	"<td bgcolor='".( ( $line % 2 ) ==0 ? '#efefef' : '#ffffff'  )."'>{$cell[$i]}</td>\n";
	}
	echo "</tr>\n";
	$line++;
	$count = count( $cell );
}
echo "<tr>\n";
	   echo	"<td colspan='$count' align='center'>
	         <input type='submit' name='importdata' id='importdata' value='Import Data'/>
	   </td>\n";
	echo "</tr>\n";
echo '<table></div></form>';
 //die;
 
/* ================================Import csv file to create simple and confirgurable products ============================*/ 
 
 elseif(isset($_REQUEST['importdata'])) :

  echo "<pre>",print_r($_REQUEST['product_attr_col']) ,"</pre>";  
  $product_attr_col_flip = array_flip($_REQUEST['product_attr_col']);  
  //die;
  echo "<pre>",print_r($product_attr_col_flip) ,"</pre>";  //die;

/* ********************************check the headers fields having required attributes starts ******************** */

$csv_product_attr_col = array();
$csv_product_attr_headercol = $_REQUEST['product_attr_col'];
foreach($required_attributes as $attr){

   if(!in_array($attr,$csv_product_attr_headercol)):
   
      if($error_message=="") {
      	
      	$error_message ="<h2>Following Attributes are Missing. Please add the attributes and continue to import data</h2>";
      }	
       $error_message.="<span style='color:red'>".$attr." is missing in the csv file</span><br><br>";
   endif;


}
if($error_message!=""){
  $self = $_SERVER['PHP_SELF'];
  echo $error_message;
  echo "<a href='$self'>Back to import csv file</a>";
  exit();

}

/* ****************************check the headers fields having required attributes ends ************************** */


$dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport");
$dp->beginImportSession("wears", "create", new TestLogger());

$filename =  str_replace('\\', '/', dirname(__FILE__)).'/uploads/configurable/configurable.csv';
$reader1 = new CSVReader( new FileReader( $filename ) );
$reader1->setSeparator( ',' );

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
$message ="";
$skipped ="no";
$get_all_simples_skus = array();
$get_all_simples_attributes_values = array();

while( false != ( $cell = $reader1->next() ) )
{
 if($rows != 1) // Skipping the headers row
 {
   /* =========================Create Simple products with required attributes ==================================*/
       
       $get_all_simples_skus = explode(",",$cell[$simples_skus_cell_no]);
       $get_all_simples_attributes_values = explode(",",$cell[$simples_attributes_values_cell_no]);
       
       if(count($get_all_simples_skus) == count($get_all_simples_attributes_values)) :
        // checks the simple skus and simple attributes are equal
       		for($i=0;$i < count($get_all_simples_skus);$i++) {
       			  
       			  $item = array("store"=>"admin","type"=>"simple","sku"=>$get_all_simples_skus[$i],
   	                   "description"=> $cell[$description_cell_no],"short_description"=> $cell[$short_description_cell_no]
   	                   ,"attribute_set"=>$cell[$attribute_set_cell_no],
   	                   "price"=>$cell[$price_cell_no],"qty"=>$cell[$qty_cell_no],"visibility"=>1,
   	                   "status"=>$cell[$status_cell_no],"tax_class_id"=>$cell[$tax_class_id_cell_no],
   	                   'is_qty_decimal'=>$cell[$is_qty_decimal_cell_no],'is_in_stock'=>$cell[$is_in_stock_cell_no]); //      ,"name"=>$cell[$name_cell_no] . $size[$i]." ".$color,"color"=>$color,"size"=>$size[$i],
                 $attr_labels = explode("_",$cell[$simples_attributes_labels_cell_no]);   
                 $concat_attr = "";
                 $attr_values = explode("_",$get_all_simples_attributes_values[$i]);
                 for($attr_value =0;$attr_value < count($attr_values);$attr_value++){
                	  	    		$getAttrLabel = $attr_labels[$attr_value];
                	  	    		$getAttrValue = $attr_values[$attr_value];
                	  	    		$item[$getAttrLabel] = $getAttrValue;
                	  	    		$concat_attr.= $getAttrValue." ";
                 } 	
                 $item['name']=$cell[$name_cell_no];
                 $dp->ingest($item);          
               
       	   }		
       
       else :  // checks the simple skus and simple attributes are not equal
            $skipped = "yes";
       		$message.=$cell[$sku_cell_no] ."is row skipped due to simple skus and simple attributes are not equal values<br>";
       
       endif;
       
   
   /* =========================Create Simple products with required attributes ==================================*/
   
   
   /* =========================Create Configurable products with required attributes ============================*/
 
       if($skipped == "no") :
            
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
                $message.=$cell[$sku_cell_no] ."is successfully imported<br>";
                
       endif;

   /* =========================Create configurable products with required attributes ============================*/
 }
 $rows++;
 $skipped ="no";
}
echo $message."here only";
die;
/* end import session, will run post import plugins */
$dp->endImportSession();

/* ================================Initially form to upload csv file ============================*/

else:
$self = $_SERVER['PHP_SELF'];

print "<center style='margin:20px'><form enctype='multipart/form-data' action='$self' method='post'>";
print "<p>Upload CSV file to import products:</p>\n";
echo '<table cellpadding=2 cellspacing=1 bgcolor="#fff" border=1 style="border-color:#cecece">';
echo "<tr>\n";
print "<td>Choose CSV file to upload products</td><td>
<input size='50' type='file' name='csv_import' id='csv_import'></td></tr>\n";
print "<tr><td colspan='2' align='center'><input type='submit' name='importcsv' value='Import CSV'></td>";
echo "</tr>\n";
print "</form></center>";
endif;
 ?>
 
</body>
</html>
