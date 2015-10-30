<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author kserwin
 */
class Day_Two_Model_Debug_Layout {
  public function logCompiledLayout($o) {
    $req = Mage::app()->getRequest();

    $routeName = $req->getRouteName();
    $fullname = $req->getRequestedRouteName() . '_' . $req->getRequestedControllerName() . '_' . $req->getRequestedActionName();

    $info = sprintf(
      "\nRequest: %s\nFull Action Name: %s\nHandles:\n\t%s\n",
      $routeName, $fullname, implode("\n\t", $o->getLayout()->getUpdate()->getHandles())
    );

    
    Mage::log($info, Zend_Log::DEBUG, 'debug.'.$routeName.'.layout.log', true);
    file_put_contents(Mage::getBaseDir('log').DS.'debug.'.$routeName.'.layout.xml',
                      '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL
                      .'<layout>'.PHP_EOL.
                      $o->getLayout()->getUpdate()->asString().
                      '</layout>');
    
  }
}