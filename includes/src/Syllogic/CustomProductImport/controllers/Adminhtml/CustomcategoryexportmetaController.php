<?php
class Syllogic_CustomProductImport_Adminhtml_CustomcategoryexportmetaController extends Mage_Adminhtml_Controller_Action
{
public function indexAction()
    {
  
       $this->loadLayout();
       $this->_title($this->__("Export Meta Information for Categories"));
        
	    $this->renderLayout();
	   
    }
        
    public function postAction()
    { //$this->loadLayout();
      // $this->_title($this->__("Export Meta Information for Categories"));
       //$this->renderLayout();
       umask(0);
      $category = Mage::getModel ( 'catalog/category' );
   	$tree = $category->getTreeModel ();
   	$tree->load();
    	$ids = $tree->getCollection()->getAllIds();
      if ($ids) {
    	$string='';
    	$heading = '"cat_id","categories","meta_title","meta_keywords","meta_description",';
   	foreach ($ids as $id) {
    	 if($id>0)//start if removeroot category and default category .
    	 {
				$cate_cre = Mage::getModel('catalog/category');
				$cate_cre->load($id);
    			$treeurl='';
    			$cate_cre1=Mage::getModel('catalog/category')->load($id);
    			$treeurl=$cate_cre->getName();
    			if($cate_cre1->getParentId()>0)
    			{
    						for($i=0; ;$i++)
    						{
    									if($cate_cre1->getParentId()>0)
    									{
    												$abc=Mage::getModel('catalog/category')->load($cate_cre1->getParentId());
    												$pCat=$abc->getName();
    												if($abc->getId()>1){
    															$treeurl=$pCat.'/'.$treeurl;
    												}
    												$cate_cre1=$abc;
    									}
    									else{
    												break;
    									}			
    						}
    			}
       $store = "default";
       $string .='"'.$id.'","'.$treeurl.'","'.$cate_cre->getMetaTitle().'","'.$cate_cre->getMetaKeywords().'","'.$cate_cre->getMetaDescription().'"';
       $string.="\n";
      }//endof if removeroot category and default category .
    }

    $csv_output = $heading ."\n".$string;
    $filename = "Categories";
    header("Content-type: application/vnd.ms-excel");
    header("Content-disposition: csv" . date("Y-m-d") . ".csv");
    header( "Content-disposition: filename=".$filename.".csv");
    print $csv_output;	
     $this->_prepareDownloadResponse($filename.".csv");	
    }
  }
}