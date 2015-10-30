<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author kserwin
 */
class First_Module_Model_Product extends Mage_Catalog_Model_Product {
    public function getName() {
        return parent::getName() . ' - changed name';
    }
}
