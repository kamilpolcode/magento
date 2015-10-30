<?php

include 'app/Mage.php';

umask(0);

Mage::app();

//$object = Mage::getModel('catalog/product')->load(1);
//var_dump($object->getName());

//$object = Mage::app()->getLayout()->createBlock('catalog/product_view');

//$object = Mage::getResourceModel('catalog/product');

//$object = Mage::helper('sales/data');


$object = Mage::helper('customer/address');

Mage::getModel('day_two/__');
Mage::helper('day_two/__');
Mage::app()->getLayout();


echo get_class($object);

