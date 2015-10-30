<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bestsellers
 *
 * @author kserwin
 */
class Day_Two_Block_Bestsellers extends Mage_Core_Block_Template {
    
  public function getBestSellers() {
     
    // call model to fetch data
    $model = Mage::getModel("day_two/bestsellers");
    $products = $model->getBestSellers();
    $arr_products = array();
    
    foreach ($products as $product) {
       /* $smallImage = (string)Mage::helper('catalog/image')->init(
        $product,
        'image'
    )->resize(200, 200); 
        echo "<pre>";
        print_r($smallImage);
        echo "</pre>";
        */
        
      $arr_products[] = array(
        'id' => $product->getId(),
        'name' => $product->getName(),
        'url' => $product->getProductUrl(),
        'img' => (string)Mage::helper('catalog/image')->init($product, 'small_image'),
        'price' => $product->getMinimalPrice(),
        'special_price' => $product->getSpecialPrice(),
        'description'=> $product->getShortDescription(),
      );
    }

    return $arr_products;
  }
  
}