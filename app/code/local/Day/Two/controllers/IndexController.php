<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author kserwin
 */
class Day_Two_IndexController extends Mage_Core_Controller_Front_Action {
    //put your code here
    
    public function indexAction() {
        echo 'index controller of our action';   
    }
    
    public function modelAction() {
        echo 'xxx';
        var_dump(Mage::getModel('day_two/whatever'));
    }
    
    public function layoutAction() {
        $xml = $this->loadLayout()->getLayout()->getUpdate()->asString();
        $this->getResponse()->setHeader('Content-Type', 'text/xml')->setBody($xml);
        
        Mage::log($xml, Zend_Log::INFO, 'layout.log', true);
    }
    
    public function defaultAction() {
        $this->loadLayout()->renderLayout();
    }
}
