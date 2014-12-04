<?php
require 'app/Mage.php';
 ini_set('display_errors', 1);
Mage::setIsDeveloperMode(true);
umask(0);
Mage::app("default");
try {
            Mage::getModel('catalogrule/rule')->applyAll();
            Mage::app()->removeCache('catalog_rules_dirty');
            echo Mage::helper('catalogrule')->__('The rules have been applied.');
        } catch (Exception $e) {
            echo Mage::helper('catalogrule')->__('Unable to apply rules.');
            print_r($e);
        }

?>