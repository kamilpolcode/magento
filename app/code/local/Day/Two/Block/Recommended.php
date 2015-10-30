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
class Day_Two_Block_Recommended extends Mage_Core_Block_Template {
    
  public function getRecommended() {
     
    // call model to fetch data
    $model = Mage::getModel("day_two/recommended");
    $products = $model->getRecommended();
    $arr_products = array();
    foreach ($products as $product) {
      $arr_products[] = array(
        'id' => $product->getId(),
        'name' => $product->getName(),
        'url' => $product->getProductUrl(),
        'img' => (string)Mage::helper('catalog/image')->init($product, 'image')
      );
    }

    return $arr_products;
  }
  
}