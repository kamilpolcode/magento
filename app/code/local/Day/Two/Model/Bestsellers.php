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
class Day_Two_Model_Bestsellers extends Mage_Core_Model_Abstract {

    public function getBestSellers() {
        $products = array();        
        $model = Mage::getModel("catalog/product");
        $products = $model->getCollection()
                        ->addAttributeToSelect('*')
                        ->setOrder('entity_id', 'DESC')
                        ->setPageSize(6);
                        
        return $products;
    }
}
